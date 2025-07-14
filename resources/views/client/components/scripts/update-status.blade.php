<script>
    $(document).ready(function() {
        $('.toggle-status').on('change', function() {
            const id = $(this).data('id');
            const isActive = $(this).is(':checked') ? 1 : 0;
            const url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'PATCH',
                data: {
                    id: id,
                    is_active: isActive,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message || 'Cập nhật trạng thái thành công!',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất Bại!',
                        text: xhr.responseJSON?.message ||
                            'Có lỗi xảy ra, vui lòng thử lại.',
                        confirmButtonText: 'OK'
                    });
                    $(self).prop('checked', !isActive);
                }
            })
        })
    })
</script>
