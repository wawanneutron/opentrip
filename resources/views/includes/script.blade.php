<script src="{{ asset('frontend/libraries/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('frontend/libraries/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/libraries/retina/retina.min.js') }}"></script>
<script src="{{ asset('frontend/libraries/js/script.js') }}"></script>
<script src="{{ asset('frontend/libraries/sweetalert/sweetalert.min.js') }}"></script>

<script>
    @if (session()->has('success'))
        swal({
        type: "success",
        icon: "success",
        title: "BERHASIL!",
        text: "{{ session('success') }}",
        // // timer: 1500,
        showConfirmButton: true,
        showCancelButton: false,
        // buttons: true,
        });
    @elseif(session()->has('error'))
        swal({
        type: "error",
        icon: "error",
        title: "GAGAL!",
        text: "{{ session('error') }}",
        // // timer: 1500,
        showConfirmButton: true,
        showCancelButton: false,
        // buttons: true,
        });
    @endif
</script>