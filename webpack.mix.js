const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
mix.setPublicPath('public');
mix.setResourceRoot('../');


mix.styles([
    'public/metronic/assets/app/custom/wizard/wizard-v1.default.css',
    /*'public/metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css',*/
    'public/metronic/assets/vendors/custom/datatables/datatables.bundle.css',
    'public/metronic/assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css',
    'public/metronic/assets/vendors/general/tether/dist/css/tether.css',
    'public/metronic/assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
    'public/metronic/assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css',
    'public/metronic/assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css',
    'public/metronic/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css',
    'public/metronic/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css',
    'public/metronic/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css',
    'public/metronic/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css',
    'public/metronic/assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
    'public/metronic/assets/vendors/general/select2/dist/css/select2.css',
    'public/metronic/assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css',
    'public/metronic/assets/vendors/general/nouislider/distribute/nouislider.css',
    'public/metronic/assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css',
    'public/metronic/assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css',
    'public/metronic/assets/vendors/general/dropzone/dist/dropzone.css',
    'public/metronic/assets/vendors/general/summernote/dist/summernote.css',
    'public/metronic/assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css',
    'public/metronic/assets/vendors/general/animate.css/animate.css',
    'public/metronic/assets/vendors/general/toastr/build/toastr.css',
    'public/metronic/assets/vendors/general/morris.js/morris.css',
    'public/metronic/assets/vendors/general/sweetalert2/dist/sweetalert2.css',
    /* Fonts */
/*    'public/metronic/assets/vendors/general/socicon/css/socicon.css',
    'public/metronic/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css',
    'public/metronic/assets/vendors/custom/vendors/flaticon/flaticon.css',
    'public/metronic/assets/vendors/custom/vendors/flaticon2/flaticon.css',
    'public/metronic/assets/vendors/custom/vendors/fontawesome5/css/all.min.css',*/
 /*   'public/metronic/assets/demo/default/base/style.bundle.css',*/
    // Layout Skins(used by all pages) 
    'public/metronic/assets/demo/default/skins/header/base/light.css',
    'public/metronic/assets/demo/default/skins/header/menu/light.css',
    'public/metronic/assets/demo/default/skins/brand/dark.css',
    'public/metronic/assets/demo/default/skins/aside/dark.css',
    'public/metronic/assets/css/demo1/pages/general/invoices/invoice-1.css',
    'public/metronic/assets/vendors/global/vendors.bundle.css',
    /*'public/metronic/assets/css/demo1/style.bundle.css'*/
], 'public/css/metronic.bundle.css');

mix.scripts([

	/* plugins */
	'public/metronic/assets/vendors/general/popper.js/dist/umd/popper.js',
	'public/metronic/assets/vendors/general/js-cookie/src/js.cookie.js',
	'public/metronic/assets/vendors/general/moment/min/moment.min.js',
	'public/metronic/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js',
	'public/metronic/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js',
	'public/metronic/assets/vendors/general/sticky-js/dist/sticky.min.js',
	'public/metronic/assets/vendors/general/wnumb/wNumb.js',
	'public/metronic/assets/vendors/general/jquery-form/dist/jquery.form.min.js',
	'public/metronic/assets/vendors/general/block-ui/jquery.blockUI.js',
	'public/metronic/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
	'public/metronic/assets/vendors/custom/components/vendors/bootstrap-datepicker/init.js',
	'public/metronic/assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js',
	'public/metronic/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
	'public/metronic/assets/vendors/custom/components/vendors/bootstrap-timepicker/init.js',
	'public/metronic/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js',
	'public/metronic/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js',
	'public/metronic/assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js',
	'public/metronic/assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js',
	'public/metronic/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js',
	'public/metronic/assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js',
	'public/metronic/assets/vendors/custom/components/vendors/bootstrap-switch/init.js',
	'public/metronic/assets/vendors/general/select2/dist/js/select2.full.js',
	'public/metronic/assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js',
	'public/metronic/assets/vendors/general/typeahead.js/dist/typeahead.bundle.js',
	'public/metronic/assets/vendors/general/handlebars/dist/handlebars.js',
	'public/metronic/assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js',
	'public/metronic/assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js',
	'public/metronic/assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js',
	'public/metronic/assets/vendors/general/nouislider/distribute/nouislider.js',
	'public/metronic/assets/vendors/general/owl.carousel/dist/owl.carousel.js',
	'public/metronic/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js',
	'public/metronic/assets/vendors/custom/components/vendors/sweetalert2/init.js',
	'public/metronic/assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js',
	'public/metronic/assets/vendors/general/jquery-validation/dist/jquery.validate.js',
	'public/metronic/assets/vendors/custom/components/vendors/jquery-validation/init.js',

	'public/metronic/assets/vendors/general/morris.js/morris.js',
	'public/metronic/assets/vendors/general/chart.js/dist/Chart.bundle.js',
/*	'public/metronic/assets/vendors/global/vendors.bundle.js',*/
/*	'public/metronic/assets/js/demo1/scripts.bundle.js',*/
/*	'public/metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js',
	'public/metronic/assets/maps.js',
	'public/metronic/assets/vendors/custom/gmaps/gmaps.js',*/
    'public/metronic/assets/vendors/custom/datatables/datatables.bundule.min.js',
	'public/metronic/assets/demo/default/base/scripts.bundle.min.js',
	'public/metronic/assets/app/bundle/app.bundle.min.js'
], 'public/js/metronic.bundle.js'); 