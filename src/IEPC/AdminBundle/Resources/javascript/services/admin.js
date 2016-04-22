'use strict';

angular.module('iepcAdmin')
    .factory('adminService', ['$rootScope', '$state', '$document', '$http', function($rootScope, $state, $document, $http)
    {
        var service = {
            getSections : function($scope) {
                $scope.sections = ['Cargando...'];

                $http.get('/sections/get', {
                    cache           : false,
                    responseType    : 'json',
                    withCredentials : true
                }).then(function(response) {
                    $scope.sections = response.data;
                }, function() {
                    $scope.sections = ['error'];
                });
            }
        };

        return service;
    }]);