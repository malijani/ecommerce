<script>
    let file_manager_show = '{{ route('unisharp.lfm.show') }}';
    let file_manager_upload = '{{ route('unisharp.lfm.upload') }}';
    let csrf_token = $('meta[name="csrf-token"]').attr('content');


    CKEDITOR.replace('{{ $input_id ?? 'long_text' }}', {
        removePlugins: 'exportpdf',
        height: 1000,
        baseFloatZIndex: 10005,
        contentsLangDirection: 'rtl',
        direction: 'rtl',
        contentsLanguage: 'fa',
        content: 'fa',
        language: 'fa',
        filebrowserImageBrowseUrl: file_manager_show,
        filebrowserImageUploadUrl: file_manager_upload + '?_token=' + csrf_token,
        filebrowserBrowseUrl: file_manager_show,
        filebrowserUploadUrl: file_manager_upload + '?_token=' + csrf_token,
        font_names: 'Vazir;' +
            'Arial/Arial, Helvetica, sans-serif;' +
            'Comic Sans MS/Comic Sans MS, cursive;' +
            'Courier New/Courier New, Courier, monospace;' +
            'Georgia/Georgia, serif;' +
            'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
            'Tahoma/Tahoma, Geneva, sans-serif;' +
            'Times New Roman/Times New Roman, Times, serif;' +
            'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
            'Verdana/Verdana, Geneva, sans-serif',
        font_defaultLabel: 'Vazir',
        fontSize_defaultLabel: '16px',
        contentsCss: ["body {font-size: 14px;font-family:Vazir;}"],
        forcePasteAsPlainText: true,
        forceEnterMode: true,
        allowedContent: true,
        allowedContent: 'img form input param pre flash br a td p span font em strong table tr th td style  script iframe u s li ul div[*]{*}(*)',
        editorplaceholder: 'متن ...',
    });

</script>
