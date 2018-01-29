//http://blog.brunoscopelliti.com/form-validation-the-angularjs-way
gepApp.directive('ngUnique', ['$http', function (async) {
  return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    	
      elem.on('blur', function (evt) {
        
    	  scope.$apply(function () {
          
    		// Load the input
        	var val = elem.val();
        	
        	// Load teh param in condition
        	var field = attrs.ngUnique;
          
        	// async ajax call
        	var ajaxConfiguration = { method: 'GET', url: '/admin/user/isunique/'+field+'/'+val };
          
        	async(ajaxConfiguration).success(function(data, status, headers, config) {
            	
            	if (!data.error){

            		ctrl.$setValidity('unique', data.json.isUnique);
            		
            	} 
            	
            });
        	
          });
        
        });
      
      }
    }
  }
]);