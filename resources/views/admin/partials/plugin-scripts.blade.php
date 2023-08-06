<script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
<x-admin.media.drop-zone-js-init />
<script>
    $(function () {
        // //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Select Option'
        });
    });
</script>
