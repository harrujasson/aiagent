/**
 * Theme: Ubold Template
 * Author: Coderthemes
 * SweetAlert
 */

! function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples
    SweetAlert.prototype.init = function() {

            //Delete
            $("body").on("click", '.sa-warning', function() {
                var url = $(this).attr("data-url");
                var msg = $(this).attr("data-msg");
                if (msg === undefined || msg === null) {
                    msg = "You won’t be able to undo this!";
                }
                swal({
                    title: 'Are you sure?',
                    text: msg,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4fa7f3',
                    cancelButtonColor: '#d57171',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function() {
                    $.ajax({
                        url: url,
                        success: function(status) {
                            if (status == 1) {
                                swal(
                                    'Deleted!',
                                    'Record has been deleted.',
                                    'success'
                                )
                                setTimeout(function() { location.reload(); }, 1000);

                            } else {
                                swal(
                                    'Error!',
                                    'Record not deleted.',
                                    'error'
                                )
                            }
                        }
                    });

                })
            });

            //Status Change

            $("body").on("click", '.sa-warning-status', function() {
                var url = $(this).attr("data-url");
                swal({
                    title: 'Are you sure?',
                    text: "Status will be change!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4fa7f3',
                    cancelButtonColor: '#d57171',
                    confirmButtonText: 'Yes, change it!'
                }).then(function() {
                    $.ajax({
                        url: url,
                        success: function(status) {
                            if (status == 1) {
                                swal(
                                    'Changes!',
                                    'Status has been changed.',
                                    'success'
                                )
                                setTimeout(function() { location.reload(); }, 1000);

                            } else {
                                swal(
                                    'Error!',
                                    'Status not changed.',
                                    'error'
                                )
                            }
                        }
                    });

                })
            });

            $("body").on("click", '.sa-warning-cancel', function() {
                var url = $(this).attr("data-url");
                var msg = $(this).attr("data-msg");
                if (msg === undefined || msg === null) {
                    msg = "You won’t be able to undo this!";
                }
                swal({
                    title: 'Are you sure?',
                    text: msg,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4fa7f3',
                    cancelButtonColor: '#d57171',
                    confirmButtonText: 'Yes, cancel it!'
                }).then(function() {
                    $.ajax({
                        url: url,
                        success: function(status) {
                            if (status == 1) {
                                swal(
                                    'Cancel!',
                                    'Booking has been cancel.',
                                    'success'
                                )
                                setTimeout(function() { location.reload(); }, 1000);

                            } else {
                                swal(
                                    'Error!',
                                    'Booking not cancel.',
                                    'error'
                                )
                            }
                        }
                    });

                })
            });


        },
        //init
        $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.SweetAlert.init()
}(window.jQuery);