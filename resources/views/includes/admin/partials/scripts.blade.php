<!--[if lt IE 9]>
{{ Html::script('assets/global/plugins/respond.min.js') }}
{{ Html::script('assets/global/plugins/excanvas.min.js') }}
{{ Html::script('assets/global/plugins/ie8.fix.min.js') }}
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
{{ Html::script('assets/global/plugins/jquery.min.js') }}
@include('flashy::message')

{{ Html::script('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}
{{ Html::script('assets/global/plugins/js.cookie.min.js') }}
{{ Html::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
{{ Html::script('assets/global/plugins/jquery.blockui.min.js') }}
{{ Html::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}
<!-- END CORE PLUGINS -->

{{ Html::script('assets/global/scripts/datatable.js') }}
{{ Html::script('assets/global/plugins/datatables/datatables.min.js') }}
{{ Html::script('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}

<script>
    function AdminValidation(the_rules, selector) {
        var FormValidation = function () {
            var handleValidation1 = function () {
                var form1 = $(selector);
                var error1 = $('.alert-danger', form1);
                var success1 = $('.alert-success', form1);

                form1.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",  // validate all fields including form hidden input
                    messages: {
                        select_multi: {
                            maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                            minlength: jQuery.validator.format("At least {0} items must be selected")
                        }
                    },
                    rules: the_rules
                    ,

                    invalidHandler: function (event, validator) { //display error alert on form submit
                        success1.hide();
                        error1.show();
                        App.scrollTo(error1, -200);
                    },

                    errorPlacement: function (error, element) { // render error placement for each input type
                        var cont = $(element).parent('.input-group');
                        if (cont) {
                            cont.after(error);
                        } else {
                            element.after(error);
                        }
                    },

                    highlight: function (element) { // hightlight error inputs

                        $(element)
                            .closest('.form-group').addClass('has-error'); // set error class to the control group
                    },

                    unhighlight: function (element) { // revert the change done by hightlight
                        $(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                    },

                    success: function (label) {
                        label
                            .closest('.form-group').removeClass('has-error'); // set success class to the control group
                    },

                    submitHandler: function (form) {
                        success1.show();
                        error1.hide();
                        form.submit()
                    }
                });


            }

            return {
                //main function to initiate the module
                init: function () {
                    handleValidation1();
                }

            };
        }();
        jQuery(document).ready(function () {
            FormValidation.init();
        });
    }

</script>

<!-- BEGIN THEME GLOBAL SCRIPTS -->
{{ Html::script('assets/global/scripts/app.min.js') }}
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
{{ Html::script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}
{{ Html::script('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}

@if(app()->getLocale() == 'ar')
    {{ Html::script('assets/pages/scripts/table-datatables-managed-rtl.min.js') }}
@else
    {{ Html::script('assets/pages/scripts/table-datatables-managed.min.js') }}
@endif

{!! Html::script('assets/global/plugins/sweetalert/sweetalert.min.js') !!}

<script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>


<script>

    $(document).ready(function () {
        URL = "{{ url('/') }}";

        $(".iziModal").iziModal({
            width: 700,
            radius: 5,
            padding: 20,
            loop: true
        });
    });

    token = "{{ csrf_token() }}";

    $(document).on('click', '.delete-btn', function (event) {
        event.preventDefault();
        id = $(this).data('id');
        link = $(this).data('link');
        type = 'DELETE';
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: link,
                    type: type,
                    data: {_token: token, id: id}
                }).done(function (data) {
                    swal({
                            title: "Done",
                            text: "",
                            type: "success",
                        },
                        function () {
                            window.location.reload();

                        });
                });
            });
    });


    $(document).on('click', '.delete-btn-no-refresh', function (event) {
        event.preventDefault();
        id = $(this).data('id');
        link = $(this).data('link');
        type = 'DELETE';
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: link,
                    type: type,
                    data: {_token: token, id: id}
                }).done(function (data) {
                    swal({
                            title: "Done",
                            text: "",
                            type: "success",
                        },
                        function () {
                            $('#modal-area').iziModal('close');
                        });
                });
            });
    });


    $(document).on('click', '.btn-order', function (event) {
        event.preventDefault();
        let id = $(this).data('id');
        let status = $(this).data('status');
        swal({
                title: "Are you sure?",
                text: status === 1 ? "You Want To Accept This Order !" : 'You Want To Reject This Order',
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: "{{ route('orders.change-status') }}",
                    type: 'POST',
                    data: {
                        _token: token,
                        id: id,
                        status: status
                    }
                }).done(function (data) {
                    if (data.code == 200) {
                        swal({
                                title: "Done",
                                text: "",
                                type: "success",
                            },
                            function () {
                                window.location.reload();
                            });
                    } else if (data.code == 600) {

                        let products = '<thead>' +
                            '<tr>' +
                            '<td>Product</td>' +
                            '<td>Color</td>' +
                            '<td>Required qty</td>' +
                            '<td>Available qty</td>' +
                            '</tr>' +
                            '</thead><tbody>';

                        let all_products = data.products;

                        for (let i = 0; i < all_products.length; i++) {
                            products += '<tr>' +
                                '<td>' + all_products[i].product + '</td>' +
                                '<td>' + all_products[i].color + '</td>' +
                                '<td>' + all_products[i].wants + '</td>' +
                                '<td>' + all_products[i].exists + '</td>' +
                                '</tr>';
                        }

                        products += '</tbody>';
                        let table = '<table id="dynamic-table" class="table table-striped table-bordered table-hover">' + products + '</table>';
                        swal({
                            title: 'Out Of Stocks',
                            text: '<b>' + table + '</b>',
                            html: true
                        });

                    } else {
                        swal({
                            title: "Error",
                            text: "cannot do this action",
                            type: "warning",
                        });
                    }
                });
            });
    });


    // handle ajax links within sidebar menu
    $('.page-sidebar').on('click', ' li > a.ajaxify', function (e) {
        e.preventDefault();
        App.scrollTop();
        var url = $(this).attr("href");
        var menuContainer = $('.page-sidebar ul');

        menuContainer.children('li.active').removeClass('active');
        menuContainer.children('arrow.open').removeClass('open');

        $(this).parents('li').each(function () {
            $(this).addClass('active');
            $(this).children('a > span.arrow').addClass('open');
        });
        $(this).parents('li').addClass('active');

        if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page
            $('.page-header .responsive-toggler').click();
        }

        Layout.loadAjaxContent(url, $(this));
    });


    $("#modal_import").iziModal();

</script>

<!-- BEGIN THEME LAYOUT SCRIPTS -->
{{ Html::script('assets/layouts/layout/scripts/layout.min.js') }}
{{ Html::script('assets/layouts/layout/scripts/demo.min.js') }}
{{ Html::script('assets/layouts/global/scripts/quick-sidebar.min.js') }}
{{ Html::script('assets/layouts/global/scripts/quick-nav.min.js') }}
<!-- END THEME LAYOUT SCRIPTS -->

{{ Html::script('assets/apps/scripts/main.js') }}


@stack('scripts-stack')

@yield('page-scripts')
