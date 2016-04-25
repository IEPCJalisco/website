'use strict';

angular.module('iepcAdmin')
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(true);
    }])
    .run(['$location', function($location) {
    }])
    .config(['$stateProvider', function($stateProvider) {
    }]);

// function saveContent() {
//     var $content = $(this).parents('form').first(),
//         id       = $('#page_id').val(),
//         value    = $content.find('textarea').val();
//     $.post('/admin/content/edit/' + id , {content: value}, function(data) {}, 'json');
// }