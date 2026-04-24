<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskComment;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    protected $common;

    public function __construct()
    {
        $this->middleware('auth');
        $this->common = new CommonController();
    }

    public function create()
    {
        $content['module'] = 'Task';
        $content['title'] = 'Create New Task';
        $content['name'] = 'Task';
        $content['staffUsers'] = User::where('role', 2)->where('role_type', 'Staff')->where('status', '1')->orderBy('name')->get();

        return view('admin.task.create', $content);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,review,completed',
            'assigned_staff' => 'required|array|min:1',
            'assigned_staff.*' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $formData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'created_by' => Auth::id(),
        ];

        if ($request->file('image')) {
            $this->common->makeDirCheck('./uploads/tasks');
            $formData['image'] = $this->common->fileUpload($request->file('image'), './uploads/tasks');
        }

        $task = new Task($formData);
        if (!$task->save()) {
            $request->session()->flash('error', 'Unable to create task.');
            return redirect()->back()->withInput();
        }

        $staffIds = array_unique($request->input('assigned_staff', []));
        foreach ($staffIds as $staffId) {
            TaskAssignment::create([
                'task_id' => $task->id,
                'user_id' => $staffId
            ]);
        }

        logsCreate([
            'action_by' => Auth::id(),
            'module_name' => 'Task',
            'action' => 'Create',
            'message' => 'New task created'
        ]);

        $request->session()->flash('success', 'Task has been created successfully.');
        return redirect()->route('admin.task.manage');
    }

    public function show()
    {
        $content['name'] = 'Task';
        $content['module'] = 'Task';
        $content['title'] = 'All Tasks';
        $content['staffUsers'] = User::where('role', 2)->where('role_type', 'Staff')->where('status', '1')->orderBy('name')->get();

        return view('admin.task.list', $content);
    }

    public function showList(Request $request)
    {
        $record = Task::query()->with('assignments.user');

        if ($request->has('status') && $request->get('status') != "") {
            $record->where('status', $request->get('status'));
        }

        if ($request->has('assigned_staff') && $request->get('assigned_staff') != "") {
            $staffId = $request->get('assigned_staff');
            $record->whereHas('assignments', function ($query) use ($staffId) {
                $query->where('user_id', $staffId);
            });
        }

        return DataTables::of($record)
            ->editColumn('status', function ($task) {
                $status = ucwords(str_replace('_', ' ', $task->status));
                if ($task->status == 'pending') {
                    return '<span class="badge badge-soft-warning">' . $status . '</span>';
                } elseif ($task->status == 'in_progress') {
                    return '<span class="badge badge-soft-info">' . $status . '</span>';
                } elseif ($task->status == 'review') {
                    return '<span class="badge badge-soft-primary">' . $status . '</span>';
                }
                return '<span class="badge badge-soft-success">' . $status . '</span>';
            })
            ->editColumn('assigned_staff', function ($task) {
                $names = [];
                foreach ($task->assignments as $assignment) {
                    if (!empty($assignment->user) && !empty($assignment->user->name)) {
                        $names[] = $assignment->user->name;
                    }
                }
                return !empty($names) ? implode(', ', $names) : 'N/A';
            })
            ->editColumn('created_at', function ($task) {
                return date("Y-m-d", strtotime($task->created_at));
            })
            ->addColumn('actions', function ($task) {
                $actions = '<a href="' . route('admin.task.edit', $task->id) . '" class="on-default"><i class="ti ti-pencil-minus"></i></a>';
                $actions .= '<a href="' . route('admin.task.view', $task->id) . '" class="on-default"><i class="ti ti-eye"></i></a>';
                $actions .= '<a href="javascript:void(0);" data-url="' . route('admin.task.delete', $task->id) . '" class="on-default sa-warning"><i class="ti ti-trash"></i></a>';
                return $actions;
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function edit($id)
    {
        $task = Task::with('assignments')->findOrFail($id);

        $content['name'] = 'Task';
        $content['module'] = 'Task';
        $content['title'] = 'Edit Task';
        $content['task'] = $task;
        $content['staffUsers'] = User::where('role', 2)->where('role_type', 'Staff')->where('status', '1')->orderBy('name')->get();
        $content['assignedStaffIds'] = $task->assignments->pluck('user_id')->toArray();

        return view('admin.task.edit', $content);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,review,completed',
            'assigned_staff' => 'required|array|min:1',
            'assigned_staff.*' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->status = $request->input('status');

        if ($request->file('image')) {
            $this->common->makeDirCheck('./uploads/tasks');
            if (!empty($task->image)) {
                $this->common->fileDel('./uploads/tasks/' . $task->image);
            }
            $task->image = $this->common->fileUpload($request->file('image'), './uploads/tasks');
        }

        $task->save();

        $staffIds = array_unique($request->input('assigned_staff', []));
        TaskAssignment::where('task_id', $task->id)->delete();
        foreach ($staffIds as $staffId) {
            TaskAssignment::create([
                'task_id' => $task->id,
                'user_id' => $staffId
            ]);
        }

        logsCreate([
            'action_by' => Auth::id(),
            'module_name' => 'Task',
            'action' => 'Edit',
            'message' => 'Task updated'
        ]);

        $request->session()->flash('success', 'Task has been updated successfully.');
        return redirect()->route('admin.task.manage');
    }

    public function view($id)
    {
        $task = Task::with(['assignments.user', 'comments.user'])->findOrFail($id);

        $content['name'] = 'Task';
        $content['module'] = 'Task';
        $content['title'] = 'Task Details';
        $content['task'] = $task;
        $content['comments'] = $task->comments()->with('user')->latest()->get();

        return view('admin.task.view', $content);
    }

    public function addCommentForStaff(Request $request, $id, $staffId)
    {
        $task = Task::findOrFail($id);

        $isAssigned = TaskAssignment::where('task_id', $id)->where('user_id', $staffId)->exists();
        if (!$isAssigned) {
            abort(404, 'Staff is not assigned to this task.');
        }

        $request->validate([
            'comment' => 'required|string'
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment_for_user_id' => $staffId,
            'comment' => $request->input('comment')
        ]);

        logsCreate([
            'action_by' => Auth::id(),
            'module_name' => 'Task',
            'action' => 'Comment',
            'message' => 'Admin comment added for staff on task'
        ]);

        $request->session()->flash('success', 'Comment posted for selected staff.');
        return redirect()->back();
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,review,completed',
        ]);

        $task = Task::findOrFail($id);
        $task->status = $request->input('status');
        $task->save();

        logsCreate([
            'action_by' => Auth::id(),
            'module_name' => 'Task',
            'action' => 'Edit',
            'message' => 'Task status updated'
        ]);

        $request->session()->flash('success', 'Task status updated successfully.');
        return redirect()->back();
    }

    public function delete($id = '')
    {
        $task = Task::find($id);
        if (!$task) {
            echo 0;
            die();
        }

        if (!empty($task->image)) {
            $this->common->fileDel('./uploads/tasks/' . $task->image);
        }

        TaskComment::where('task_id', $task->id)->delete();
        TaskAssignment::where('task_id', $task->id)->delete();
        $deleted = $task->delete();

        if ($deleted) {
            logsCreate([
                'action_by' => Auth::id(),
                'module_name' => 'Task',
                'action' => 'Delete',
                'message' => 'Task deleted'
            ]);
        }

        echo $deleted ? 1 : 0;
        die();
    }
}
