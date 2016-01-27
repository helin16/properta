/**
 * all angular controllers are here
 */
angular.module('mpApp.controllers', [])
	.controller('uploaderController', function($scope, mpAPIservice, $log) {
        $scope.partialDownloadLink = 'http://localhost:8080/download?filename=';
        $scope.filename = '';
        $scope.uploadFile = function() {
            $scope.processQueue();
        };
        $scope.reset = function() {
            $scope.resetDropzone();
        };
	})
    .directive('dropzone', function(){
        return {
            restrict: 'C',
            link: function(scope, element, attrs) {
                var config = {
                    url: 'http://localhost:8080/upload',
                    maxFilesize: 100,
                    paramName: "uploadfile",
                    maxThumbnailFilesize: 10,
                    parallelUploads: 1,
                    autoProcessQueue: false
                };
                var eventHandlers = {
                    'addedfile': function(file) {
                        scope.file = file;
                        if (this.files[1]!=null) {
                            this.removeFile(this.files[0]);
                        }
                        scope.$apply(function() {
                            scope.fileAdded = true;
                        });
                    },
                    'success': function (file, response) {
                    }
                };
                dropzone = new Dropzone(element[0], config);
                angular.forEach(eventHandlers, function(handler, event) {
                    dropzone.on(event, handler);
                });
                scope.processDropzone = function() {
                    dropzone.processQueue();
                };
                scope.resetDropzone = function() {
                    dropzone.removeAllFiles();
                }
            }
        }
    })
	.controller('groupsController', function($scope, mpAPIservice) {
		$scope.groupList = {};
		$scope.getData = function (pageNo) {
			mpAPIservice.getGroups({'page': (pageNo || 1)}).success(function (response) {
			    //Dig into the responde to get the relevant data
				if (response.data && response.data.length > 0) {
					if(!$scope.groupList.data) {
						$scope.groupList = {'totalPages': response.last_page, 'total': response.total, 'pageSize': response.per_page, 'data': response.data};
	        		} else {
	        			$scope.groupList.data = $scope.groupList.data.concat(response.data);
	        		}
	        		$scope.groupList.pageNo = response.current_page;
	        	}
	        });
	    };
	    $scope.getData(1);
	})
	.controller('groupController', function($scope, $routeParams, mpAPIservice) {
		$scope.id = $routeParams.id;
		$scope.group = {'details': null, 'members': []};
		
		mpAPIservice.getGroup($scope.id).success(function (response) {
			$scope.group.details = response;
		});
		mpAPIservice.getGroupMembers($scope.id).success(function (response) {
			$scope.group.members = response;
		});
		$scope.getGroupTransactions = function (pageNo) {
			mpAPIservice.getGroupTransactions($scope.id, {'page': (pageNo || 1)}).success(function (response) {
				if (response.data && response.data.length > 0) {
					if(!$scope.group.transactions) {
						$scope.group.transactions = {'totalPages': response.last_page, 'total': response.total, 'pageSize': response.per_page, 'data': {}};
					}
					$scope.group.transactions.pageNo = response.current_page;
					angular.forEach(response.data, function(value, key) {
						if (!$scope.group.transactions.data[value.transGroupId])
							$scope.group.transactions.data[value.transGroupId] = {};
						$scope.group.transactions.data[value.transGroupId][value.userId] = value.amount;
					});
	        	}
	        });
	    };
	    $scope.getGroupTransactions(1);
	})
	.controller('userController', function($rootScope, $scope, $routeParams, mpAPIservice) {
		$scope.requestedUser = {'id': $routeParams.id};
		
		$scope.getUser = function (userId) {
			mpAPIservice.getUser(userId).success(function (response) {
				$scope.requestedUser = response;
			});
		};
		$scope.getUser($rootScope.user.id);
	});