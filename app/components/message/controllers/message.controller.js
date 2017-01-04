(function () {
    angular.module("invato")
        .controller("MessageController", MessageController);

    MessageController.$inject = ["$scope", "messageFactory", "modals", "$firebaseArray"];

    function MessageController($scope, MessageFactory, modals, $firebaseArray) {

        $scope.numberInput = "";
        $scope.messageText = "";

        $scope.numbers = [];
        $scope.passedNumbers = [];
        $scope.failedNumbers = [];

        $scope.sendMessage = function () {

            var numberInput = $scope.numberInput.trim();
            var messageText = $scope.messageText.trim();
            if (!(numberInput && messageText)) {
                return;
            }

            $scope.isLoading = true;
            $scope.isProcessing = true;

            $scope.numbers = numberInput.split(/\r?\n/);
            _.each($scope.numbers, function(number, i){
                number = number.trim();
                if(number.indexOf("+")==0){
                    number = "+" + number.replace(/[^0-9.]/g, "");
                } else{
                    number = number.replace(/[^0-9.]/g, "");
                }
                if(number && number.length < 10){
                    number = "";
                }
                $scope.numbers[i] = number;
            });

            $scope.numbers = _.without(_.uniq($scope.numbers), undefined, null, false, "");

            _.each($scope.numbers, function(number, i){
                MessageFactory.sendMessage(number, messageText).then(function (data, status, headers, config) {
                    if (typeof data.data.response == "object") {
                        $scope.passedNumbers.push(number);
                    } else{
                        $scope.failedNumbers.push(number);
                    }
                    if($scope.numbers.length == $scope.passedNumbers.length + $scope.failedNumbers.length){
                        $scope.isProcessing = false;
                    }

                }, function (data, status, headers, config) {
                    console.log(data);
                });
            });
        };
        $scope.closeProcessing = function () {
            $scope.isProcessing = false;
            $scope.isLoading = false;
        }
    }
}());