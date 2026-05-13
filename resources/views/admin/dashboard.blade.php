@extends('layouts.master')
@section('title')
   {{$title}}
@endsection

@section('css')
<link  href="{{ URL::asset('build/css/vr-globals.css') }}"  rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

@endsection

@section('content')
{{-- 
@component('components.breadcrumb')
   @slot('li_1')
      Admin
   @endslot
   @slot('title')
      Dashboard
   @endslot
   @slot('page_title')
      <span class="dashboard-title">Dashboard</span>
   @endslot
@endcomponent
--}}

<div class="min-h-screen bg-background">
   <header class="border-b border-border bg-card expanded-header">
      <div class="p-6">
         <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary text-primary-foreground border" style="background-image:url(&quot;https://valleyrockinn.com/wp-content/uploads/2020/11/vr-tree.jpg&quot;); background-size: contain; background-position: center; background-repeat: no-repeat; background-color: transparent !important;">
               <i data-lucide="chart-column" class="h-6 w-6"></i>               
            </div>
            <div data-sg-el="src/components/DashboardHeader.tsx:11:10" data-sg-name="div">
               <h1 class="font-serif text-3xl font-bold text-foreground">VR Analytics Dashboard</h1>
               <p class="text-sm text-muted-foreground">Reporting with AI insights</p>
            </div>
         </div>
      </div>
   
    </header>


    <main class="py-8 space-y-8">

        <!-- <div class="cus-dashboard-header">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h2 class="font-serif text-2xl font-bold text-foreground">
                        May 2026
                    </h2>
                    <p class="text-sm text-muted-foreground">
                        Dashboard metrics for selected period
                    </p>
                </div>
                <div class="flex gap-3">
                    <button class="cus-date-btn inline-flex items-center gap-2 whitespace-nowrap rounded-md text-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 border-border dark:hover:bg-input/50 h-9 px-4 py-2 justify-start text-left font-normal w-[280px]" id="reportrange">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="mr-2 h-4 w-4">

                            <path d="M8 2v4"></path>
                            <path d="M16 2v4"></path>
                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                            <path d="M3 10h18"></path>

                        </svg>
                        <span>May 01, 2026 - May 31, 2026</span>
                        
                    </button>

                    <button class="cus-compare-btn inline-flex items-center gap-2 whitespace-nowrap rounded-md text-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 border-border dark:hover:bg-input/50 h-9 px-4 py-2 justify-start text-left font-normal w-[280px]" id="reportrange2">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="mr-2 h-4 w-4">

                            <path d="M8 2v4"></path>
                            <path d="M16 2v4"></path>
                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                            <path d="M3 10h18"></path>

                        </svg>
                        <span class="compare-label mr-1 text-xs">
                            Compare to:
                        </span>

                        <span class="compare-date">Apr 01 - Apr 30</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="cus-tabs-wrapper w-full">            
           
            <ul class="nav nav-pills cus-tabs-list items-center justify-center rounded-md p-1 text-muted-foreground grid w-full max-w-md mx-auto grid-cols-2 mb-8 bg-muted" id="dashboardTabs" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="cus-tab-btn active inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:shadow font-serif text-base data-[state=active]:bg-primary data-[state=active]:text-primary-foreground w-100"
                            id="event-sales-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#event-sales"
                            type="button"
                            role="tab">
                        Event Sales
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="cus-tab-btn inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:shadow font-serif text-base data-[state=active]:bg-primary data-[state=active]:text-primary-foreground w-100"
                            id="revenue-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#revenue"
                            type="button"
                            role="tab">
                        Revenue
                    </button>
                </li>

            </ul>
            
            <div class="tab-content" id="dashboardTabsContent">
               
                <div class="tab-pane fade show active" id="event-sales" role="tabpanel">

                    Event Sales Content Here

                </div>

                
                <div class="tab-pane fade" id="revenue" role="tabpanel">

                    Revenue Content Here

                </div>

            </div>
        </div> -->

        
        <section>
            <div class="mb-6">
                <h2 class="font-serif text-2xl font-bold text-foreground flex items-center gap-2">
                    <i data-lucide="trending-up" class="h-6 w-6 text-primary"></i>
                    Month-over-Month Performance
                </h2>

                <p class="text-muted-foreground mt-1">
                    Comparing April 2026 vs May 2026
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-lg border bg-card text-card-foreground shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6 pb-3">
                        <div class="font-semibold tracking-tight font-serif text-lg text-secondary">
                            Leads Last Month
                        </div>
                    </div>

                    <div class="p-6 pt-0 space-y-3">
                        <div class="font-mono text-3xl font-bold text-foreground tabular-nums">
                            124
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80 gap-1">
                                <i data-lucide="arrow-up" class="h-3 w-3"></i>
                                18.1%
                            </div>

                            <span class="text-sm text-muted-foreground">
                                vs 105 last month
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-card text-card-foreground shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6 pb-3">
                        <div class="font-semibold tracking-tight font-serif text-lg text-secondary">
                            Leads This Month
                        </div>
                    </div>

                    <div class="p-6 pt-0 space-y-3">
                        <div class="font-mono text-3xl font-bold text-foreground tabular-nums">
                            73
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-transparent bg-destructive/90 text-destructive-foreground shadow hover:bg-destructive gap-1">
                                <i data-lucide="arrow-down" class="h-3 w-3"></i>
                                41.1%
                            </div>

                            <span class="text-sm text-muted-foreground">
                                vs 124 last month
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-card text-card-foreground shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6 pb-3">
                        <div class="font-semibold tracking-tight font-serif text-lg text-secondary">
                            Revenue Last Month
                        </div>
                    </div>

                    <div class="p-6 pt-0 space-y-3">
                        <div class="font-mono text-3xl font-bold text-foreground tabular-nums">
                            $43,400.00
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80 gap-1">
                                <i data-lucide="arrow-up" class="h-3 w-3"></i>
                                13.6%
                            </div>

                            <span class="text-sm text-muted-foreground">
                                vs $38,192.00 last month
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-card text-card-foreground shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6 pb-3">
                        <div class="font-semibold tracking-tight font-serif text-lg text-secondary">
                            Revenue This Month
                        </div>
                    </div>

                    <div class="p-6 pt-0 space-y-3">
                        <div class="font-mono text-3xl font-bold text-foreground tabular-nums">
                            $25,550.00
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-transparent bg-destructive/90 text-destructive-foreground shadow hover:bg-destructive gap-1">
                                <i data-lucide="arrow-down" class="h-3 w-3"></i>
                                41.1%
                            </div>

                            <span class="text-sm text-muted-foreground">
                                vs $43,400.00 last month
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        
        <section>
            <div class="rounded-lg border bg-card text-card-foreground shadow-md">

                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="font-semibold leading-none tracking-tight font-serif flex items-center gap-2 text-xl">                    
                    Trends Over Time 
                    </div>

                    <div class="text-sm text-muted-foreground">
                        Leads and revenue performance (revenue in thousands)
                    </div>
                </div>

                <div class="p-6 pt-0">
                <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>

                </div>

            </div>
        </section>
        
        <section>

            <div class="rounded-lg border bg-card text-card-foreground shadow-md">

                <div class="flex flex-col space-y-1.5 p-6">

                    <div class="font-semibold leading-none tracking-tight font-serif flex items-center gap-2 text-xl">                    
                        Sheet Data Preview
                    </div>

                    <div class="text-sm text-muted-foreground">
                        Recent entries from your connected sheet
                    </div>

                </div>

                <div class="p-6 pt-0">

                    <div class="relative w-full overflow-auto">

                        <table class="w-full caption-bottom text-sm">

                            <thead class="[&_tr]:border-b">

                                <tr class="border-b transition-colors hover:bg-muted/50">

                                    <th class="h-10 px-2 text-left align-middle text-muted-foreground font-semibold">
                                        Date
                                    </th>

                                    <th class="h-10 px-2 align-middle text-muted-foreground font-semibold text-right">
                                        Leads
                                    </th>

                                    <th class="h-10 px-2 align-middle text-muted-foreground font-semibold text-right">
                                        Revenue
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="[&_tr:last-child]:border-0">

                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-2 align-middle font-mono text-sm">
                                        2026-04-01
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        28
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        $9,800
                                    </td>
                                </tr>

                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-2 align-middle font-mono text-sm">
                                        2026-04-08
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        32
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        $11,200
                                    </td>
                                </tr>

                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-2 align-middle font-mono text-sm">
                                        2026-04-15
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        31
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        $10,850
                                    </td>
                                </tr>

                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-2 align-middle font-mono text-sm">
                                        2026-04-22
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        33
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        $11,550
                                    </td>
                                </tr>

                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-2 align-middle font-mono text-sm">
                                        2026-05-01
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        35
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        $12,250
                                    </td>
                                </tr>

                                <tr class="border-b transition-colors hover:bg-muted/50">
                                    <td class="p-2 align-middle font-mono text-sm">
                                        2026-05-08
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        38
                                    </td>

                                    <td class="p-2 align-middle font-mono text-right tabular-nums">
                                        $13,300
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </section>

    </main>
</div>

@endsection

@section('script')


   <!-- JQUERY -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> -->

    <!-- MOMENT -->
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

    <!-- DATE RANGE PICKER -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>

    // MAIN DATE RANGE
    function cb(start, end) {

        $('#reportrange span').html(
            start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY')
        );

    }

    let start = moment().startOf('month');
    let end = moment().endOf('month');

    $('#reportrange').daterangepicker({

        startDate: start,
        endDate: end,
        opens: 'left',

        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')
            ]
        }

    }, cb);

    cb(start, end);



    // COMPARE DATE RANGE
    function compareCb(start, end) {

        $('#reportrange2 .compare-date').html(
            start.format('MMM DD') + ' - ' + end.format('MMM DD')
        );

    }

    let compareStart = moment().subtract(1, 'month').startOf('month');
    let compareEnd = moment().subtract(1, 'month').endOf('month');

    $('#reportrange2').daterangepicker({

        startDate: compareStart,
        endDate: compareEnd,
        opens: 'left'

    }, compareCb);

    compareCb(compareStart, compareEnd);

