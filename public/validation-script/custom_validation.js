$(function() {

 
 $("#submitButton" ).click(function() {
		   
   $("#validate-js").validate({
	   
	  errorElement: 'span', 
	   errorClass: 'formerror',
       
        rules: {
           // owner_fname: { 
           	password : {
			            required:true,
			            minlength:[6]
						}
	       /* owner_lname: { 
			             required:true  
						 },
	        restaurant_name: { 
			              required:true,  
						  },
	        owner_email: { 
			               required:true,
						   email:true
						 },
			owner_password: { 
			              required:true,
						  minlength:[6] 
				  		  },
	        owner_re_password: { 
			              required:true,  
				  		  equalTo: "#psword"
						   },
	        owner_contact: { 
			              required:true,  
				  		  phone: true
						   },
			location: { 
			              required:true,  
				  		   }	*/					   
	        
						 
	            },
	            messages :{
	            	password: {
	            		required: 'This is required field'
	            	}
	            },
            submitHandler: function(form) 
			    {
                 form.submit();
                 }
            });
     });
 
 
 });
