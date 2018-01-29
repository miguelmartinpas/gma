gepApp.controller('LoginController',['$scope', '$http', '$location', function($scope,$http,$location){
	
		$("#id-user").focus();
	
		$scope.user = "";
		$scope.pass = "";
	
		$scope.loginAction = function(showErrorMessage){

			 $('#id-loader').show(); 
 
			 $('#id-loader-sigin').show(); 
 
			 //$("#idIconButton").addClass("glyphicon-refresh");

			if ($scope.user==""){
				$scope.mensajeAlerta="Debe indicar el usuario";
				$("#id-user").focus();
				if (showErrorMessage) { $("#idMensajeAlerta").show(); }
				//$("#idIconButton").removeClass("glyphicon-refresh")
				$('#id-loader-sigin').hide();  
				$('#id-loader').hide();  
			}else if ($scope.pass==""){
				$scope.mensajeAlerta="Debe indicar una contraseña";
				$("#id-pass").focus();
				if (showErrorMessage) { $("#idMensajeAlerta").show(); }
				//$("#idIconButton").removeClass("glyphicon-refresh")
				$('#id-loader-sigin').hide();  
				$('#id-loader').hide();  
			}else{
			
				$http.get('/login/authentication/'+$scope.user+'/'+$scope.pass)
			       .success(function(data, status, headers, config) {
					   if(status=="200"){
						   if (data.status==0){
				    		   $scope.mensajeAlerta=data.message;
				    		   $("#idMensajeAlerta").show();
					    	   $('#id-loader').hide(); 
					    	   //$("#idIconButton").removeClass("glyphicon-refresh");
					    	   $('#id-loader-sigin').hide();  
				    	   }else{
				    		   window.location = $location.absUrl().replace("login","");
				    	   }    		
					   }
			        })
			        .error(function(data, status, headers, config) {
			        	 $scope.mensajeAlerta="Usuario o contraseña con caracteres inválidos.";
			    		 $("#idMensajeAlerta").show();
				    	 $('#id-loader').hide(); 
				    	 //$("#idIconButton").removeClass("glyphicon-refresh");
				    	 $('#id-loader-sigin').hide();  
			        });
				
			}
			
		}
	
	}]
);