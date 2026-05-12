<!-- Button -->

<button
    class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 px-8 fixed bottom-6 right-6 h-14 w-14 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 z-50"
    type="button" data-bs-toggle="modal" data-bs-target="#pennyAiModal" >
    <i data-lucide="sparkles" class="h-6 w-6"></i>

    <span class="sr-only">Open Penny AI</span>
</button>

<!-- Bootstrap Modal -->
<!-- Bootstrap Modal -->
<div class="modal fade" id="pennyAiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-background shadow-lg rounded-lg overflow-hidden">

            <!-- Header -->
            <div class="px-6 pt-6 pb-4 border-bottom border-border">
                <div class="flex items-center gap-2 d-flex align-items-center gap-2">

                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <i data-lucide="sparkles" class="sparkles h-5 w-5 text-primary"></i>
                    </div>

                    <div>
                        <h2 class="font-serif text-xl font-semibold mb-0">
                            Penny AI
                        </h2>

                        <p class="text-sm text-muted-foreground mb-0">
                            Your analytics assistant
                        </p>
                    </div>

                </div>

                <button
                    type="button"
                    class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="flex-1 px-6 py-4 overflow-auto" style="height: 420px;">

                <div class="space-y-4">

                    <div class="flex justify-start d-flex justify-content-start">
                        <div class="max-w-[80%] rounded-lg px-4 py-3 bg-muted text-foreground">
                            <p class="text-sm leading-relaxed mb-1">
                                Hi! I'm Penny AI, your analytics assistant.
                                Ask me anything about your leads and revenue data.
                            </p>

                            <span class="text-xs opacity-70 block">
                                18:25
                            </span>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-top border-border space-y-3">

                <!-- Quick Buttons -->
                <div class="flex flex-wrap gap-2 d-flex flex-wrap gap-2 mb-3">

                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 border-border dark:hover:bg-input/50 h-8 rounded-md px-3 text-xs"
                    >
                        Compare last month to this month
                    </button>

                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 border-border dark:hover:bg-input/50 h-8 rounded-md px-3 text-xs"
                    >
                        What's the revenue trend?
                    </button>

                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 border-border dark:hover:bg-input/50 h-8 rounded-md px-3 text-xs"
                    >
                        How many leads this week?
                    </button>

                </div>

                <!-- Input -->
                <div class="flex gap-2 d-flex gap-2">

                    <input
                        type="text"
                        class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm flex-1"
                        placeholder="Ask Penny about your analytics..."
                    >

                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-9 w-9"
                    >
                        <i data-lucide="send" class="h-4 w-4"></i>
                    </button>

                </div>

            </div>

        </div>
    </div>
</div>


<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">                  
                  &#169; <script>document.write(new Date().getFullYear())</script> {{(getSettingInfo('company_name') != "" ? getSettingInfo('company_name') : Config::get('constants.AppnameGlobe') ) }}. All Rights Reserved.
            </div>
        </div>
    </div>


</footer>
