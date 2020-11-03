<meta charset="utf-8" />
<title>LPH SUCOFINDO | @yield('title')</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />

<!-- ================== BEGIN BASE CSS STYLE ================== -->
{{--
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="/assets/css/default/app.min.css" rel="stylesheet" />
--}}
<link rel="stylesheet" href="{{asset('/assets/css/fonts/fontStyle.css')}}"/>
<link href="{{asset('assets/css/default/app.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/toastr-bower-master/toastr.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />


<!-- ================== END BASE CSS STYLE ================== -->

@stack('css')
