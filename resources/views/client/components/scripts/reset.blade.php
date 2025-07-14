@props(['route' => ''])
<script>
    $(document).ready(function() {
        $('#reset-search').on('click', function(e) {
            e.preventDefault();
            window.location.href = "{{ $route }}";
        });
    })
</script>
