gepApp.controller('SystemParamController',['$scope', '$http', '$location', function($scope,$http,$location){
			
			$scope.id = "";
			$scope.key = "";
			$scope.value = "";
	
			// Load the system params
			$scope.loadSystemParams = function(){
				
				$('#id-loader').show();   
				
				$http.get('/admin/system/param/get/all')
			       .success(function(data, status, headers, config) {
					   if(status="200"){
						   $scope.systemParams = data.json;
						   $('#idSysteParamTable').show();
						   $('#id-loader').hide();    		
					   }
			        })
			        .error(function(data, status, headers, config) {
			            // called asynchronously if an error occurs
			            // or server returns response with an error status.
			        });
				
			}
			
			$scope.loadSystemParams();
			
			// Show and load the edit form
			$scope.edit = function( key ){
				
				$('#id-loader').show();  
				$('#idFormEdit').hide();  
				
				if (key!=""){
					
					$http.get('/admin/system/param/get/'+key)
				       .success(function(data, status, headers, config) {
						   if(status="200"){
					    	   $scope.id = data.json.id;
					    	   $scope.key = data.json.key;
					    	   $scope.value = data.json.value;
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
			    	$scope.key = "";
			    	$scope.value = "";
					$('#idFormEdit').show();
			    	$('#id-loader').hide();    
				}
					
			}
			
			// Show and load the delete form
			$scope.remove = function( key ){
				
				$scope.keyToDelete = key;
	
				$('#id-loader').show();  
				$('#idFormDelete').hide();
				
				$http.get('/admin/system/param/get/'+key)
			       .success(function(data, status, headers, config) {
						   if(status="200"){		    	 
					    	   $scope.messageDelete = "¿Desea borrar la clave '"+data.json.key+"'?";
					    	   $scope.keyToDelete = key;
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
			/*	
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
			*/
			}
			
			
			// Send data to delete
			$scope.closeEdit = function (){
				$scope.id = "";
		    	$scope.key = "";
		    	$scope.value = "";
			}
			
			// Send data to delete
			$scope.sendDelete = function (){
			/*	
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
			*/	
			}
			
			// Send data to delete
			$scope.closeDelete = function (){
				$scope.keyToDelete = "";
			}
			
			// filter to order the fields
			$scope.orderFieldBy = function( orden ){
				$scope.selectedOrder = orden;
			}
	
		}
	]
);