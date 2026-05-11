<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $data;
    protected $filterdata;
    protected $sheetId;
    protected $gid;
    public function __construct()
    {
        $this->middleware('auth');
        $this->common=new CommonController();
        $this->sheetId = '1o4y04IP2QM3hb-2ss4CkQo4tN2Ghk2AVNBOHPeSFy2k';
        $this->gid ='825279720';
    }

    public function show(){
        $content['name'] = 'Report';
        $content['module'] = 'Report';
        $content['title'] = 'Report - AI Agent';
        return view('admin.ai.show',$content);
    }

    function user_query(Request $request){
        $this->data = $this->getSheetDataByDateRange('2022-06-03','2022-06-05');
        $this->filterdata = $this->filterData($this->data);
        $result = $this->generateReport($request->get('query'));
        return response()->json([
            'success' => true,
            'data'    => $result['report'],
        ]);
    }

    function getDateKeyword($reportInstruction=''){
        $instruction = strtolower(trim($reportInstruction));
        $startDate = null;
        $endDate = null;
        // TODAY
        if (str_contains($instruction, 'today')) {

            $startDate = Carbon::today()->startOfDay();
            $endDate = Carbon::today()->endOfDay();

        }

        // YESTERDAY
        elseif (str_contains($instruction, 'yesterday')) {

            $startDate = Carbon::yesterday()->startOfDay();
            $endDate = Carbon::yesterday()->endOfDay();

        }

        // THIS WEEK
        elseif (str_contains($instruction, 'this week')) {

            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();

        }

        // LAST TWO WEEKS
        elseif (
            str_contains($instruction, 'last two week') ||
            str_contains($instruction, 'last 2 week')
        ) {

            $startDate = Carbon::now()->subWeeks(2)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

        }

        // THIS MONTH
        elseif (str_contains($instruction, 'this month')) {

            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();

        }

        // FILTER DATA
        if ($startDate && $endDate) {

            $filteredData = array_filter($dataText, function ($row) use ($startDate, $endDate) {

                if (empty($row['preferred_date'])) {
                    return false;
                }

                $date = Carbon::parse($row['preferred_date']);

                return $date->between($startDate, $endDate);

            });

            $filteredData = array_values($filteredData);

        } else {

            $filteredData = $dataText;

        }
    }

    function test(){
    }

    public function getSheetDataByDateRange($startDate, $endDate){
        $url = "https://docs.google.com/spreadsheets/d/" . $this->sheetId . "/export?format=csv&gid=" . $this->gid;

        $response = Http::get($url);

        if ($response->failed()) {
            return ['error' => 'Failed to fetch sheet'];
        }

        // CSV rows
        $lines = preg_split("/\r\n|\n|\r/", $response->body());
        $rows = array_map('str_getcsv', $lines);
        $rows = array_filter($rows);

        if (empty($rows)) {
            return [];
        }

        // Header row
        $headers = array_map('trim', $rows[0]);

        // Find Submission Date column
        $dateIndex = array_search('Submission Date', $headers);

        if ($dateIndex === false) {
            return ['error' => 'Submission Date column not found'];
        }

        $filtered = [];

        // Normalize dates
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate   = date('Y-m-d', strtotime($endDate));

        // Skip header row
        foreach (array_slice($rows, 1) as $row) {

            if (!isset($row[$dateIndex])) {
                continue;
            }

            // Convert sheet date
            $rowDate = date('Y-m-d', strtotime($row[$dateIndex]));

            // Check date range
            if ($rowDate >= $startDate && $rowDate <= $endDate) {

                // Prevent column mismatch
                $row = array_pad($row, count($headers), null);

                // Convert to associative array
                $filtered[] = array_combine($headers, $row);
            }
        }

        return $filtered;
    }
    public function getEventData($eventType =''){
        $url = "https://docs.google.com/spreadsheets/d/".$this->sheetId."/export?format=csv&gid=".$this->gid;

        $response = Http::get($url);

        if ($response->failed()) {
            return ['error' => 'Failed to fetch sheet'];
        }

        $lines = preg_split("/\r\n|\n|\r/", $response->body());
        $rows = array_map('str_getcsv', $lines);
        $rows = array_filter($rows);

        // Normalize header
        $header = array_map(fn($h) => strtolower(preg_replace('/\s+/', ' ', trim($h))), $rows[0]);

        $typeIndex = array_search('type of event', $header);

        if ($typeIndex === false) {
            return ['error' => 'Column not found'];
        }

        // Normalize input
        $searchValues = is_array($eventType)
            ? $eventType
            : explode('/', $eventType);

        $searchValues = array_map(fn($e) => strtolower(trim($e)), $searchValues);

        // 🔥 Correct filtering
        $filtered = collect($rows)
            ->skip(1)
            ->filter(function ($row) use ($typeIndex, $searchValues) {

                $value = strtolower(trim($row[$typeIndex] ?? ''));

                // Split sheet value also (important)
                $rowValues = explode('/', $value);
                $rowValues = array_map(fn($v) => trim($v), $rowValues);

                // Check if ANY value matches
                return count(array_intersect($rowValues, $searchValues)) > 0;
            })
            ->values()
            ->toArray();

        return $filtered;
    }

    function filterData($data){
        $cleanData = [];
        foreach ($data as $row) {

            $cleanData[] = [
        
                'event_type' => $row['Type  of event'] ?? '',

                'notes' => $row['Additional notes'] ?? '',
        
                'preferred_date' => $row['Submission Date'] ?? '',
            ];
        }
        return $cleanData;
    }

    public function generateReport($reportInstruction='Show report only for Ernie'){

        $dataText = $this->filterdata;

        $instruction = strtolower($reportInstruction);
        $filteredData = $dataText;
        // ONLY ERNIE
        if (strpos($instruction, 'ernie') !== false) {
            $filteredData = array_filter($dataText, function ($row) {
                return strtolower(trim($row['event_type'])) != 'wedding';
            });

        }
        // ONLY CRISTIAN
        elseif (strpos($instruction, 'cristian') !== false) {
            $filteredData = array_filter($dataText, function ($row) {
                return strtolower(trim($row['event_type'])) == 'wedding';
            });

        }
        $filteredData = array_values($filteredData);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4.1',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an AI event lead analyst.
                    Analyze ALL event types in the dataset unless the user explicitly requests a specific event type.


                    STRICT RULES:
                    - Use ONLY the event_type field for categorization
                    - Ignore keywords in notes for categorization
                    - If user requests general report, analyze ALL event types
                    - If user requests specific event type, ONLY analyze that type
                    - Never prioritize Wedding events
                    - Include totals for each event type


                    Also:
                    - summarize most requested dates
                    - identify busiest periods
                    - calculate total leads per category

                    Return CLEAN HTML only.

                    DO NOT use markdown.
                    DO NOT use tables.

                    Use:
                    <h2>
                    <h3>
                    <p>
                    <ul>
                    <li>
                    <strong>
                    <br>

                    Use professional operational reporting style.'
                ],
                [
                    'role' => 'user',
                    'content' =>  "User Request:{$reportInstruction}
                    Lead Data:" . json_encode($filteredData)
                ],
            ],
            'temperature' => 0,

        ]);

        $result = $response->json();

        // API error handling
        if (isset($result['error'])) {

            return [
                'success' => false,
                'message' => $result['error']['message']
            ];
        }

        return [
            'success' => true,
            'report' => $result['choices'][0]['message']['content'] ?? ''
        ];
    }
}
