<!-- ================== BEGIN BASE JS ================== -->
<script src="{{asset('/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('/assets/js/app.min.js')}}"></script>
<script src="{{asset('/assets/js/theme/default.min.js')}}"></script>

<script src="{{asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/js/demo/table-manage-default.demo.js')}}"></script>
<script src="{{asset('/assets/plugins/toastr-bower-master/toastr.js')}}"></script>
<script>
    @if(Session::has("error"))
        toastr.options = {
        closeButton: true,
        timeOut: 0
        };
    toastr.error("{{Session::get("error")}}", "Gagal", {});
    @elseif(Session::has("success"))
    toastr.success("{{Session::get("success")}}", "Berhasil", {});
    @endif
</script>
<!-- ================== END BASE JS ================== -->

@stack('scripts')