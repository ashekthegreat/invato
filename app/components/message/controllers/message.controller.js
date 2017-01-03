(function () {
    angular.module("invato")
        .controller("MessageController", MessageController);

    MessageController.$inject = ["$scope", "messageFactory", "modals"];

    function MessageController($scope, MessageFactory, modals) {
        $scope.numbers = "12345";
        $scope.message = "Hello";

        $scope.sendMessage = function(){
            var numbersAsString = $scope.numbers.trim();
            var message = $scope.message.trim();
            if(!(numbersAsString && message)){
                return;
            } else{
                MessageFactory.sendMessage(numbersAsString, message).then(function (data, status, headers, config) {
                    console.log("At Controller");
                    console.log(data);
                }, function (data, status, headers, config) {
                    console.log(data);
                });
            }
        };

        $scope.deleteUser = function (user) {
            var promise = modals.open("confirm", {
                message: "Are you sure you want to delete this User?"
            });

            promise.then(function handleResolve(response) {
                $scope.users = _.reject($scope.users, function (u) {
                    return u.id == user.id;
                });
                usersFactory.deleteUser(user);
            });
        };
        $scope.editUser = function (user) {
            var promise = modals.open("promptSaveUser", {
                promptTitle: "Edit User",
                user: angular.copy(user),
                projects: $scope.projects
            });

            promise.then(function handleResolve(response) {
                //console.log(response);
                angular.extend(user, response);
                usersFactory.saveUser(user).then(function (response) {
                    user.password = "";
                });
            });
        };
        $scope.addUser = function () {
            var promise = modals.open("promptSaveUser", {
                promptTitle: "New User",
                user: {
                    id: 0,
                    name: "",
                    email: "",
                    password: "",
                    type: "admin",
                    projectId: 0,
                    note: ""
                },
                projects: $scope.projects
            });

            promise.then(function handleResolve(response) {
                var user = response;
                $scope.users.push(user);
                usersFactory.saveUser(user).then(function (response) {
                    angular.extend(user, response.data);
                    user.password = "";
                });
            });
        };
    }
}());