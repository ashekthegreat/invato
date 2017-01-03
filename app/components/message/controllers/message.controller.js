(function () {
    angular.module("invato")
        .controller("MessageController", MessageController);

    MessageController.$inject = ["$scope", "messageFactory", "modals", "$firebaseArray"];

    function MessageController($scope, MessageFactory, modals, $firebaseArray) {
        /*var invitations = new firebase("https://invato-53a3d.firebaseio.com/invitations");
        $scope.invitations = $firebaseArray(invitations);*/

        var invitationsRef = firebase.database().ref().child("invitations");
        // download the data from a Firebase reference into a (pseudo read-only) array
        // all server changes are applied in realtime
        $scope.invitations = $firebaseArray(invitationsRef);


        $scope.numbers = "+8801713452621\n+8801713452621";
        $scope.message = "Test message";

        $scope.sendMessage = function () {

            var numbersAsString = $scope.numbers.trim();
            var message = $scope.message.trim();
            if (!(numbersAsString && message)) {
                return;
            } else {
                $scope.invitations.$add({
                    title: "Sample Invitation"
                }).then(function(ref) {
                    MessageFactory.sendMessage(numbersAsString, message).then(function (data, status, headers, config) {
                        console.log("At Controller");
                        console.log(data);
                        var fireNumbers = $firebaseArray(ref);
                        for(var i=0; i<data.data.response.length; i++){
                            fireNumbers.$add(data.data.response[i])
                        }
                    }, function (data, status, headers, config) {
                        console.log(data);
                    });
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