<script src="{{ URL::asset('build/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/select2/select2.min.js') }}" ></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@yield('script')
<script type="text/javascript">
    $(document).ready(function() {

        $(".pre_query").click(function(){
            $("#query_input").val($(this).text().trim());
        })
        $(".send_query").click(function(){
            var $this = $(this);
            $this.addClass('loading');
            let queryinput = $("#query_input");
            if(queryinput.val() == ""){
                alert('Error!', 'Please enter your query.', 'error');
            }



            let querySend=`<div class="max-w-[80%] user-responce"> 
                                <div class="text-sm leading-relaxed mb-1">
                                    <div class="conversation-list">
                                        <div class="ctext-wrap">
                                            <div class="conversation-name">Your Request</div>
                                            <p>
                                                <strong>${queryinput.val()}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            $(".airesponse").append(querySend)

            $.ajax({
                method: 'POST',
                data: {
                    _token:$('meta[name="csrf-token"]').attr('content'),
                    query:queryinput.val()
                },
                url:'/admin/report/query',
                success:function(res){
                    $this.removeClass('loading');
                    if(res.success){
                        let html = `<div class="max-w-[80%] ai-responce">
                            <div class="text-sm leading-relaxed mb-1">
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="conversation-name">AI Agent Response</div>
                                        ${res.data}
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        queryinput.val('');
                        $(".airesponse").append(html);

                    }else{
                        queryinput.val('');
                        alert('Error!', res.message, 'error');
                    }
                },
                error: function () {
                    $this.removeClass('loading');
                    queryinput.val('');
                    alert('No data response. Try with different prompt!');
                }
            })

        });
    });

</script>
<!-- App js -->
<script src="{{ URL::asset('build/js/app.min.js')}}"></script>

@yield('script-bottom')
