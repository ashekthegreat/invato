(function () {
    angular.module("invato")
        .controller("InboxController", InboxController);

    InboxController.$inject = ["$scope", "messageFactory", "modals", "$firebaseArray"];

    function InboxController($scope, MessageFactory, modals, $firebaseArray) {

        var inboxRef = firebase.database().ref().child("inbox");
        var query = inboxRef.limitToLast(200);
        // download the data from a Firebase reference into a (pseudo read-only) array
        // all server changes are applied in realtime
        $scope.messages = $firebaseArray(query);

        $scope.reply = function (message) {
            console.log(message);
            var promise = modals.open("promptMessage", {
                    promptTitle: "Reply",
                    message: message
                }
            );

            promise.then(
                function handleResolve(response) {
                    console.log("Handling modal resolve");
                    console.log(response);
                    MessageFactory.sendMessage(message.From, response).then(function (data, status, headers, config) {
                        message.replyText = response;
                        $scope.messages.$save(message);
                    }, function (data, status, headers, config) {
                        console.log(data);
                    });
                }
            );
        };


        /*
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
        */
    }
}());