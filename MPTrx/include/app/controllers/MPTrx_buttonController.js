AmpersandApp.controller('buttonController', function($scope){
	
	$scope.saveAndNavTo = function(resource, ifc, patchResource, navTo){		
		if(typeof resource[ifc] === 'undefined' || resource[ifc] === '') value = null;
		else value = resource[ifc];
		
		// Construct path
		pathLength = patchResource['_path_'].length;
		path = resource['_path_'].substring(pathLength) + '/' + ifc;
		
		// Construct patch
		patches = [{ op : 'replace', path : path, value : value}];
		
		// Patch!
		if(typeof resource['_patchesCache_'] === 'undefined') resource['_patchesCache_'] = []; // new array
		resource['_patchesCache_'] = resource['_patchesCache_'].concat(patches); // add new patches
		
		Restangular.one(resource['_path_'])
		.patch(resource['_patchesCache_'], {'requestType' : requestType})
		.then(function(data) {
			// Update resource data
			if(resource['_ifcEntryResource_']){
				resource['EditTemplateVariables'] = data.content;
			}
			else resource = $.extend(resource, data.content);
			
			// Update visual feedback (notifications and buttons)
			$rootScope.updateNotifications(data.notifications);
			processResponse(resource, data.invariantRulesHold, data.requestType);
			
			// Navto
			$location.url(navTo);
							
		});
	};
});