'use strict';

angular.module('iepcAdmin')
    .controller('sectionController',  ['$scope', 'adminService', function($scope, adminService)
    {
        angular.extend($scope, {
            sections : []
        });

        adminService.getSections($scope);

        // Functions
        angular.extend($scope, {
            newSection : function() {
                $scope.sections.push(new Section());
            }
        });

        function Section() {
            this.id       = null;
            this.name     = '';
            this.path     = '';
            this.layout   = '';
            this.children = [];
            this.parent   = null;
        }
        angular.extend(Section.prototype, {
            edit : function () {
                alert();
            }
        });
    }]);