</script>

   <!-- apexcharts -->
   <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

   <!-- apexcharts init -->
   <!-- <script src="{{ URL::asset('build/js/pages/apexcharts.init.js') }}"></script> -->
   
   <script type="text/javascript">
      $(document).ready(function() {
         var options = {
            chart: {
               height: 380,
               type: "line",
               zoom: {
                  enabled: !1
               },
               toolbar: {
                  show: !1
               }
            },
            colors: ["#2a5511", "#3a7851"],
            dataLabels: {
               enabled: !1
            },
            stroke: {
               width: [3, 3],
               curve: "straight"
            },
            series: [{
               name: "Leads",
               data: [26, 24, 32, 36, 33, 31]
            }, {
               name: "Revenue",
               data: [14, 11, 16, 12, 17, 13]
            }],
            // title: {
            //    text: "Average High & Low Temperature",
            //    align: "left",
            //    style: {
            //       fontWeight: "500"
            //    }
            // },
            grid: {
               row: {
                  colors: ["transparent", "transparent"],
                  opacity: .2
               },
               borderColor: "#f1f1f1"
            },
            markers: {
               style: "inverted",
               size: 6
            },
            xaxis: {
               categories: ["Apr 1", "Apr 8", "Apr 15", "Apr 22", "May 1", "May 1"],
               // title: {
               //    text: "Month"
               // }
            },
            yaxis: {
               // title: {
               //    text: "Temperature"
               // },
               min: 5,
               max: 40
            },
            legend: {
               position: "top",
               horizontalAlign: "right",
               floating: !0,
               offsetY: -25,
               offsetX: -5
            },
            responsive: [{
               breakpoint: 600,
               options: {
                  chart: {
                  toolbar: {
                     show: !1
                  }
                  },
                  legend: {
                  show: !1
                  }
               }
            }]
            },
            chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options);
            chart.render();
      });
   </script>
@endsection
