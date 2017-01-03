// I control the Prompt modal window.
// --
// NOTE: This controller gets "modals" injected; but, it is in no way
// different than any other Controller in your entire AngularJS application.
// It takes services, manages the view-model, and knows NOTHING about the DOM.
angular.module("invato").controller(
    "PromptSaveProjectController",
    function ($scope, modals) {

        // Setup defaults using the modal params.
        $scope.promptTitle = ( modals.params().promptTitle || "" );
        $scope.message = ( modals.params().message || "" );

        // Setup the form inputs (using modal params).
        $scope.project = modals.params().project;
        $scope.errorMessage = null;

        // Wire the modal buttons into modal resolution actions.
        $scope.cancel = modals.reject;

        // I process the form submission.
        $scope.submit = function () {

            // If no input was provided, show the user an error message.
            if (!$scope.project.name) {
                return ( $scope.errorMessage = "Please provide a name!" );
            }

            modals.resolve($scope.project);
        };
    }
);