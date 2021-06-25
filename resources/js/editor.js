tinymce.init({
    selector: '.wysiwyg',
    height: 350,
    menubar: false,
    statusbar: false,
    convert_urls: true,
    forced_root_block: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code'
    ],
    toolbar: 'undo redo | bold italic | bullist numlist outdent indent | styleselect | image media | table link | code',
    relative_urls: false,
    extended_valid_elements: 'span[class],i[class]'
});