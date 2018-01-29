gepApp.controller('TimeTableController',['$scope', '$http', function($scope,$http){
	
			$.loader({
				className:"blue-with-image",
				content:''
			});
	
			// show loader image
			$('#id-loader').show();
			// Array with month's name
			$scope.months = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", 
			                  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
			
			$scope.shortMonths = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", 
			                  "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];

			// Get actually month and year
			var d = new Date();
			
			$scope.defaultMonth = d.getMonth()+1;
			$scope.defaultYear = d.getFullYear();
			
			$scope.month = $scope.defaultMonth;
			$scope.year = $scope.defaultYear;
			
			$scope.returnMessage = "Volver a "+$scope.months[$scope.defaultMonth-1]+" "+$scope.defaultYear;
			
			// Create filter with year and month
			$scope.urlFiltro = "/"+$scope.year+"/"+$scope.month;
			
			// Load the name of month
			$scope.monthName = $scope.months[$scope.month-1];
			$scope.monthNameShort = $scope.shortMonths[$scope.month-1];
						
			// FUNCTION: change the mont to show
			$scope.changeMonth = function (indice){
				
				$.loader({
					className:"blue-with-image",
					content:''
				});
				
				$('#id-loader').show();
				//$('#idTimeTable').hide();
				
				$scope.month += indice;
				
				if ( $scope.month == 0 ){
					$scope.month = 12;
					$scope.year -= 1;
				}else if ( $scope.month == 13 ){
					$scope.month = 1;
					$scope.year += 1;
				}
				
				$scope.monthName = $scope.months[$scope.month-1];
				$scope.monthNameShort = $scope.shortMonths[$scope.month-1];
					
				$scope.urlFiltro = "/"+$scope.year+"/"+$scope.month;
				
				$scope.monthName = $scope.months[$scope.month-1];
							
				$scope.loadTimeTable();
				
			}
			
			$scope.changeToNow = function(){
				$scope.month = $scope.defaultMonth;
				$scope.year = $scope.defaultYear;
				$scope.changeMonth(0);
			}
			
			// FUNCTION: Call to timetable REST
			$scope.loadTimeTable = function(){
				
				// Cabecera de semanas			
				$http.get('/rest/timetable/header'+$scope.urlFiltro)
			       .success(function(data, status, headers, config) {
			    	   if(status="200"){
				    	   $scope.tmpWeeks = data.json; 
				    	   // Datos
							$http.get('/rest/timetable'+$scope.urlFiltro)
						       .success(function(data, status, headers, config) {
						    	   if(status="200"){
							    	   $scope.users = data.json;  
							    	   $scope.weeks = $scope.tmpWeeks; 
							    	   $("#disabled").prop('disabled', true);
							    	   $('#idTimeTable').show();
							    	   $('#id-loader').hide();
							    	   $.loader('close');
						    	   }
						        })
						        .error(function(data, status, headers, config) {
						            // called asynchronously if an error occurs
						            // or server returns response with an error status.
						        });
			    	   }
			        })
			        .error(function(data, status, headers, config) {
			            // called asynchronously if an error occurs
			            // or server returns response with an error status.
			        });
				
			}
			
			// Load the Timetable the first time
			$scope.loadTimeTable();
			
			// FUNCTION: Change the status of the userWeek;
			$scope.nextStatus = function(idUser,idWeek,idStatus){
				
				/*$.loader({
					className:"blue-with-image",
					content:''
				});*/
				
	    		$('#id_'+idUser+"_"+idWeek+"_"+idStatus+"_icon").removeAttr('class');
	    		$('#id_'+idUser+"_"+idWeek+"_"+idStatus+"_icon").attr('class', 'glyphicon');
				
				$('#id-loader').show();
				
				$('#id-loader_'+idUser+"_"+idWeek+"_"+idStatus).show();
				
				$http.get('/rest/change/status/'+idUser+'/'+idWeek+'/'+idStatus)
			       .success(function(data, status, headers, config) {
			    	   if(status="200"){
			    	   
			    		   //idNewStatus = data.json.id;
			    		   //nameNewStatus = data.json.name;
			    		   //iconNewStatus = data.json.icon;
			    		   //colourNewStatus = data.json.colour;
			    		   
			    		   //$('#id-loader_'+idUser+"_"+idWeek+"_"+idStatus)
			    		   
			    		   //$('#id-loader_'+idUser+"_"+idWeek+"_"+idStatus+"_icon")
			    		   
			    		   //$('#id-loader_'+idUser+"_"+idWeek+"_"+idStatus).hide();
			    		   
			    		   $scope.loadTimeTable();
			    		   
			    	   }
			        });
				
			}
			
			// FUNCTION: Change the status of all week of user in this year and this month
			$scope.nextAllStatus = function(idUser){
				
				$.loader({
					className:"blue-with-image",
					content:''
				});
				
				$('#id-loader').show();
				
				$http.get('/rest/change/all/status/'+idUser+'/'+$scope.year+'/'+$scope.month)
			       .success(function(data, status, headers, config) {
			    	   if(status="200"){
			    	   
			    		   $scope.loadTimeTable();
			    		   
			    	   }
			        });
				
			}
			
		}
	]
);
