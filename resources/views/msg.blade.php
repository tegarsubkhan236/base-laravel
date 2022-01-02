<script>
    toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if(count($errors->all()) > 0)
        @foreach($errors->all() as $item)
        toastr.error("{{ $item }}");
        @endforeach
    @endif
    @if(Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
