gepApp.controller('UserController',['$scope', '$http', '$location', function($scope,$http,$location){
			
			$scope.id = "";
			$scope.name = "";
			$scope.user = "";
			$scope.email = "";
			$scope.password = "";
			$scope.password_verify = "";
			$scope.isadmin = false;
	
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
					    	   $scope.password = "";
					    	   $scope.password_verify = "";
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
			    	$scope.name = "";
			    	$scope.user = "";
			    	$scope.email = "";
			    	$scope.password = "";
			    	$scope.password_verify = "";
			    	$scope.isadmin = false;
					$('#idFormEdit').show();
			    	$('#id-loader').hide();    
				}
					
			}
			
			// Show and load the delete form
			$scope.remove = function( id ){
				
				$scope.idToDelete = id;
	
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
					    	   $scope.loadUsers();
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
				
				$('#id-loader').show();  

				$params = "";
				
				$params += "/"+$scope.idToDelete;
			
				$http.get('/admin/user/delete'+$params)
			       .success(function(data, status, headers, config) {
						   if(status="200"){		    	 
					    	   $scope.id = data.json.id;
					    	   $('#idFormDelete').show();
					    	   $('#id-loader').hide(); 
					    	   $scope.loadUsers();
						   }
			        })
			        .error(function(data, status, headers, config) {
			            // called asynchronously if an error occurs
			            // or server returns response with an error status.
			        });
				
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