<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskComment;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $taskIds = TaskAssignment::where('user_id', Auth::id())->pluck('task_id');

        $content['name'] = 'Task';
        $content['module'] = 'Task';
        $content['title'] = 'My Tasks';
        $content['tasks'] = Task::whereIn('id', $taskIds)->latest()->get();

        return view('staff.task.list', $content);
    }

    public function view($id)
    {
        $isAssigned = TaskAssignment::where('task_id', $id)->where('user_id', Auth::id())->exists();
        if (!$isAssigned) {
            abort(403, 'Task is not assigned to you.');
        }

        $task = Task::with('assignments.user')->findOrFail($id);

        $content['name'] = 'Task';
        $content['module'] = 'Task';
        $content['title'] = 'Task Details';
        $content['task'] = $task;
        $content['comments'] = TaskComment::where('task_id', $id)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhere('comment_for_user_id', Auth::id());
            })
            ->with('user')
            ->latest()
            ->get();

        return view('staff.task.view', $content);
    }

    public function addComment(Request $request, $id)
    {
        $isAssigned = TaskAssignment::where('task_id', $id)->where('user_id', Auth::id())->exists();
        if (!$isAssigned) {
            abort(403, 'Task is not assigned to you.');
        }

        $task = Task::findOrFail($id);
        if ($task->status === 'completed') {
            $request->session()->flash('error', 'You cannot comment on a completed task.');
            return redirect()->back();
        }

        $request->validate([
            'comment' => 'required|string'
        ]);

        TaskComment::create([
            'task_id' => $id,
            'user_id' => Auth::id(),
            'comment_for_user_id' => null,
            'comment' => $request->input('comment')
        ]);

        logsCreate([
            'action_by' => Auth::id(),
            'module_name' => 'Task',
            'action' => 'Comment',
            'message' => 'Comment added on task'
        ]);

        $request->session()->flash('success', 'Comment added successfully.');
        return redirect()->back();
    }
}
