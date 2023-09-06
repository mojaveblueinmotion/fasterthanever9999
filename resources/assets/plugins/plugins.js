//
// 3rd-Party Plugins JavaScript Includes
//



//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
////  Mandatory Plugins Includes(do not remove or change order!)  ////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

// Jquery - jQuery is a popular and feature-rich JavaScript library. Learn more: https://jquery.com/
window.jQuery = window.$ = require('jquery');

// Bootstrap - The most popular framework that Metronic uses as the foundation. Learn more: http://getbootstrap.com
require('bootstrap');

// Popper.js - Tooltip & Popover Positioning Engine used by Bootstrap. Learn more: https://popper.js.org
window.Popper = require('popper.js').default;

// Wnumb - Number & Money formatting. Learn more: https://refreshless.com/wnumb/
window.wNumb = require('wnumb');

// Moment - Parse, validate, manipulate, and display dates and times in JavaScript. Learn more: https://momentjs.com/
window.moment = require('moment');

// Perfect-Scrollbar - Minimalistic but perfect custom scrollbar plugin.  Learn more:  https://github.com/mdbootstrap/perfect-scrollbar
window.PerfectScrollbar = require('perfect-scrollbar/dist/perfect-scrollbar');

// Mandatory Plugins Includes

// Apexcharts - mBdern charting library that helps developers to create beautiful and interactive visualizations for web pages: https://apexcharts.com/
window.ApexCharts = require('apexcharts/dist/apexcharts.min.js');

// Bootstrap Datepicker - Bootstrap-datepicker provides a flexible datepicker widget in the Bootstrap style: https://bootstrap-datepicker.readthedocs.io/en/latest/
require('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
require('bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js');
require('./initials/bootstrap-datepicker.init.js');

// Bootstrap Timepicker - Easily select a time for a text input using your mouse or keyboards arrow keys: https://jdewit.github.io/bootstrap-timepicker/
require('bootstrap-timepicker/js/bootstrap-timepicker.js');
require('./initials/bootstrap-timepicker.init.js');

// Bootstrap Touchspin - A mobile and touch friendly input spinner component for Bootstrap 3: https://www.virtuosoft.eu/code/bootstrap-touchspin/
require('bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js');

// Bootstrap Switch - Bootstrap switch/toggle is a simple component used for activating one of two predefined options: https://mdbootstrap.com/docs/jquery/forms/switch/
require('bootstrap-switch/dist/js/bootstrap-switch.js');
require('./initials/bootstrap-switch.init.js');

// Select2 - Select2 is a jQuery based replacement for select boxes: https://select2.org/
require('select2/dist/js/select2.full.js');
require('select2/dist/js/i18n/id.js');

// Inputmask - is a javascript library which creates an input mask: https://github.com/RobinHerbots/Inputmask
require('inputmask/dist/jquery.inputmask.js');

// Sweetalert2 - a beautiful, responsive, customizable and accessible (WAI-ARIA) replacement for JavaScript's popup boxes: https://sweetalert2.github.io/
// window.Swal = window.swal = require('sweetalert2/dist/sweetalert2.min.js');
window.Swal = require('sweetalert2');
require('./initials/sweetalert2.init.js');

// DataTable
require('datatables.net-bs4');

// Jquery Form
require('./partials/jquery.form/dist/jquery.form.min.js');

// Jquery Gritter
require('./partials/gritter/js/jquery.gritter.min.js');

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
///  Optional Plugins Includes(you can remove or add)  ///////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

// Sticky-js - A library for sticky elements written in vanilla javascript. Learn more: https://rgalus.github.io/sticky-js/
window.Sticky = require('sticky-js');


// FormValidation - Best premium validation library for JavaScript. Zero dependencies. Learn more: https://formvalidation.io/
window.FormValidation = require("./partials/formvalidation/dist/amd/index.js");
window.FormValidation.plugins.Bootstrap = require("./partials/formvalidation/dist/amd/plugins/Bootstrap.js").default;

// jQuery BlockUI - The jQuery BlockUI Plugin lets you simulate synchronous behavior when using AJAX: http://malsup.com/jquery/block/
require('block-ui/jquery.blockUI.js');

// Tempus Dominus - The Tempus Dominus provides a flexible datetimepicker widget in the Bootstrap style: https://tempusdominus.github.io/bootstrap-4/
require('tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4');
require('./initials/tempusdominus-bootstrap-4.init.js');

// JQuery Mask Plugin - is a jQuery plugin which create an input mask. An input mask helps the user with the input by ensuring a predefined format: https://igorescobar.github.io/jQuery-Mask-Plugin/
require('jquery-mask-plugin');

// Date Range Picker - A JavaScript component for choosing date ranges, dates and times: https://www.daterangepicker.com/
require('bootstrap-daterangepicker/daterangepicker.js');

// Bootstrap Maxlength - This plugin integrates by default with Twitter bootstrap using badges to display the maximum length of the field where the user is inserting text: https://github.com/mimo84/bootstrap-maxlength
require('bootstrap-maxlength/src/bootstrap-maxlength.js');
require('./partials/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js');

// Ion Rangeslider - Is an easy, flexible and responsive range slider with tons of options: http://ionden.com/a/plugins/ion.rangeSlider/
require('ion-rangeslider/js/ion.rangeSlider.js');

// Typeahead.js - a flexible JavaScript library that provides a strong foundation for building robust typeaheads: https://twitter.github.io/typeahead.js/
window.Bloodhound = require('typeahead.js/dist/typeahead.bundle.js');


// Bootstrap Notify - This plugin helps to turn standard bootstrap alerts into "growl" like notifications: http://bootstrap-notify.remabledesigns.com/
require('bootstrap-notify/bootstrap-notify.min.js');
require('./initials/bootstrap-notify.init.js');

// Toastr - is a Javascript library for non-blocking notifications. jQuery is required. The goal is to create a simple core library that can be customized and extended: https://github.com/CodeSeven/toastr
window.toastr = require('toastr/build/toastr.min.js');

// Bootstrap Session Timeout - Session timeout and keep-alive control with a nice Bootstrap warning dialog: https://github.com/orangehill/bootstrap-session-timeout
window.sessionTimeout = require('./partials/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js');


// JQuery Repeater - Create a repeatable group of input elements: https://github.com/DubFriend/jquery.repeater
require('jquery.repeater');

// TinyMCE: The rich text editor built to scale, designed to innovate, and developed in open source: https://www.tiny.cloud/
require('tinymce/tinymce.min.js');
require('tinymce/themes/silver/theme.min.js');

// Uppy - Uppy fetches files locally and from remote places like Dropbox or Instagram: https://uppy.io/
window.Uppy = require('uppy/dist/uppy.min.js');


