angular.module('AmpersandApp')
.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/Home',
            {
                templateUrl: 'app/project/home.html',
            });
}]);