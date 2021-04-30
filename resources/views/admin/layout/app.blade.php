<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLte Demo</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- all style sheet file--}}
    @include('admin.layout.stylesheet')

    {{-- apllication variable set and access to whole project pages --}}
    <script type="text/javascript">
        var url = "{{ asset("") }}";
        var postToken = '{{csrf_token()}}';
        var front_url = "{{ env('FRONT_URL','adminlte')}}";
        var loginUser = {!! json_encode(auth()->user()) !!};
        var AdminUrl = url + "admin/";
        var ProjectTitle = "AdminLTE Demo";
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    
    <div class="wrapper">
        
        {{-- pre loader  --}}
        @include('admin.layout.pre-loader')
        
        {{-- navbar--}}
        @include('admin.layout.header')

        {{-- main sidebar (left sided)--}}
        @include('admin.layout.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content-header')

        {{-- footer --}}
        @include('admin.layout.footer')

    </div>
    <!-- ./wrapper -->

    @include('admin.layout.scripts')
    @yield("js-footer")
</body>
</html>
