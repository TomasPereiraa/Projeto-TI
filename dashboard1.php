<!--Verificação se foi iniciada a sessão, se nao indica que o acesso é restrito-->
<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("refresh:5;url=index.php");
  die("Acesso restrito.");
}
//Criação da variável para cada um dos atributos de cada sensor -> valor, hora, nome
$valor_temp = file_get_contents("api/files/temperatura/valor.txt");
$hora_temp = file_get_contents("api/files/temperatura/hora.txt");
$nome_temp = file_get_contents("api/files/temperatura/nome.txt");

$valor_lot = file_get_contents("api/files/lotacao/valor.txt");
$hora_lot = file_get_contents("api/files/lotacao/hora.txt");
$nome_lot = file_get_contents("api/files/lotacao/nome.txt");

$valor_door = file_get_contents("api/files/porta/valor.txt");
$hora_door = file_get_contents("api/files/porta/hora.txt");
$nome_door = file_get_contents("api/files/porta/nome.txt");

$valor_humidade=file_get_contents("api/files/humidade/valor.txt");
$hora_humidade=file_get_contents("api/files/humidade/hora.txt");
$nome_humidade=file_get_contents("api/files/humidade/nome.txt");

$valor_fogo=file_get_contents("api/files/incendio/valor.txt");
$hora_fogo=file_get_contents("api/files/incendio/hora.txt");
$nome_fogo=file_get_contents("api/files/incendio/nome.txt");

$nome_webcam=file_get_contents("api/files/webcam/nome.txt");
$hora_webcam=file_get_contents("api/files/webcam/hora.txt");


$estado_lot;
$porta;
$luz= "Acessas";

//Condição que altera o estado da lotação consoante o seu valor
if ($valor_lot == 250) {
  $estado_lot = "Esgotado";
} else if ($valor_lot > 250) {
  $estado_lot = "Sobrelotado";
} else {
  $estado_lot = "Disponivel";
}


//Condição que altera o estado da temperatura consoante o seu valor
if ($valor_temp < 17) {
  $estado_temp = "Temperatura Fria";
} else if ($valor_temp >= 17 && $valor_temp <= 25) {
  $estado_temp = "Temperatura Amena";
} else {
  $estado_temp = "Temperatura Quente";
}

//Condição para alterar o estado de alerta do sensor de incêndio
if ($valor_fogo == "Sensor Inativo") {
  $estado_fogo = "Inexistência de Incêndio";
} else {
  $estado_fogo = "Perigo!!!! FOGO!!!!";
}

//Condições para alterar o estado da porta
if(isset($_POST['Porta']) && $valor_door == "Aberta"){
  file_put_contents("api/files/porta/valor.txt", "Fechada");
}else if(isset($_POST['Porta']) && $valor_door == "Fechada"){
  file_put_contents("api/files/porta/valor.txt", "Aberta");
}


?>

<!DOCTYPE html>
<html lang="pt">

<head>
	<!--Inclusão do ficheiro css-->
  <link rel="stylesheet" href="style.css">
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <!--refresh automático na página-->
  <meta http-equiv="refresh" content="5" >
   <!-- Bootstrap CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Título da página-->
  <title>Smart Restaurant</title>
  <!--Bootstrap css-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<!--Definição de backgorund-->

<body style="background: url(imgs/fundo5.png);background-size:cover">
	<!--Barra de navegação do topo do site que contem o separador histórico,nome e logo que redireciona para a página de login-->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <ul class="navbar-nav ">
      <li class="form-group">
        <a href="index.php"><img id="minilogo" class="text-center pt-0 pb-0 mb-0 mt-0" src="imgs/logo.png" width="32" alt="RESTAURANTE logo"></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="dashboard1.php">Home</a>
      </li>
    </ul>
	<!--Botão de logout posicionado na parte direita da barra de navegação-->
	<form class="ml-auto" action="logout.php">
		<button id="logout" class="btn btn-outline-light float-right" type="submit">Logout <i class="fas fa-sign-out-alt"></i> </button>
	</form>
  <!--Banner com o nome do restaurante no topo da página-->
  </nav>
  <div style="background:#ffbd03" class="jumbotron cantosretos">
    <h1 style="text-align:center">Smart Restaurant</h1>
  </div>
   <!--Criação do container onde estão inseridos dados dos sensores (estado e hora de atualização) com as respetivas figuras-->
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
		  <!--Criacção de um elemento "card" com as informações da lotação-->
        <div class="card text-center">
          <div style="background:#ffbd03" class="card-header"><b>Lotação do Restaurante: <?php echo $valor_lot ?>/250</b></div>
          <div class="card-body"><img alt="logolotacao" src="imgs/lotacao.png" width="150"></div>
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_lot ?> </div>
        </div>
      </div>
      <div class="col-sm-4">
		  <!--Criacção de um elemento card com as informações da Temperatura-->
        <div class="card text-center">
          <div style="background:#ffbd03" class="card-header"><b>Temperatura: <?php echo $valor_temp ?></b></div>
          <div class="card-body"><img alt="logotemperatura" src="imgs/term2.png" width="150"></div>
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_temp ?></div>
        </div>
      </div>
      <div class="col-sm-4">
	    <!--Criacção de um elemento card com as informações da Porta-->
        <div class="card text-center">
          <div style="background:#ffbd03" class="card-header"><b>Porta: <?php echo $valor_door ?></b></div>
          <div class="card-body"><img alt="logoporta" src="imgs/porta.png" width="150"></div>
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_door ?> </div>
        </div>
      </div>
    </div>
    <br><br>
    <div class="row">
      <div class="col-sm-4">
        <div class="card text-center">
           <!--Criacção de um elemento card onde é apresentada a foto da webcam e as infromações de atualização-->
          <div style="background:#ffbd03" class="card-header"><b><?php echo $nome_webcam?></b></div>
          <div class="card-body"><?php
    echo "<img src='api/files/webcam/webcam.jpg?id=".time()."' style='width:65%'>"?></div>
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_webcam ?> </div>
        </div>
      </div>
      
      <!--Criacção de um elemento card com as informações do sensor de fogo-->
      <div class="col-sm-4">
        <div class="card text-center">
          <div style="background:#ffbd03" class="card-header"><b>Incêndio: <?php echo $valor_fogo?></b></div>
          <div class="card-body"><div class="container"><img alt="fogo" src="imgs/chama.png" width="150"></div></div>
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_fogo ?> </div>
        </div>
      </div>

      <!--Criacção de um elemento card com as informações da humidade-->
      <div class="col-sm-4">
        <div class="card text-center">
          <div style="background:#ffbd03" class="card-header"><b>Humidade: <?php echo $valor_humidade?></b></div>
          <div class="card-body"><div class="container"><img alt="humidade" src="imgs/humidade.png" width="150"></div></div>
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_humidade ?> </div>
        </div>
      </div>

    </div>
    <br>
	  <!--Criação da tabela com os valores dos sensores-->
  <br><br>
  <!--SCRIPTS-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>