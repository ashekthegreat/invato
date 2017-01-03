// I control the Prompt modal window.
// --
// NOTE: This controller gets "modals" injected; but, it is in no way
// different than any other Controller in your entire AngularJS application.
// It takes services, manages the view-model, and knows NOTHING about the DOM.
angular.module("invato").controller(
    "PromptSaveUserController",
    function ($scope, modals) {

        // Setup defaults using the modal params.
        $scope.promptTitle = ( modals.params().promptTitle || "" );
        $scope.message = ( modals.params().message || "" );

        // Setup the form inputs (using modal params).
        $scope.user = modals.params().user;
        $scope.projects = modals.params().projects;

        if (!$scope.user.type) {
            $scope.user.type = "admin";
        }
        $scope.errorMessage = null;
        console.log($scope.user);
         /*$scope.user.projectIds = JSON.parse($scope.user.projectIds);
        console.log($scope.user);*/
        // Wire the modal buttons into modal resolution actions.
        $scope.cancel = modals.reject;

        $scope.updateUsersProjectIds = function (project) {
            if($scope.user.projectIds.indexOf(project.id) > -1){
                // remove it
                $scope.user.projectIds = _.reject($scope.user.projectIds, function (id) {
                    return id == project.id;
                });
            } else{
                $scope.user.projectIds.push(project.id);
            }
        };

        $scope.isProjectChecked = function (project) {
            var id = _.find($scope.user.projectIds, function(id){ return id == project.id; });
            return !!id;
        };

        // I process the form submission.
        $scope.submit = function () {

            // If no input was provided, show the user an error message.
            if (!$scope.user.name) {
                return ( $scope.errorMessage = "Please provide a Name!" );
            }
            if (!$scope.user.email) {
                return ( $scope.errorMessage = "Please provide an Email!" );
            }
            if (!$scope.user.id && !$scope.user.password) {
                return ( $scope.errorMessage = "Please provide a Password!" );
            }
            if ($scope.user.type == "project" && !$scope.user.projectIds.length) {
                return ( $scope.errorMessage = "Please select a Project!" );
            }
            if ($scope.user.type == "admin") {
                $scope.user.projectIds = [];
            }

            modals.resolve($scope.user);
        };
    }
);