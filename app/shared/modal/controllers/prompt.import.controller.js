// I control the Prompt modal window.
// --
// NOTE: This controller gets "modals" injected; but, it is in no way
// different than any other Controller in your entire AngularJS application.
// It takes services, manages the view-model, and knows NOTHING about the DOM.
angular.module("invato").controller(
    "PromptImportController",
    function ($scope, modals, projectsFactory) {

        // Setup defaults using the modal params.
        $scope.promptTitle = ( modals.params().promptTitle || "" );
        $scope.message = ( modals.params().message || "" );

        // Setup the form inputs (using modal params).
        $scope.organization = {
            buildings: [],
            units: [],
            measurementUnit: 'sft'
        };
        $scope.errorMessage = null;

        $scope.fileChanged = function (files) {
            console.log("file changed");
            var file = files[0];
            var ext = file.name.split('.').pop();
            if (ext == "json") {
                projectsFactory.handleJson(file).then(function (data) {
                    $scope.organization = data;
                });
            } else if (ext == "xlsx") {
                projectsFactory.handleExcel(file).then(function (data) {
                    $scope.organization = data;
                });
            } else {

            }
        };

        // Wire the modal buttons into modal resolution actions.
        $scope.cancel = modals.reject;

        // I process the form submission.
        $scope.submit = function () {

            // If no input was provided, show the user an error message.
            if (!$scope.organization.buildings.length && !$scope.organization.units.length) {
                return ( $scope.errorMessage = "Please Import a valid Excel/JSON file!" );
            }

            modals.resolve($scope.organization);
        };
    }
);