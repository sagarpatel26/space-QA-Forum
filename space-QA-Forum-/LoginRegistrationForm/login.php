<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login and Registration Form with HTML5 and CSS3</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <link rel="stylesheet" type="text/css" href="../css/space.index.tmpl.css" />
    </head>
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="">
                 <!--   <strong>&laquo; Previous Demo: </strong>Responsive Content Navigator  -->
                </a>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            <header>
                <h1>Welcome to SPACE</h1>
				<nav class="codrops-demos">
				</nav>
            </header>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin""></a>

                    <div id="temp">
                    </div>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="../scripts/loginverifier.php" autocomplete="on" method="POST">
                                <h1>Log in</h1>

<!--****************************************************************************************************************************************************-->
                                <?php
                                if(isset($_COOKIE["status"]))
                                {
                                    if ($_COOKIE["status"]=="wrongpassword")
                                    {
                                        echo "<h6 style='color: red;align-content: center; padding-left: 18%;'>Your Password was wrong, please try again.</h6><br />";
                                    }
                                    if ($_COOKIE["status"]=="successfullyregistered")
                                    {
                                        echo "<h6 style='color: lightgreen;align-content: center; padding-left: 13%;'>You were successfully registered Login to proceed.</h6><br />";
                                    }
                                }
                                ?>
<!--****************************************************************************************************************************************************-->

                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your username </label>
                                    <input id="username" name="username" required="required" type="text" placeholder="myusername"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                                                <p class="login button"> 
                                    <input type="submit" value="Login" /> 
								</p>
                                <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Join us</a>
								</p>
                            </form>
                        </div>

                        <div id="register" class="animate form">
                            <form  action="../scripts/registeruser.php" autocomplete="on" method="POST">
                                <h1> Register Yourself </h1>

<!--****************************************************************************************************************************************************-->
                                <?php
                                if(isset($_COOKIE["status"]))
                                {
                                    if ($_COOKIE["status"]=="register")
                                    {
                                         echo "<h6 style='color: red;align-content: center; padding-left: 20px;padding-right: 20px;'>It seems you haven't got your Space, feel free to register anytime.</h6><br />";
                                    }
                                    if ($_COOKIE["status"]=="clearall")
                                    {
                                        echo "<h6 style='color: orangered;align-content: center; padding-left: 20px;padding-right: 20px;'>Opps!! It seems something went wrong, will you please try again.</h6><br />";
                                    }
                                }
                                ?>
<!--****************************************************************************************************************************************************-->

                                <p>
                                    <label for="firstname" class="firstname" data-icon="u">Your First Name</label>
                                    <input id="usernamesignup" name="firstname" required="required" type="text" placeholder="Enter First Name" />
                                </p>
								<p> 
                                    <label for="lastname" class="firstname" data-icon="u">Your Last Name</label>
                                    <input id="usernamesignup" name="lastname" required="required" type="text" placeholder="Enter Last Name" />
                                </p>
								<p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your Username</label>
                                    <input id="usernamesignup" name="username" required="required" type="text" placeholder="Enter Username" data-validation="server" data-validation-url="/SpaceV0.0/scripts/validators/username.php"/>
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="email" required="required" type="email" placeholder="Enter email" data-validation="server" data-validation-url="/SpaceV0.0/scripts/validators/email.php"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="password" required="required" type="password" placeholder="Enter Password:" data-validation="strength" data-validation-strength="2"/>
                                </p>
                                <p>
                                    <script>
                                        function checkPassword()
                                        {
                                            password = document.getElementById("passwordsignup");
                                            confirmpassword = document.getElementById("passwordsignup_confirm");
                                            errmssg = document.getElementById("my_errmsg");
                                            if (password.value != confirmpassword.value)
                                            {
                                                errmssg.innerHTML = "Confirmation Password doesn't match";
                                                confirmpassword.style.borderColor = "red";
                                            }
                                            else
                                            {
                                                errmssg.innerHTML = "";
                                                confirmpassword.style.borderColor = "";
                                            }
                                        }
                                    </script>
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="confirmpassword" required="required" type="password" placeholder="Confirm Password" onchange="checkPassword()"/>
                                    <p id="my_errmsg"></p>
                                </p>
                                <p class="signin button"> 
									<input type="submit" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>

<!--****************************************************************************************************************************************************-->
                            <script src="../js/jquery.js"></script>
                            <script src="../js/form-validator/jquery.form-validator.min.js"></script>

                            <script>
                                $.validate({
                                    modules : 'security',
                                    onModulesLoaded : function() {
                                        var optionalConfig = {
                                            fontSize: '12pt',
                                            padding: '4px',
                                            bad : 'Very bad',
                                            weak : 'Weak',
                                            good : 'Good',
                                            strong : 'Strong'
                                        };

                                        $('input[name="pass"]').displayPasswordStrength(optionalConfig);
                                    }
                                });
                            </script>
<!--****************************************************************************************************************************************************-->
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>
