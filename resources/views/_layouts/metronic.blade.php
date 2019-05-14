<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 7
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>@yield('page-title')</title>
        <meta name="description" content="Page with empty content">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>

        <!--end::Fonts -->

        <!--begin::Page Vendors Styles(used by this page) -->

        <!-- METRONIC CSS BUNDLE -->
        <link rel="stylesheet" href="{{ asset('public/css/metronic.bundle.css') }} ">
        <!-- <link href="{{ asset('public/metronic/assets/app/custom/wizard/wizard-v1.default.css') }} " rel="stylesheet" type="text/css" /> -->
        <!-- <link href="{{ asset('public/metronic/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
        <!-- <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }} "> -->
      <!--   <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/tether/dist/css/tether.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }} "> -->
    <!--     <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/select2/dist/css/select2.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/nouislider/distribute/nouislider.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css') }} "> -->
<!--         <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/dropzone/dist/dropzone.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/summernote/dist/summernote.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/animate.css/animate.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/toastr/build/toastr.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/morris.js/morris.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/sweetalert2/dist/sweetalert2.css') }} ">
    -->
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/general/socicon/css/socicon.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/custom/vendors/flaticon/flaticon.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/custom/vendors/flaticon2/flaticon.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/custom/vendors/fontawesome5/css/all.min.css') }} ">
        <!--  END OF METRONIC BUNDLE -->


        <!--end:: Global Optional Vendors -->

        <!--begin::Global Theme Styles(used by all pages) -->
     
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/demo/default/base/style.bundle.css') }} ">
        <!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->
  <!--       <link rel="stylesheet" href="{{ asset('public/metronic/assets/demo/default/skins/header/base/light.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/demo/default/skins/header/menu/light.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/demo/default/skins/brand/dark.css') }} ">
        <link rel="stylesheet" href="{{ asset('public/metronic/assets/demo/default/skins/aside/dark.css') }} "> -->

        <!-- UNUSED -->
        <!-- <link rel="stylesheet" href="{{ asset('public/metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }} "> -->

        <!--  CUSTOM -->
        <link rel="stylesheet" href="{{ asset('public/css/app.css') }} ">
        <!--end::Layout Skins -->
        
        <link rel="shortcut icon" href="{{ asset('public/metronic/assets/media/logos/favicon.ico') }} ">
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

        <!-- begin:: Page -->

        <!-- begin:: Header Mobile -->
        <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
            <div class="kt-header-mobile__logo">
                <a href="index.html">
                    <img alt="Logo" src="{{ asset('public/metronic/assets/media/logos/logo-light.png') }} " />
                </a>
            </div>
            <div class="kt-header-mobile__toolbar">
                <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
            </div>
        </div>

        <!-- end:: Header Mobile -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

                <!-- begin:: Aside -->
                <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
                <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

                    <!-- begin:: Aside -->
                    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                        <div class="kt-aside__brand-logo">
                            <a href="index.html">
                                <img alt="Log" src="{{ asset('public/img/isuzu_logo.png') }}" />
                            </a>
                        </div>
                        <div class="kt-aside__brand-tools">
                            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                            <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
                                            <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
                                        </g>
                                    </svg></span>
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                            <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" />
                                            <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
                                        </g>
                                    </svg></span>
                            </button>
                        </div>
                    </div>

                    <!-- end:: Aside -->

                    <!-- begin:: Aside Menu -->
                    @include('_layouts.aside')

                    <!-- end:: Aside Menu -->
                </div>

                <!-- end:: Aside -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                    <!-- begin:: Header -->
                    <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

                        <!-- begin:: Header Menu -->
                        @include('_layouts.header_menu')
                        <!-- end:: Header Menu -->

                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar">

                            <!--begin: Search -->
                            @include('_layouts.searchbar')
                            <!--end: Search -->

                            <!--begin: Notifications -->

                            <!--end: Notifications -->

                            <!--begin: Quick Actions -->
                            @include('_layouts.quick_actions')
                            <!--end: Quick Actions -->

                            <!--begin: My Cart -->
                          
                            <!--end: My Cart -->

                            <!--begin: Quick panel toggler -->
                        
                            <!--end: Quick panel toggler -->

                            <!--begin: Language bar -->
                      
                            <!--end: Language bar -->

                            <!--begin: User Bar -->
                           @include('_layouts.user_profile')
                            <!--end: User Bar -->
                        </div>

                        <!-- end:: Header Topbar -->
                    </div>

                    <!-- end:: Header -->
                    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

                        <!-- begin:: Subheader -->
                        @include('_layouts.subheader')

                        <!-- end:: Subheader -->

                        <!-- begin:: Content -->
                        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                             @yield('content')
                        </div>

                        <!-- end:: Content -->
                    </div>

                    <!-- begin:: Footer -->
                    <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
                        <div class="kt-footer__copyright">
                            2019&nbsp;&copy;&nbsp;<a href="#" target="_blank" class="kt-link">Isuzu Philippines Corporation</a>
                        </div>
                        <div class="kt-footer__menu">
                            <a href="#" target="_blank" class="kt-footer__menu-link kt-link">About</a>
                            <a href="#" target="_blank" class="kt-footer__menu-link kt-link">Team</a>
                            <a href="#" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>
                        </div>
                    </div>

                    <!-- end:: Footer -->
                </div>
            </div>
        </div>

        <!-- end:: Page -->

        <!-- begin::Quick Panel -->
       

        <!-- end::Quick Panel -->

        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>

        <!-- end::Scrolltop -->

        <!-- begin::Sticky Toolbar -->
      

        <!-- end::Sticky Toolbar -->

        <!-- begin::Demo Panel -->
       

        <!-- end::Demo Panel -->

        <!-- begin::Global Config(global config for global JS sciprts) -->
        <script>
            var KTAppOptions = {
                "colors": {
                    "state": {
                        "brand": "#5d78ff",
                        "dark": "#282a3c",
                        "light": "#ffffff",
                        "primary": "#5867dd",
                        "success": "#34bfa3",
                        "info": "#36a3f7",
                        "warning": "#ffb822",
                        "danger": "#fd3995"
                    },
                    "base": {
                        "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                        "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                    }
                }
            };
        </script>

        <!-- end::Global Config -->

        <!--begin:: Global Mandatory Vendors -->
        <script src="{{ asset('public/js/app.js') }}"></script> 
        <script src="{{ asset('public/js/metronic.bundle.js') }}"></script> 
        <!-- included in metronic bundle -->
        <!-- script src="{{ asset('public/metronic/assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/wnumb/wNumb.js') }}" type="text/javascript"></script> -->
       <!--  <script src="{{ asset('public/metronic/assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script> -->
       <!--  <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/bootstrap-datepicker/init.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/bootstrap-timepicker/init.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script> -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js') }}" type="text/javascript"></script> -->
     <!--    <script src="{{ asset('public/metronic/assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/bootstrap-switch/init.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js') }}" type="text/javascript"></script -->>
      <!--   <script src="{{ asset('public/metronic/assets/vendors/general/typeahead.js/dist/typeahead.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/handlebars/dist/handlebars.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/nouislider/distribute/nouislider.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script> -->
