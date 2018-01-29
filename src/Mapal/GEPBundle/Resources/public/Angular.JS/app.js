var getAppConfig = function($interpolateProvider){
	$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}

var gepApp = angular.module('gepApp',[]);

gepApp.config(getAppConfig);