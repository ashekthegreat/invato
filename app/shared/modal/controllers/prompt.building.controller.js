angular.module("invato").controller(
    "PromptBuildingController",
    function ($scope, modals) {

        // Setup defaults using the modal params.
        $scope.promptTitle = ( modals.params().promptTitle || "" );
        $scope.message = ( modals.params().message || "" );

        // Setup the form inputs (using modal params).
        $scope.building = modals.params().building;
        $scope.errorMessage = null;

        // Wire the modal buttons into modal resolution actions.
        $scope.cancel = modals.reject;

        // I process the form submission.
        $scope.submit = function () {

            // If no input was provided, show the user an error message.
            if (!$scope.building.title) {
                return( $scope.errorMessage = "Please provide a Name!" );
            }

            modals.resolve($scope.building);

        };

    }
);