'use strict'

angular.module('iepcAdmin', ['ui.router'])
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.aHrefSanitizationWhitelist(/^\s*(geo|mailto|tel|maps):/);
    }])
    .run(['$location', function($location){
        $location.path('/');
    }]);


function saveContent() {
    var $content = $(this).parents('article').first(),
        id       = $('#page_id').val(),
        value    = $content.find('textarea').val();

    $.post('/admin/content/edit/' + id , {content: value}, function(data){
        console.log(data);
    }, 'json');
}