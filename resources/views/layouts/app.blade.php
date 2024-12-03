<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- ===============================================-->
        <!--    Document Title-->
        <!-- ===============================================-->
        <title>ONYX</title>
    
        <!-- ===============================================-->
        <!--    Favicons-->
        <!-- ===============================================-->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icons/spot-illustrations/Onyx.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/icons/spot-illustrations/Onyx.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/icons/spot-illustrations/Onyx.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/icons/spot-illustrations/Onyx.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
        <meta name="msapplication-TileImage" content="{{ asset('assets/img/icons/spot-illustrations/Onyx.png') }}">
        <meta name="theme-color" content="#ffffff">
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
        
    
        <!-- ===============================================-->
        <!--    Stylesheets-->
        <!-- ===============================================-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
        
        <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
        <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
        <link href="{{ asset('assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
        <link href="{{ asset('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
        <link href="{{ asset('vendors/choices/choices.min.css')}}" rel="stylesheet" />
        <link href="{{ asset('vendors/flatpickr/flatpickr.min.css')}}" rel="stylesheet" />
        <link href="{{ asset('assets/css/monthSelect.style.css')}}" rel="stylesheet" />
        <link src="{{ asset('assets/css/swal2.dark.min.css/themes/dark/dark.css') }}"></link>
        <link href="{{ asset('vendors/dropzone/dropzone.min.css')}}" rel="stylesheet" />
        <script src="{{ asset('vendors/dropzone/dropzone.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
        <script src="{{ asset('assets/js/swal2.min.js') }}"></script>
        <script src="{{ asset('assets/js/jdate.min.js')}}"></script>
        <script>window.Date=window.JDate;</script>
        <script src="{{ asset('assets/js/flatpickr.js')}}"></script>
        <script src="{{ asset('assets/js/monthSelect.js')}}"></script>

        


        <style>
          
        </style>

        <script>
          var isRTL = JSON.parse(localStorage.getItem('isRTL'));
          if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
          } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
          }
        </script>
      </head>
    <body class="">
        <div class="">
          
          @include('layouts.navbar')
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
          $(document).ready(function() {
              $('#mode-rtl').change(function() {
                  var locale = $(this).is(':checked') ? 'da' : 'en';
                  $('#localeInput').val(locale);
                  $('#languageForm').submit();
              });
          });
      </script>
        
        <!-- ===============================================-->
        <!--    JavaScripts-->
        <!-- ===============================================-->
        <script src="{{ asset('vendors/choices/choices.min.js')}}"></script>
        <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
        <script src="{{ asset('vendors/is/is.min.js') }}"></script>
        <script src="{{ asset('vendors/chart/chart.min.js') }}"></script>
        <script src="{{ asset('vendors/countup/countUp.umd.js') }}"></script>
        <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
        <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('vendors/dayjs/dayjs.min.js') }}"></script>
        <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
        <script src="{{ asset('assets/js/flatpickr.js')}}"></script>
        <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
        <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme.js') }}"></script>
    </body>
</html>
