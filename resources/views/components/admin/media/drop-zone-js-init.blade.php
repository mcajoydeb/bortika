<div>
    <!-- Dropzone -->
    <script src="{{ asset('theme/plugins/dropzone/js/dropzone.min.js') }}"></script>
    <script>
        $(function () {
        $(".dropzone").dropzone({
            // url for the ajax to post
            url: '{{ route("admin.media.store") }}',
            // width of the div
            width:                  '100%',
            // height of the div
            height:                 300,
            // width of the progress bars
            progressBarWidth:       '100%',
            // name for the form submit
            filesName:              'files',
            // margin added if needed
            margin:                 0,
            // border property
            border:                 '2px dashed #ccc',
            background:             '',
            // Z index of element
            zIndex:                 100,
            // text color
            textColor:              '#ccc',
            // css style for text-align
            textAlign:              'center',
            // text inside the div
            text:                   'Drop files here to upload',
            // upload all files at once or upload single files, options: all or single
            uploadMode:             'single',
            // progress selector if null one will be created
            progressContainer:      '',
            // if preview true we can define the image src
            src:                    '',
            // wrap the dropzone div with custom class
            dropzoneWraper:         'nniicc-dropzoneParent',
            // Access to the files that are droped
            files:                  [],
            // max file size ['bytes', 'KB', 'MB', 'GB', 'TB']
            maxFileSize:            '2MB',
            // allowed files to be uploaded seperated by ',' jpg,png,gif
            allowedFileTypes:       '*', //'jpg,png,gif,jpeg',
            // click on dropzone to select files old way
            clickToUpload:          true,
            // show time that has elapsed from the start of the upload,
            showTimer:              false,
            // delete complete progress bars when adding new files
            removeComplete:         true,
            // if enabled it will load the pictured directly to the html
            preview:                false,
            // Upload file even if the preview is enabled
            uploadOnPreview:        false,
            // Upload file right after drop
            uploadOnDrop:           true,
            // object of additional params
            params: {
                _token: $('meta[name="_token"]').attr('content')
            },
            // callback when the div is loaded
            load:                   null,
            // callback for the files procent
            progress:               null,
            // callback for the file upload finished
            uploadDone:             null,
            // callback for a file uploaded
            success:                null,
            // callback for any error
            error:                  null,
            // callback for the preview is rendered
            previewDone:            null,
            // callback for mouseover event
            mouseOver:              null,
            // callback for mouseout event
            mouseOut:               null,
        });
    });
    </script>
</div>
