'use strict';

angular.module('iepcAdmin', ['ui.router'])
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(true);
    }])
    .run(['$location', function($location){
        //$location.path('/');
    }])
    .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/');

        $stateProvider
            .state('home', {
                url         : '/',
                templateUrl : 'main'
            })
            .state('sections', {
                url : '/sections',
                templateUrl : 'sections'
            })
            .state('sections.edit', {
                url : '/sections/edit',
                templateUrl : 'sections/edit'
            })
    }]);

// function saveContent() {
//     var $content = $(this).parents('form').first(),
//         id       = $('#page_id').val(),
//         value    = $content.find('textarea').val();
//     $.post('/admin/content/edit/' + id , {content: value}, function(data) {}, 'json');
// }