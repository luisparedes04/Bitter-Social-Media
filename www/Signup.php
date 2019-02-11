<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="signup page for bitter website. Sing up and start bittering right away">
    <meta name="author" content="LuisParedes luissao_20@hotmail.com">
    <link rel="icon" href="Images/favicon.ico">

    <title>Signup - Bitter</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
    
    
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	
    <script src="includes/bootstrap.min.js"></script>
    <script type="text/javascript" src="includes/jquery-3.3.1.min.js"></script>
    
	<script type="text/javascript">
		//any JS validation you write can go here
            
        var go = function(){
        
        var fields = {
		firstname: {required: "first name required"},
                lastname: {required: "last name required"},
		email: {required: "Email is required", isEmail: "Email is invalid. enter valid format ex: name@something.com"},
		username: {required: "Username is required"},
		phone: {required: "Phone is required", isPhoneNum: "Enter valid number (123) 123-1234"},
		address: {required: "Address is required"},		
		postalCode: {required: "Postal Code is required", isPostalCode: "Enter a valid postal coda 1A1 1A1"},	
		desc: {required: "Description is required"},
		location: {required: "Location is required"},
		password: {required: "password is required", isPassword: "Password and confirmation password do not match"},
           	confirm: {required: "confirm password is required"}
	};
        
        for( var fieldName in fields){
                var str = document.getElementById(fieldName).value;
                var myTrim = str.trim();
                var field = fields[fieldName];
                
                if(myTrim.length == 0){
                    alert(field.required);
                    return false;
                }
                if(field.isEmail){
                    var pattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}$/i;
                    var temail = pattern.test(document.getElementById(fieldName).value);
                    if(temail == false){
                        alert(field.isEmail);
                        return false;
                    }
                }
                if(field.isPhoneNum){
                    var pattern = /^\(\d{3}\) ?\d{3}(-)|( )?\d{4}$/;
                    var tphone = pattern.test(document.getElementById(fieldName).value);  
                    if(tphone == false){
                        alert(field.isPhoneNum);
                        return false;
                    }                    
                }
                if(field.isPostalCode){
                    var pattern = /^(?!.*[DFIOQU])[A-VXY][0-9][A-Z] ?[0-9][A-Z][0-9]$/;
                    var tpostal = pattern.test(document.getElementById(fieldName).value);  
                    if(tpostal == false){
                        alert(field.isPostalCode);
                        return false;
                    }                    
                }
                if (field.isPassword){
                    var pass = document.getElementById(fieldName).value;
                    var confirm = document.getElementById("confirm").value;
                    if(pass != confirm){
                        alert(field.isPassword);
                        return false;
                    }
                }
                
        }
            
            return true;
};
function frm_submit(){
                  $.post(
                 "AjaxValidateScreenName.php",
                 $("#registration_form").serializeArray(),
                 function(data){
                     
                     $("#mySpan").text(data.msg);
                 },
                 //"html"
                 "json"
                );
                return false;
};

function validatePC(){
    
    $.post(
                 "ValidatePostalCodeWS.php",
                 $("#registration_form").serializeArray(),
                 function(data){
                     var prov = $('#province').val()
                     compare(data, prov);
                 },
                 "html"            
            );
    return false;
};

function compare(data, prov){
    
        
        if(prov === "British Columbia"){ prov = "BC";}
        else if(prov === "Alberta"){ prov = "AB";}
        else if(prov === "Saskatchewan"){ prov = "SK";}
        else if(prov === "Manitoba"){ prov = "MB";}
        else if(prov === "Ontario"){ prov = "ON";}
        else if(prov === "Quebec"){ prov = "QC";}
        else if(prov === "New Brunswick"){ prov = "NB";}
        else if(prov === "Prince Edward Island"){ prov = "PE";}
        else if(prov === "Nova Scotia"){ prov = "NS";}
        else if(prov === "Newfoundland and Labrador"){ prov = "NL";}
        else if(prov === "Northwest Territories"){ prov = "NT";}
        else if(prov === "Nunavut"){ prov = "NU";}
        else if(prov === "Yukon"){ prov = "YT";}
        
        if(data !== prov){
            $("#mySpann").text("Enter a valid Postal Code for your province");
            $("#province").val("null");
        }else{
            $("#mySpann").text("Good to go");
        }
        
};

function check(){
    var data = $("#postalCode").val();
    if( data !== ""){
        validatePC();
    }
};
	</script>
  </head>

  <body>
<?php
//include("Includes/header.php");

         if(isset($_GET["msg"])){
                echo "<script>alert('".$_GET["msg"]."');</script>";
         } 
?>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<a class="navbar-brand" href="index.html"><img src="images/logo.jpg" class="logo"></a>
		
        
      </div>
    </nav>
	<BR><BR>
    <div class="container">
		<div class="row">
			
			<div class="main-login main-center">
				<h5>Sign up once and troll as many people as you like!</h5>
					<form method="post" id="registration_form" action="signup_proc.php" onsubmit="return go()">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">First Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="firstname" id="firstname"  placeholder="Enter your First Name" maxlength="50"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Last Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="lastname" id="lastname"  placeholder="Enter your Last Name" maxlength="50"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="email" id="email"  placeholder="Enter your Email" maxlength="100"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Screen Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" onblur="frm_submit()" required name="username" id="username"  placeholder="Enter your Screen Name" maxlength="50"/><span id="mySpan"></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" required name="password" id="password"  placeholder="Enter your Password" maxlength="250"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" required name="confirm" id="confirm"  placeholder="Confirm your Password" maxlength="250"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Phone Number</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="phone" id="phone"  placeholder="Enter your Phone Number" maxlength="25"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Address</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="address" id="address"  placeholder="Enter your Address" maxlength="200"/>
								</div>
							</div>
						</div>
						
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Province</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
                                                                    <select name="province" id="province" onchange="check()"maxlength="50" class="textfield1" required><?php echo $vprovince; ?> 
										<option> </option>
										<option value="British Columbia">British Columbia</option>
										<option value="Alberta">Alberta</option>
										<option value="Saskatchewan">Saskatchewan</option>
										<option value="Manitoba">Manitoba</option>
										<option value="Ontario">Ontario</option>
										<option value="Quebec">Quebec</option>
										<option value="New Brunswick">New Brunswick</option>
										<option value="Prince Edward Island">Prince Edward Island</option>
										<option value="Nova Scotia">Nova Scotia</option>
										<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
										<option value="Northwest Territories">Northwest Territories</option>
										<option value="Nunavut">Nunavut</option>
										<option value="Yukon">Yukon</option>
									  </select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Postal Code</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" onblur="validatePC()" required name="postalCode" id="postalCode"  placeholder="Enter your Postal Code" maxlength="7"/><span id="mySpann"></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Url</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="url" class="form-control" name="url" id="url"  placeholder="Enter your URL. Like https://www.example.com" maxlength="50"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Description</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="desc" id="desc"  placeholder="Description of your profile" maxlength="160"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Location</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="location" id="location"  placeholder="Enter your Location" maxlength="50"/>
								</div>
							</div>
						</div>
						
						
						<div class="form-group ">
							<input type="submit" name="button" id="button" value="Register" class="btn btn-primary btn-lg btn-block login-button"/>
							
						</div>
						
					</form>
				</div>
			
		</div> <!-- end row -->
    </div><!-- /.container -->
    
  </body>
</html>