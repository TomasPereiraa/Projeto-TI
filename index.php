<!--Nome e password os 3 utilizadores-->
<?php
$username = "Guest";
$password = "Guest";
$username1 = "User";
$password1 = "User";
$username2 = "Admin";
$password2 = "Admin";


session_start();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <!--Nome da página-->
    <title>Smart Restaurant Login
    </title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
</head>
<!--fundo da pagina em imagem-->

<body style="background: url(imgs/fundo3.png);background-size:cover">

    <div class="container">
        <!--verificação dos users e passwords, respetivamente e indicaçao de autenticaçao bem sucedida ou falhada-->
        <?php

        if (isset($_POST['username']) && isset($_POST['password'])) {
            if (($_POST['username'] == $username && $_POST['password'] == $password)) {
                $_SESSION["username"] = $_POST['username'];
                $_SESSION["password"] = $_POST['password'];

                echo '
                    <div class="alert alert-success style="text-align:center">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                       <p style="margin-top:auto; margin-bottom:auto;text-align:center"> Autenticação bem sucedida, por favor aguarde!</p>
                    </div>';
                header("refresh:5;url=dashboard1.php");
            } elseif (($_POST['username']== $username1 && $_POST['password'] == $password1)){
                $_SESSION["username"] = $_POST['username'];
                $_SESSION["password"] = $_POST['password'];

                echo '
                    <div class="alert alert-success style="text-align:center">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                       <p style="margin-top:auto; margin-bottom:auto;text-align:center"> Autenticação bem sucedida, por favor aguarde!</p>
                    </div>';
                header("refresh:5;url=dashboard2.php");
            }elseif(($_POST['username']==$username2 && $_POST['password']== $password2)){
                $_SESSION["username"] = $_POST['username'];
                $_SESSION["password"] = $_POST['password'];

                echo '
                    <div class="alert alert-success style="text-align:center">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                       <p style="margin-top:auto; margin-bottom:auto;text-align:center"> Autenticação bem sucedida, por favor aguarde!</p>
                    </div>';
                header("refresh:5;url=dashboard.php");
            }else{
                echo '
                <div class="alert alert-failure style="text-align:center">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                   <p style="margin-top:auto; margin-bottom:auto;text-align:center"> Autenticação falhada</p>
                </div>';
            }
        }
        ?>
        <!--nome do site"Smart Restaurant", adição de uma foto/logotipo, 2 áreas para se intrudzir o "nome do utilizador"e a "password" e botão de submeter para ir para a pagina principal-->
        <div class="container">
            <h1 class="mt-5 text-center" style="font-family: 'Dancing Script', cursive; color:#242329;"> Smart Restaurant </h1> <br>
            <div class="row">
                <div class="col-sm-4 offset offset-sm-4">
                    <form id="login" method="POST">
                        <div class="form-group">
                            <a href="index.php"><img class="text-center" src="imgs/logo.png" width="300" alt="RESTAURANTE logo"></a>
                        </div>
                        <div class="form-group">
                            <label for="usr">Username:</label>
                            <input type="text" class="form-control" id="usr" name="username"  placeholder="Nome do utilizador" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-cor text-light">Submeter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <!--SCRIPTS-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>