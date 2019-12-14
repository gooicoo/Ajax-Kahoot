<!DOCTYPE html>
<html>
    
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel=stylesheet href="./CSS/registrarUsuarioCSS.css">

</head>

<body>
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
                <div class="d-flex justify-content-center form_container effect5" style="height:230px;">
                    <form method="post" enctype="multipart/form-data">
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
                        <div class="input-group mb-2" style="margin-top: 18px;">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control input_pass" value="" placeholder="Email">
                        </div>
                        <div class="input-group mb-2" style="margin-top: 18px;">
                            <input type="file" name="image" style="font-size: 15px;">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox"><?php require('comprobarRegistroPHP.php'); ?></div>
                        </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="sumbit" class="btn login_btn">Create account!</button>
                    </div>
                    </form>
                </div>
        
                
                    <div class="d-flex justify-content-center links" style="position: relative; bottom: -88px;">
                        Do you have an account? <a href="index.php" class="ml-2">Login!</a>
                    </div>
               
        
            </div>
        </div>
    </div>
</body>

</html>