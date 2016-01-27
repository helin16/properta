/**
 * the app registration
 */

var app = angular.module('mpApp', [
  'mpApp.directives',
      'mpApp.services',
      'mpApp.controllers',
      'ui.bootstrap',
      'ngRoute',
])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider
      .when("/group", {templateUrl: "/tpl/groups.html", controller: "groupsController"})
      .when("/group/:id", {templateUrl: "/tpl/group.html", controller: "groupController"})
      .when("/me", {templateUrl: "/tpl/me.html", controller: "userController"})
      .when("/uploader", {templateUrl: "/tpl/uploader.html", controller: "uploaderController"})
      .otherwise({redirectTo: '/uploader'});
}])
.run(['$rootScope', function($rootScope){
	$rootScope.user = {"id":1,"active":1,"created":"2006-03-01 23:41:27","createdById":1,"updated":"1996-02-09 11:42:12","updatedById":1,"firstname":"Gilbert","lastname":"Luettgen","email":"fLegros@hotmail.com"}
}])
;