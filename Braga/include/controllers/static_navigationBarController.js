AmpersandApp.controller('static_navigationBarController', function ($scope, $rootScope, $route, $routeParams, Restangular, $localStorage) {
	
	$scope.$storage = $localStorage;
	
	$rootScope.myPromises = new Array(); // initialize an array for promises, used by angular-busy module (loading indicator)
	
	$rootScope.selectRole = function(roleId){
		$localStorage.roleId = roleId;
		
		// refresh navbar + notifications
		$rootScope.refreshNavBar();
		$rootScope.getNotifications();
		$scope.reload();
	};
	
	$scope.selectRoleByLabel = function (roleLabel){
		angular.forEach($scope.navbar.roles, function(role) {
			if(role.label == roleLabel){
				$scope.selectRole(role.id);
				return;
			}
			
			$rootScope.addError('Unknown role: ' + roleLabel);
			return;
		});
	};
	
	$rootScope.refreshNavBar = function(){
		$rootScope.myPromises.push(
			Restangular.one('navbar')
				.get()
				.then(function(data){
					$rootScope.navbar = data;
				}, function(error){
					// on error
				})
		);
	};
	
	$scope.destroySession = function(){
		$rootScope.session.remove().then(function(data){
			$rootScope.updateNotifications(data.notifications);
			$rootScope.session = '';
			
			// set roleId back to 0
			$scope.selectRole(0);
			
			$rootScope.session = Restangular.one('session').get().$object;
		});
	};
	
	$scope.reload = function(){
		$route.reload();
	};
    
	$scope.reinstall = function(){
                    Restangular.one('installer').get().then(function(data) {
                            Restangular.one('../../extensions/ExecEngine/api/run').get()
                                .then(
                                          function(data){ // success
                                                  $rootScope.updateNotifications(data.notifications);
                                                  $route.reload();
                                                  //$rootScope.updateNotifications(data);

                                                  // refresh navbar
                                                  $rootScope.refreshNavBar();
                                          }, function(){ // error with execengine.. no message
                                          }
                                );
		}, function(){ alert('error installing db!')
			// TODO: show proper error message
		});
	}
	
	$rootScope.refreshNavBar(); // initialize navbar
});