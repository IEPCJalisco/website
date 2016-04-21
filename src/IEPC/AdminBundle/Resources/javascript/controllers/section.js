'use strict';

angular.module('iepcAdmin')
    .controller('sectionController',  ['$rootScope', '$scope', '$state', function($rootScope, $scope, $state)
    {
        angular.extend($scope, {
            section  : 'main-page',
            sections : []
        });

        // Functions
        angular.extend($scope, {
            newSection : function() {
                alert();
            }
        });
    }]);