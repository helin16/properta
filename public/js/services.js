/**
 * all the data services are here
 */
angular.module('mpApp.services', []).
  factory('mpAPIservice', function($http) {
    var mpAPI = {};
    mpAPI.getGroups = function(parameters) {
      return $http({
        method: 'GET', 
        url: '/api/group',
        params: parameters
      });
    };
    mpAPI.getGroup = function(id, parameters) {
	  return $http({
        method: 'GET', 
        url: '/api/group/' + id,
        params: parameters
      });
	};
	mpAPI.saveGroup = function(group) {
		return $http({
			method: 'PUT', 
			url: '/api/group/' + group.id,
			params: group
		});
	};
	mpAPI.getGroupMembers = function(id, parameters) {
		return $http({
			method: 'GET', 
			url: '/api/group/' + id + '/user/all',
			params: parameters
		});
	};
	mpAPI.getGroupTransactions = function(id, parameters) {
		return $http({
			method: 'GET', 
			url: '/api/group/' + id + '/transaction/all',
			params: parameters
		});
	};
	mpAPI.getUser = function(id, parameters) {
		return $http({
			method: 'GET', 
			url: '/api/user/' + id,
			params: parameters
		});
	};

    return mpAPI;
  });