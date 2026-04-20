$(document).ready(function() {

    $("body").on("click", ".assign_role", function() {
        $("#notify_container").hide();
        $(".notif").text("")
        var $this = $(this);

        $("#role_user").text($this.attr('data-name'));

        $(".container_roles").html('<div class="load">Loading..</div>');
        $.ajax({

            type: "POST",
            data: {
                "user_id": $this.attr('data-id'),
                "_token": $("meta[name='csrf-token']").attr('content'),
            },
            url: "/admin/users/load-roles",
            dataType: 'json',
            success: function(data) {
                $(".container_roles").html(data.html)
            }
        });
    });

    $("body").on("click", "#assign_role_to_user", function() {

        $("#notify_container").hide();
        $(".notif").text("")
        $.ajax({
            type: "POST",
            data: $("#roles_form").serialize(),
            url: "/admin/users/save-ajax-roles",
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    $("#notify_container").show();
                    $(".notif").text("Role has been assigned successfully!")
                } else {
                    $("#notify_container").show();
                    $(".notif").text("Something went wrong.")
                }
                $(".container_roles").html(data.html)
            },
            error: function() {
                $("#notify_container").show();
                $(".notif").text("Something went wrong.")
            }
        });

    });



});