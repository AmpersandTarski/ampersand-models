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
			
		});
		$rootScope.addError('Unknown role: ' + roleLabel);
		return;
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
          $rootScope.reloadNavBarScope = function(){$scope.reload();}
	
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
		$localStorage.roleId = 0;
                    Restangular.one('installer').get().then(function(data) {
                            Restangular.one('../../extensions/ExecEngine/api/run').get()
                                .then(
                                          function(data){ // success
                                                  $route.reload();
                                                  $rootScope.refreshNavBar();
		                              angular.forEach($scope.navbar.roles, function(role) {
		                              	if(role.label == "User"){
		                              		$scope.selectRole(role.id);
		                              		return;
		                              	}
		                              	
		                              });
                                          }, function(){ // error with execengine.. no message
			                    $scope.selectRole(0);
                                          }
                                );
		}, function(){ alert('Please refresh your browser first.')
			$scope.selectRole(0);
		});
	}
	
	// $rootScope.refreshNavBar(); // initialize navbar
});

AmpersandApp.run(function(Restangular,$rootScope,$localStorage){
          Restangular.one('installer').get().then(function(data) { // installation succesful, then run ExecEngine
              Restangular.one('../../extensions/ExecEngine/api/run').get().then(function(data){ // success, get a list of users from the navbar
                Restangular.one('navbar').get().then(function(data){ // make sure $rootScope.navbar exists
                    $rootScope.navbar = data; // update the navbar
                    angular.forEach($rootScope.navbar.roles, function(role) { // find the right user
	              if(role.label == "User"){
	              	$rootScope.roleId = role.id;// $rootScope.selectRole(role.id);
			$rootScope.getNotifications(); // if found: show its notifications
                              $rootScope.reloadNavBarScope(); 
			console.log('found user!')
                            return;
	              }
	          });
                }, function(){ // error with navbar.. no message
		        $rootScope.selectRole(0);
                    alert('error getting navbar');
                });
              }, function(error){ // error with exec engine
                    alert('error exec engine');
              })
	}, function(){ 
	    $rootScope.selectRole(0);
              $rootScope.refreshNavBar();
              alert('Please refresh your browser.'); // error with installer. Hopefully this works?
	});
})