'use strict'

function saveContent() {
    var $content = $(this).parents('article').first(),
        id       = $content.attr('data-id'),
        value    = $content.find('textarea').val();

    value = CKEDITOR.instances.contentEdit.getData();

    $.post('/admin/content/edit/' + id , {content: value}, function(data){
        console.log(data);
    }, 'json');
}