angular.module("invato").controller(
    "PromptMessageController",
    function ($scope, modals) {
        console.log("prompt message controller");
        console.log(modals);
        console.log(modals.params());
        // Setup defaults using the modal params.
        $scope.promptTitle = ( modals.params().promptTitle || "" );
        $scope.message = ( modals.params().message || "" );

        // Setup the form inputs (using modal params).
        $scope.replyText = "";
        $scope.errorMessage = null;

        // Wire the modal buttons into modal resolution actions.
        $scope.cancel = modals.reject;

        // I process the form submission.
        $scope.submit = function () {

            // If no input was provided, show the user an error message.
            if (!$scope.replyText) {
                return( $scope.errorMessage = "Please write something!" );
            }

            modals.resolve($scope.replyText);

        };

    }
);