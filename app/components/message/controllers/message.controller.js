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


        $scope.numbers = "";
        $scope.message = "";

        $scope.sendMessage = function () {

            var numbersAsString = $scope.numbers.trim();
            var message = $scope.message.trim();
            if (!(numbersAsString && message)) {
                return;
            } else {
                $scope.isLoading = true;
                $scope.invitations.$add({
                    title: "Sample Invitation"
                }).then(function(ref) {
                    MessageFactory.sendMessage(numbersAsString, message).then(function (data, status, headers, config) {
                        console.log("At Controller");
                        console.log(data);
                        var fireNumbers = $firebaseArray(ref);
                        if(typeof data.data.response == "object"){
                            for(var i=0; i<data.data.response.length; i++){
                                fireNumbers.$add(data.data.response[i])
                            }
                        }
                        $scope.isLoading = false;
                    }, function (data, status, headers, config) {
                        console.log(data);
                    });
                });
            }
        };

    }
}());