<!-- 
          <script src="{{ asset('public/metronic/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/sweetalert2/init.js') }}" type="text/javascript"></script> -->
            <!--     <script src="{{ asset('public/metronic/assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js') }}" type="text/javascript"></script> -->
<!--                   <script src="{{ asset('public/metronic/assets/vendors/general/jquery-validation/dist/jquery.validate.js') }}" type="text/javascript"></script>
                     <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/jquery-validation/init.js') }}" type="text/javascript"></script> -->
        <!-- end of metronic bundle -->
       
        
         

        <!-- NOT YET INCLUDED IN METRONIC BUNDLE AND UNUSED FOR NOW -->
        <!-- <script src="{{ asset('public/metronic/assets/vendors/general/autosize/dist/autosize.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/clipboard/dist/clipboard.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/dropzone/dist/dropzone.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/summernote/dist/summernote.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/markdown/lib/markdown.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/bootstrap-markdown/init.js') }}" type="text/javascript"></script> -->
<!--         <script src="{{ asset('public/metronic/assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/components/vendors/bootstrap-notify/init.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/jquery-validation/dist/additional-methods.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/morris.js/morris.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/waypoints/lib/jquery.waypoints.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/es6-promise-polyfill/promise.min.js') }}" type="text/javascript"></script> -->
      
<!--         <script src="{{ asset('public/metronic/assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/general/dompurify/dist/purify.js') }}" type="text/javascript"></script> -->

        <!--end:: Global Optional Vendors -->

        <!--begin::Global Theme Bundle(used by all pages) -->
       
        <!-- included in metronic bundle -->

       <!--  <script src="{{ asset('public/metronic/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/app/bundle/app.bundle.js') }}" type="text/javascript"></script> -->

        <!--end::Global Theme Bundle -->

        <!--begin::Page Vendors(used by this page) -->
   <!--      <script src="{{ asset('public/metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
        <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
        <script src="{{ asset('public/metronic/assets/vendors/custom/gmaps/gmaps.js') }}" type="text/javascript"></script> -->
        <!--end::Page Vendors -->


        <!--begin::Global Theme Bundle(used by all pages) -->
  <!--      <script src="{{ asset('public/metronic/assets/vendors/global/vendors.bundle.js') }}" type="text/javascript"></script>
       <script src="{{ asset('public/metronic/assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script> -->
    <!--end::Global Theme Bundle -->


        <!--begin::Page Scripts(used by this page) -->
      <!-- 
        <script src="{{ asset('public/metronic/assets/app/custom/general/dashboard.js') }}" type="text/javascript"></script> -->
      <!--   <script src="{{ asset('public/metronic/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> -->
        <!--end::Page Scripts -->
        <!--begin::Global App Bundle(used by all pages) -->
      <!--    -->

        <!--end::Global App Bundle -->
        <!-- BUNDLED METRONIC TEMPLATE -->

        

        <script>

        </script>
        @stack('scripts')
    </body>

    <!-- end::Body -->
</html>