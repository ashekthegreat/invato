(function () {
    angular.module("invato")
        .factory("inboxFactory", InboxFactory);

    InboxFactory.$inject = ["$http", "$q", "$window"];

    function InboxFactory($http, $q, $window) {
        var factory = {};

        factory.sendMessage = function (numbers, message) {
            var postData = {
                numbers: numbers,
                message: message
            };
            return $http.post('backend/send_message.php', postData).then(function (data, status, headers, config) {
                console.log("At Factory");
                console.log(data);
                return data;
            }, function (data, status, headers, config) {
                console.log(data);
                return data;
            });

        };

        return factory;
    }
}());