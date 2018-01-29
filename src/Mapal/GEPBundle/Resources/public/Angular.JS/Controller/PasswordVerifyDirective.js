
gepApp.directive("passwordVerify", function() {
   return {
      require: "ngModel",
      scope: {
        passwordVerify: '='
      },
      link: function(scope, element, attrs, ctrl) {
        scope.$watch(function() {
            var combined;

            if (scope.passwordVerify || ctrl.$viewValue) {
               combined = scope.passwordVerify + '_' + ctrl.$viewValue; 
            }                    
            return combined;
        }, function(value) {
            if (value) {
                ctrl.$parsers.unshift(function(viewValue) {
                    var origin = scope.passwordVerify;
                    if (origin !== viewValue) {
                        ctrl.$setValidity("passwordVerify", false);
                        return undefined;
                    } else {
                        ctrl.$setValidity("passwordVerify", true);
                        return viewValue;
                    }
                });
            }
        });
     }
   };
});

gepApp.controller('UserController',['$scope', '$http', '$location', function($scope,$http,$location){
			
			// Load the users
			$scope.loadUsers = function(){
				
				$('#id-loader').show();   
				
				$http.get('/admin/user/get/all')
			       .success(function(data, status, headers, config) {
					   if(status="200"){
						   $scope.users = data.json;
						   $('#idUserTable').show();
						   $('#id-loader').hide();    		
					   }
			        })
			        .error(function(data, status, headers, config) {
			            // called asynchronously if an error occurs
			            // or server returns response with an error status.
			        });
				
			}
			
			$scope.loadUsers();
			
			// Show and load the edit form
			$scope.edit = function( id ){

				$('#id-loader').show();  
				$('#idFormEdit').hide();  
				
				if (id>0){
					
					$http.get('/admin/user/get/'+id)
				       .success(function(data, status, headers, config) {
						   if(status="200"){
					    	   $scope.id = data.json.id;
					    	   $scope.name = data.json.name;
					    	   $scope.user = data.json.user;
					    	   $scope.email = data.json.email;
					    	   $scope.pass = "";
					    	   $scope.pass2 = "";
					    	   $scope.isadmin = (data.json.isAdmin==1);
					    	   $('#idFormEdit').show();
					    	   $('#id-loader').hide();  
						   }
				        })
				        .error(function(data, status, headers, config) {
				            // called asynchronously if an error occurs
				            // or server returns response with an error status.
				        });
					
				}else{
					$scope.id = "";
					$('#idFormEdit').show();
			    	$('#id-loader').hide();    
				}
					
			}
			
			// Show and load the delete form
			$scope.delete = function( id ){
	
				$('#id-loader').show();  
				$('#idFormDelete').hide();
				
				$http.get('/admin/user/get/'+id)
			       .success(function(data, status, headers, config) {
						   if(status="200"){		    	 
					    	   $scope.messageDelete = "¿Desea borrar el usuario '"+data.json.name+"'?";
					    	   $scope.idToDelete = id;
					    	   $('#idFormDelete').show();
					    	   $('#id-loader').hide();    		
						   }
			        })
			        .error(function(data, status, headers, config) {
			            // called asynchronously if an error occurs
			            // or server returns response with an error status.
			        });
				
			}
			
			// Send data to save
			$scope.sendEdit = function (){
				
				$('#id-loader').show();  
			
				$params = "";
				
				$params += "/"+(($scope.id!="")?$scope.id:"0");
				
				$params += "/"+$scope.user;
				
				$params += "/"+$scope.password;
				
				$params += "/"+$scope.name;
				
				$params += "/"+$scope.email;
				
				$params += "/"+(($scope.isadmin)?"1":"0");

				$http.get('/admin/user/saveorupdate'+$params)
			       .success(function(data, status, headers, config) {
						   if(status="200"){		    	 
					    	   $scope.id = data.json.id;
					    	   $('#idFormDelete').show();
					    	   $('#id-loader').hide();    		
						   }
			        })
			        .error(function(data, status, headers, config) {
			            // called asynchronously if an error occurs
			            // or server returns response with an error status.
			        });
			
			}
			
			// Send data to delete
			$scope.closeEdit = function (){
				$scope.id = res.data.id;
		    	   $scope.name = "";
		    	   $scope.user = "";
		    	   $scope.email = "";
		    	   $scope.pass = "";
		    	   $scope.pass2 = "";
		    	   $scope.isadmin = false;
			}
			
			// Send data to delete
			$scope.sendDelete = function (){
				
			}
			
			// Send data to delete
			$scope.closeDelete = function (){
				$scope.idToDelete = 0;
			}
			
			// filter to order the fields
			$scope.orderFieldBy = function( orden ){
				$scope.selectedOrder = orden;
			}
	
		}
	]
);