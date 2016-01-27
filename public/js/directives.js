var app = angular.module('mpApp.directives', [])
.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
 
                event.preventDefault();
            }
        });
    };
})
.directive('editableGroupName', ['$compile', 'mpAPIservice', function ($compile, mpAPIservice){
	return {
		restrict: 'AE',
		scope: {
			myDirModel: '='
		},
		template: '<strong class="edit-display editable-group-name" ng-click="edit()" ng-bind="myDirModel.details.name">{{myDirModel.details.name}}</strong><input class="form-control edit-input" ng-model="myDirModel.details.name" ng-blur="save(); noEdit()" ng-enter="save(); noEdit()"></input>'
		,link: function ( $scope, element, attrs ) {
			var inputElement = angular.element( element.children()[1] );
			element.addClass( 'edit-in-place' );
			$scope.editing = false;
			$scope.edit = function () {
				$scope.editing = true;
				element.addClass( 'active' );
				inputElement[0].focus();
			};
			$scope.noEdit = function () {
				$scope.editing = false;
				element.removeClass( 'active' );
			};
			$scope.save = function () {
				mpAPIservice.saveGroup($scope.myDirModel.details);
			};
		}
	};
}])
.directive('newUserToGroup', function ($compile){
	return {
		restrict: 'AE',
		scope: {
			ngModel: '='
		},
		template: '<button class="btn btn-success btn-xs" title="New Member" href="#" uib-popover-template="' + "'" + '/tpl/newUser.html' + "'" + '"  popover-placement="bottom" popover-animation="true"><i class="fa fa-plus"></i><span class="hidden-xs"> New Member</span></button>'
	};
})
.directive('newTransToGroup', function ($compile){
	return {
		restrict: 'AE',
		scope: {
			myDirModel: '='
		},
		template: '<button class="btn btn-info btn-xs" title="New Transaction" href="#" uib-popover-template="' + "'" + '/tpl/newTransToGroupForm.html' + "'" + '"  popover-placement="bottom" popover-animation="true"><i class="fa fa-plus"></i> <span class="">New Transaction</button>'
	};
})
.directive('editMePanel', function ($compile){
	return {
		restrict: 'AE',
		scope: {
			userModel: '='
		},
		templateUrl: '/tpl/editMe.html'
	};
})
.directive('userAvatar', function ($compile) {
	return {
		restrict: 'AE',
		scope: {
			ngModel: '='
		},
		templateUrl: '/tpl/userAvatar.html'
	};
})
.directive('resetPassword', function ($compile) {
	return {
		restrict: 'AE',
		scope: {
			needToComfirm: '=',
			ngUser: '='
		},
		templateUrl: '/tpl/resetUserPassword.html'
	};
})
.directive('passwordMatch', function ($compile) {
	return {
		require: 'ngModel',
		link: function (scope, confirmElement, attrs, controller) {
			var firstPassword = '#' + attrs.passwordMatch;
			confirmElement.add(firstPassword).on('keyup', function () {
				scope.$apply(function () {
					controller.$setValidity('password-matched', confirmElement.val() === $(firstPassword).val());
				});
			});
		}
	};
});