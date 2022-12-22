<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="storage/login_files/images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="storage/login_files/css/util.css">
    <link rel="stylesheet" type="text/css" href="storage/login_files/css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form method="post" action="/loginHandler" class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Dobrodošli
					</span>
                <span class="login100-form-title p-b-48">
						<img src="storage/loginLogo.svg" alt="loginLogo">
					</span>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="email">
                    <span class="focus-input100" data-placeholder="Email"></span>
                </div>

                <div class="wrap-input100 validate-input">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                    <input class="input100" type="password" name="password">
                    <span class="focus-input100" data-placeholder="Unesite lozinku"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="storage/login_files/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="storage/login_files/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="storage/login_files/vendor/bootstrap/js/popper.js"></script>
<script src="storage/login_files/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="storage/login_files/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="storage/login_files/vendor/daterangepicker/moment.min.js"></script>
<script src="storage/login_files/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="storage/login_files/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="storage/login_files/js/main.js"></script>

</body>
</html>
