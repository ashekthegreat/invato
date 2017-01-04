/* global angular: false */

(function (ng) {
    'use strict';

    //$stateprovider is the service provided by ui.router
    angular.module("invato")
        .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

            //create route object
            $stateProvider
                .state('message', {
                    url: '/',
                    templateUrl: 'app/components/message/views/index.html',
                    controller: 'MessageController'
                })
                .state('inbox', {
                    url: '/inbox',
                    templateUrl: 'app/components/inbox/views/index.html',
                    controller: 'InboxController'
                });

            // set the default route
            $urlRouterProvider.otherwise('/');

        }]);
})(angular);
