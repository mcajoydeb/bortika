<div>
    <script>
        $(function () {
            $('[name="{{ $inputName }}"]').summernote({
                callbacks: {
                    onChange: function(contents) {
                        $('.{{ $showCountClassName }}').html(contents.length);
                        @this.set('{{ $inputName }}', contents);
                    }
                }
            });
        });
    </script>
</div>
