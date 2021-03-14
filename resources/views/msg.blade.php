<script>
    @if(count($errors->all()) > 0)
        @foreach($errors->all() as $item)
        toastr.error("{{$item}}");
        @endforeach
    @endif
    @if(session()->get("msg") !== null)
        toastr.success("{{session()->get("msg")}}")
        @if(session()->get("msg") !== null)
        setTimeout(function () {
            @if(session()->get("url"))
                location.href = "{{session()->get("url")}}";
                @php
                    session()->forget("url");
                @endphp
            @endif
        },1000)
        @endif
    @endif
</script>
