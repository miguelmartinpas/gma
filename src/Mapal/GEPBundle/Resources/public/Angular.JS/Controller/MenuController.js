/*gepApp.controller('MenuController',['$scope', '$http', '$location', function($scope,$http,$location){
			$('#navbar').show();  		
			//$scope.menu = [{name:"Inicio",link:"/"},{name:"Usuario",link:"/admin/user"},{name:"Salir",link:"/logout"}];
	
			// Load the menu
			$scope.loadMenu = function(){
				
				$http.get('/rest/menu')
			       .then(function(res){
			    	   $scope.menu = res.data;
			    	   $('#navbar').show();  		
			        });
				
			}
			
			//$scope.loadMenu();
	
		}
	]
);*/