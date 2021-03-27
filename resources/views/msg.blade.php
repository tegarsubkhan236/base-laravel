<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    })

    @if(count($errors->all()) > 0)
        @foreach($errors->all() as $item)
            Toast.fire({
                icon: 'error',
                title: "{{$item}}"
            })
        @endforeach
    @endif

    @if(session()->get("msg") !== null)
        Toast.fire({
            icon: 'success',
            title: "{{session()->get("msg")}}"
        })
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
