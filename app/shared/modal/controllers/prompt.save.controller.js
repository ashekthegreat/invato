// I control the Prompt modal window.
// --
// NOTE: This controller gets "modals" injected; but, it is in no way
// different than any other Controller in your entire AngularJS application.
// It takes services, manages the view-model, and knows NOTHING about the DOM.
angular.module("invato").controller(
    "PromptSaveController",
    function ($scope, modals) {

        // Setup defaults using the modal params.
        $scope.message = ( modals.params().message || "Give me." );

        // Setup the form inputs (using modal params).
        $scope.form = {
            name: ( modals.params().name || "" ),
            note: ( modals.params().note || "" )
        };

        $scope.errorMessage = null;


        // ---
        // PUBLIC METHODS.
        // ---


        // Wire the modal buttons into modal resolution actions.
        $scope.cancel = modals.reject;


        // I process the form submission.
        $scope.submit = function () {

            // If no input was provided, show the user an error message.
            if (!$scope.form.name) {

                return ( $scope.errorMessage = "Please provide a name!" );

            }

            modals.resolve($scope.form);

        };

    }
);