(function () {
    angular.module("invato")
        .factory("messageFactory", messageFactory);

    messageFactory.$inject = ["$http", "$q", "$window"];

    function messageFactory($http, $q, $window) {
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

        /*factory.deleteUser = function (user) {
            return $http.post('backend/delete_user.php', user).success(function (data, status, headers, config) {
                // saving successful
            }).error(function (data, status, headers, config) {
                console.log(data);
            });

        };*/

        return factory;

    }
}());