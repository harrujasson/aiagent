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
        $event = $this->extractEventType($request->get('query'));
        //echo $event;
        $dates = $this->getDateKeyword($request->get('query'));
        //echo "<pre>"; print_r($dates); die();
        $start = ($dates['start_date'] !="" ? $dates['start_date'] : date('Y-m-d'));
        $end = ($dates['end_date'] !="" ? $dates['end_date'] : date('Y-m-d'));
        //echo "<pre>"; print_r($start); print_r($end); die();
        $this->data = $this->getSheetDataByDateRange($start,$end,$event);
        //echo "<pre>"; print_r($this->data); die();
        $this->filterdata = $this->filterData($this->data);
        $result = $this->generateReport($request->get('query'));
        return response()->json([
            'success' => true,
            'data'    => $result['report'],
        ]);
    }
    function extractEventType($query){
        preg_match(
            '/Event[:\s]+(.*?)(?=\s+(for|this|today|month|year|week|day|report|info)\b|$)/i',
            $query,
            $matches
        );
    
        return trim($matches[1] ?? '');
    }

    function getDateKeyword($reportInstruction=''){
        $instruction = strtolower(trim($reportInstruction));
        $startDate = null;
        $endDate = null;

        if(str_contains($instruction, 'compare')){
            if(str_contains($instruction, 'compare last month to this month')){
                $startDate = Carbon::now()
                ->subMonth()
                ->startOfMonth()
                ->toDateString();

                $endDate = Carbon::now()
                ->toDateString();
            }else if(str_contains($instruction, 'compare last week to this week')){
                $startDate = Carbon::now()
                ->subWeek()
                ->startOfWeek()
                ->toDateString();
                $endDate = Carbon::now()
                ->endOfWeek()
                ->toDateString();
            }else{

                $startDate = Carbon::now()->startOfWeek()->toDateString();
                $endDate = Carbon::now()->endOfWeek()->toDateString();
            }


        }else{
            // TODAY
            if (str_contains($instruction, 'today')) {

                $startDate = Carbon::today()->startOfDay()->toDateString();
                $endDate = Carbon::today()->endOfDay()->toDateString();

            }

            // YESTERDAY
            elseif (str_contains($instruction, 'yesterday')) {

                $startDate = Carbon::yesterday()->startOfDay()->toDateString();
                $endDate = Carbon::yesterday()->endOfDay()->toDateString();

            }

            // THIS WEEK
            elseif (str_contains($instruction, 'this week')) {

                $startDate = Carbon::now()->startOfWeek()->toDateString();
                $endDate = Carbon::now()->endOfWeek()->toDateString();

            }

            elseif (str_contains($instruction, 'this week')) {

                $startDate = Carbon::now()->startOfWeek()->toDateString();
                $endDate = Carbon::now()->endOfWeek()->toDateString();

            }

            // LAST TWO WEEKS
            elseif (
                str_contains($instruction, 'last two week') ||
                str_contains($instruction, 'last 2 week')
            ) {

                $startDate = Carbon::now()->subWeeks(2)->startOfDay()->toDateString();
                $endDate = Carbon::now()->endOfDay()->toDateString();

            }


            // THIS MONTH
            elseif (str_contains($instruction, 'this month')) {

                $startDate = Carbon::now()->startOfMonth()->toDateString();
                $endDate = Carbon::now()->endOfMonth()->toDateString();

            }else{
                $startDate = Carbon::now()->startOfWeek()->toDateString();
                $endDate = Carbon::now()->endOfWeek()->toDateString();
            }

        }

        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        return $data;

        // FILTER DATA
        // if ($startDate && $endDate) {

        //     $filteredData = array_filter($dataText, function ($row) use ($startDate, $endDate) {

        //         if (empty($row['preferred_date'])) {
        //             return false;
        //         }

        //         $date = Carbon::parse($row['preferred_date']);

        //         return $date->between($startDate, $endDate);

        //     });

        //     $filteredData = array_values($filteredData);

        // } else {

        //     $filteredData = $dataText;

        // }
    }

    function test(){
    }

    public function getSheetDataByDateRange($startDate, $endDate,$eventType=""){
        $url = "https://docs.google.com/spreadsheets/d/" . $this->sheetId . "/export?format=csv&gid=" . $this->gid;

        $response = Http::get($url);

        if ($response->failed()) {
            return ['error' => 'Failed to fetch sheet'];
        }

         // Create temporary stream
        $temp = fopen('php://temp', 'r+');

        fwrite($temp, $response->body());

        rewind($temp);

        $rows = [];

        // Proper CSV parsing
        while (($data = fgetcsv($temp)) !== false) {

            $rows[] = $data;

        }

        fclose($temp);
        if (empty($rows)) {
            return [];
        }

        // Header row
        $headers = array_map('trim', $rows[0]);

        // Find Submission Date column
        $dateIndex = array_search('Submission Date', $headers);
        $eventIndex = array_search('Type  of event', $headers);
        if ($dateIndex === false) {
            return ['error' => 'Submission Date column not found'];
        }
        if ($eventType && $eventIndex === false) {
            return ['error' => 'Type  of event column not found'];
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

                // Event filter
                if ($eventType) {

                    $rowEvent = strtolower(trim($row[$eventIndex] ?? ''));
                    $searchEvent = strtolower(trim($eventType));
                
                    // Remove special chars
                    $rowEventClean = preg_replace('/[^a-z0-9]/i', ' ', $rowEvent);
                    $searchEventClean = preg_replace('/[^a-z0-9]/i', ' ', $searchEvent);
                
                    // Split into words
                    $searchWords = array_filter(explode(' ', $searchEventClean));
                
                    $matched = false;
                
                    foreach ($searchWords as $word) {
                
                        if (strlen($word) < 3) {
                            continue;
                        }
                
                        if (stripos($rowEventClean, $word) !== false) {
                            $matched = true;
                            break;
                        }
                    }
                
                    if (!$matched) {
                        continue;
                    }
                }
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
        //echo "<pre>"; print_r($filteredData); die();
        $response = Http::timeout(120)
        ->connectTimeout(30)
        ->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4.1',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a senior AI event operations analyst.

                    Your job is to generate executive-level operational reports from lead datasets.
                    
                    BUSINESS RULES:
                    - Cristian handles ONLY Wedding events.
                    - Ernie handles ALL non-Wedding events.
                    - Use ONLY the event_type field for categorization.
                    - Ignore misleading wording inside notes for primary categorization.
                    - Notes may ONLY be used for deeper sub-category insights.

                    CLASSIFICATION RULES:
                    - Use event_type as the PRIMARY category.
                    - NEVER override primary category using notes.
                    - Use notes ONLY for:
                    - sub-category enrichment
                    - operational insights
                    - event intent detection
                    - grouping similar event purposes
                    - Notes may ONLY be used for:
                        - other events
                        - subcategory grouping
                        - operational insights
                        - event intent analysis


                    REPORT REQUIREMENTS:
                    
                    1. Generate separate sections for:
                    - Cristian
                    - Ernie
                    
                    2. Cristian section:
                    - summarize Wedding consistency
                    - include Wedding totals
                    - include concise operational insight
                    - summarize Wedding consistency
                    - calculate total Wedding leads
                    - provide concise operational insight
                    - Show Total of all lead category

                    3. Ernie section:
                    - summarize broader event diversity
                    - show top event categories with totals
                    - calculate overall totals
                    - calculate totals for ALL non-Wedding events
                    - identify top event categories
                    - calculate total Ernie leads
                    - Show Total of all lead category

                    4. Generate intelligent other events breakdowns for Ernie:
                    Examples:
                    - Social Celebrations
                    - Life Events
                    - Professional / Corporate
                    - Private Gatherings
                    - Unique / Edge Cases
                    
                    5. Analyze preferred dates:
                    - identify busiest dates
                    - identify repeated demand periods
                    - identify seasonal trends
                    - identify highest competition dates


                    7. Generate "Other Event Type Breakdown"
                    Using notes and event_type intelligently, group events into operational buckets such as:
                    - Social Celebrations
                    - Corporate / Professional
                    - Family Gatherings
                    - Religious / Life Events
                    - Private Events
                    - Unique / Specialty Requests

                    8. Date Analysis
                    Generate:
                    - Seprate "Ernie Leads by Preferred Date"
                    - Most Requested Dates
                    - Highest Competition Dates
                    - Secondary Demand Dates
                    - Seasonal Demand Trends
                    - All Other Dates summary

                    9. DATE ANALYSIS RULES
                    - Count repeated preferred dates
                    - Dates with highest frequency should appear under "Most Requested Dates"
                    - Dates appearing once should be summarized under "All Other Dates"
                    - Identify concentrated demand periods

                    10. COUNTING RULES
                    - Calculate totals directly from dataset
                    - Use exact counts whenever possible
                    - Use approximate values only when categorization is uncertain

                    STYLE RULES:
                    - Use professional operational reporting tone
                    - Use concise executive commentary
                    - Add relevant emojis to ALL major headings
                    - Add emojis to subsection headings where appropriate
                    - Use structured readable formatting
                    - Return CLEAN HTML ONLY
                    - Do NOT use markdown
                    - Do NOT use tables

                    EMOJI EXAMPLES:
                    📊 Report Summary
                    👰 Cristian Lead Analysis
                    🎉 Ernie Event Breakdown
                    🔥 Most Requested Dates
                    📈 Demand Trends
                    🧠 Operational Insights
                    👨‍👩‍👧 Private Gatherings
                    💼 Corporate Events
                    🎓 Life Events
                    📅 Seasonal Demand

                    
                    ALLOWED HTML:
                    <h2>
                    <h3>
                    <h4>
                    <p>
                    <ul>
                    <li>
                    <strong>
                    <br>

                    Also:
                    - summarize most requested dates
                    - identify busiest periods
                    - calculate total leads per category
                    
                    IMPORTANT:
                    - Use exact counts whenever possible
                    - If grouping requires approximation, clearly indicate approximate counts
                    - Keep insights operational and business-focused
                    - Do not generate fictional data'
                ],
                [
                    'role' => 'user',
                    'content' =>  "User Request:{$instruction}
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
    public function generateReportVer2($reportInstruction='Show report only for Ernie'){

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
                    'content' => 'You are a senior AI event operations analyst.

                    Your job is to generate executive-level operational reports from lead datasets.
                    
                    BUSINESS RULES:
                    - Cristian handles ONLY Wedding events.
                    - Ernie handles ALL non-Wedding events.
                    - Use ONLY the event_type field for categorization.
                    - Ignore misleading wording inside notes for primary categorization.
                    - Notes may ONLY be used for deeper sub-category insights.

                    CLASSIFICATION RULES:
                    - Use event_type as the PRIMARY category.
                    - NEVER override primary category using notes.
                    - Use notes ONLY for:
                    - sub-category enrichment
                    - operational insights
                    - event intent detection
                    - grouping similar event purposes
                    - Notes may ONLY be used for:
                        - other events
                        - subcategory grouping
                        - operational insights
                        - event intent analysis


                    REPORT REQUIREMENTS:
                    
                    1. Generate separate sections for:
                    - Cristian
                    - Ernie
                    
                    2. Cristian section:
                    - summarize Wedding consistency
                    - include Wedding totals
                    - include concise operational insight
                    - summarize Wedding consistency
                    - calculate total Wedding leads
                    - provide concise operational insight
                    - Show Total of all lead category
                    
                    3. Ernie section:
                    - summarize broader event diversity
                    - show top event categories with totals
                    - calculate overall totals
                    - calculate totals for ALL non-Wedding events
                    - identify top event categories
                    - calculate total Ernie leads
                    - Show Total of all lead category
                    
                    4. Generate intelligent other events breakdowns for Ernie:
                    Examples:
                    - Social Celebrations
                    - Life Events
                    - Professional / Corporate
                    - Private Gatherings
                    - Unique / Edge Cases
                    
                    5. Analyze preferred dates:
                    - identify busiest dates
                    - identify repeated demand periods
                    - identify seasonal trends
                    - identify highest competition dates
                    
                    6. Generate concise operational insights:
                    - consistency
                    - demand concentration
                    - event diversity
                    - seasonality

                    7. Generate "Other Event Type Breakdown"
                    Using notes and event_type intelligently, group events into operational buckets such as:
                    - Social Celebrations
                    - Corporate / Professional
                    - Family Gatherings
                    - Religious / Life Events
                    - Private Events
                    - Unique / Specialty Requests

                    8. Date Analysis
                    Generate:
                    - Most Requested Dates
                    - Highest Competition Dates
                    - Secondary Demand Dates
                    - Seasonal Demand Trends
                    - All Other Dates summary

                    9. DATE ANALYSIS RULES
                    - Count repeated preferred dates
                    - Dates with highest frequency should appear under "Most Requested Dates"
                    - Dates appearing once should be summarized under "All Other Dates"
                    - Identify concentrated demand periods

                    10. COUNTING RULES
                    - Calculate totals directly from dataset
                    - Use exact counts whenever possible
                    - Use approximate values only when categorization is uncertain
                    
                    STYLE RULES:
                    - Use professional operational reporting tone
                    - Use concise executive commentary
                    - Use structured readable formatting
                    - Return CLEAN HTML ONLY
                    - Do NOT use markdown
                    - Do NOT use tables
                    
                    ALLOWED HTML:
                    <h2>
                    <h3>
                    <h4>
                    <p>
                    <ul>
                    <li>
                    <strong>
                    <br>

                    Also:
                    - summarize most requested dates
                    - identify busiest periods
                    - calculate total leads per category
                    
                    IMPORTANT:
                    - Use exact counts whenever possible
                    - If grouping requires approximation, clearly indicate approximate counts
                    - Keep insights operational and business-focused
                    - Do not generate fictional data'
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
    public function generateReportVer1($reportInstruction='Show report only for Ernie'){

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
