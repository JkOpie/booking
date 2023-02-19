@if(Session::has('success'))
    <script>
        Swal.fire(
            'Success!',
            "{{Session::get('success')}}",
            'success'
        )
    </script>
@elseif(Session::has('error'))
<script>
    Swal.fire(
        'Not Available!',
        "{{Session::get('error')}}",
        'error'
    )
</script>
@endif
