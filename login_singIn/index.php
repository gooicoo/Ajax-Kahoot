<!DOCTYPE html>
<html>

<head>
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel=stylesheet href="./CSS/loginKahoot_CSS.css">
</head>

<body>
    <?php session_start(); require('../php/Alerts.php');?>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <div class="brand_logo blob" alt="Logo">
                            <pre class="letters">IETI <br> KAHOOT</pre>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container effect5 column" style="width: 100%;">
                    <form method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="user_name" class="form-control input_user" placeholder="Username">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control input_pass" value="" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox"><?php require('comprobarUsuarioPHP.php'); ?></div>
                        </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="sumbit" class="btn login_btn">Login</button>

                    </div>
                    </form>

                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-center links" >
                        Do you want to play a kahoot? <a href="../landingPage/index.php" class="ml-2">Play!</a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links" style="margin-top: -16px;">
                        Don't have an account? <a href="registrarUsuario_PHP.php" class="ml-2">Sign Up!</a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links" style="margin-top: -16px;">
                        Forgot your password? <a href="forgotPassword.php" class="ml-2">Click here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
