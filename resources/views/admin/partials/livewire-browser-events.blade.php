<script>
    window.addEventListener('closeModal', event => {
        $('#' + event.detail.id).modal('hide');
    })
    window.addEventListener('openModal', event => {
        $('#' + event.detail.id).modal('show');
    })
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
</script>
