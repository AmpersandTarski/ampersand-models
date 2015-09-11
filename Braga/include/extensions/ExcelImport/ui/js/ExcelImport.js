var app = angular.module('AmpersandApp');
app.requires[app.requires.length] = 'angularFileUpload'; // add ur.file module to dependencies

AmpersandApp.config(function($routeProvider) {
	$routeProvider
		// default start page
		.when('/ext/ExcelImport',
			{	controller: 'ExcelImportController'
			,	templateUrl: 'extensions/ExcelImport/ui/views/ExcelImport.html'
			,	interfaceLabel: 'Excel import'
			});
});

AmpersandApp.controller('ExcelImportController', function ($scope, $rootScope, FileUploader, Restangular, $localStorage) {
	
	// $rootScope, so that all information and uploaded files are kept while browsing in the application
	if (typeof $rootScope.uploader == 'undefined') {

		$rootScope.uploader = new FileUploader({
			 url: 'extensions/ExcelImport/api/import'
		});
	}
	
	$rootScope.uploader.onSuccessItem = function(fileItem, response, status, headers) {
		$rootScope.updateNotifications(response.notifications);
        // console.info('onSuccessItem', fileItem, response, status, headers);
    };
    
    $rootScope.uploader.onErrorItem = function(item, response, status, headers){
    	$rootScope.notifications.errors.push( {'message' : response.error.code + ' ' + response.error.message} );	
    	
    };
    
	$rootScope.uploader.onAfterAddingFile = function(item){
		item.reinstallDbBeforeUpload = true;
	}
    
    $scope.customUpload = function(item){
    	if (item.reinstallDbBeforeUpload){
    		item.installing = true;
    		item.installed = false;
    		Restangular.one('installer').get().then(function(data) {
    			$rootScope.updateNotifications(data);
    			
    			// set roleId back to 0
    			$localStorage.roleId = 0;
    			
    			// refresh session
    			$rootScope.session = Restangular.one('session').get().$object;
    			
    			// refresh navbar
    			$rootScope.refreshNavBar();
    			
    			item.installing = false;
    			item.installed = true;
    			item.upload();
    		}, function(){
    			item.installing = false;
    			item.installed = false;
    		});
    		
    	}else{
    		item.upload();
    	}
    }
    
});