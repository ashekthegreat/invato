/* global angular: false */

(function (ng) {
    'use strict';

    //$stateprovider is the service provided by ui.router
    angular.module("invato")
        .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

            //create route object
            $stateProvider
                .state('inbox', {
                    url: '/',
                    templateUrl: 'app/components/inbox/views/index.html',
                    controller: 'InboxController'
                })
                .state('message', {
                    url: '/message',
                    templateUrl: 'app/components/message/views/index.html',
                    controller: 'MessageController'
                });

            // set the default route
            $urlRouterProvider.otherwise('/');

        }]);
})(angular);
