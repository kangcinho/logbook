<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{!! asset('css/bootstrap/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/bootstrap/fontawesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/custom/bsadmin.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/datatable/dataTables.bootstrap4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/custom/spin.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/custom/customTableResponsive.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/select2/select2.min.css') !!}"  />
    <link rel="stylesheet" href="{!! asset('css/select2/select2-bootstrap4.min.css') !!}">
    @yield('additionalCSS')
</head>
<body>
@include('master.navbar')
<div class="d-flex">
    @include('master.sidebar')
    <div class="container-fluid p-2">
      @yield('content')
    </div>
</div>

<script src="{!! asset('js/bootstrap/jquery.min.js') !!}"></script>
<script src="{!! asset('js/bootstrap/popper.min.js') !!}"></script>
<script src="{!! asset('js/bootstrap/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/general/bsadmin.js') !!}"></script>
<script src="{!! asset('js/datatable/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('js/datatable/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('js/general/needs_validation.js') !!}"></script>
<script src="{!! asset('js/general/tanggalConvert.js') !!}"></script>
<script src="{!! asset('js/general/formFunction.js') !!}"></script>
<script src="{!! asset('js/general/searchPasien.js') !!}"></script>
<script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>
<script src="{!! asset('js/select2/select2.min.js') !!}"></script>
<script src="{!! asset('js/timepicker/bootstrap-timepicker.min.js') !!}"></script>
@yield('additionalJS')
</body>
</html>
