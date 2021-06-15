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

//Função que permite tirar de foto na dashboard através de um botão
if (isset($_POST['button'])){
   exec('python\webcam.py');
   header("url=dashboard.php");
    header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
    exit();
 
}


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
  $estado_temp = "Frio";
} else if ($valor_temp >= 17 && $valor_temp <= 25) {
  $estado_temp = "Ameno";
} else {
  $estado_temp = "Calor";
}

if ($valor_fogo == "Sensor Inativo") {
  $estado_fogo = "Inexistência de Incêndio";
} else {
  $estado_fogo = "Perigo!!!! FOGO!!!!";
}

//Condição que altera o estado da humidade consoante o seu valor
if ($valor_humidade >= 0 && $valor_humidade < 100){
  $estado_humidade = "Ambiente sem Humidade";
} else if ($valor_humidade <= 255 && $valor_humidade > 200){
  $estado_humidade = "Ambiente muito Humido";
}else {
  $estado_humidade = "Ambiente com Humidade Normal";
}

//Condições para mudar o valor da porta na dashboar
if(isset($_POST['Porta']) && $valor_door == "Aberta"){
  file_put_contents("api/files/porta/valor.txt", "Fechada");
  header("url=dashboard.php");
  header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
  exit();

}else if(isset($_POST['Porta']) && $valor_door == "Fechada"){
  file_put_contents("api/files/porta/valor.txt", "Aberta");
  header("url=dashboard.php");
  header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
  exit();
}


$valor_door = file_get_contents("api/files/porta/valor.txt");

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
        <a class="nav-link" href="dashboard.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="historico.php">Histórico</a>
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
          <div style="background:#ffbd03" class="card-footer">Atualização: <?php echo $hora_fogo ?></div>
        </div>
      </div>

      <!--Criacção de um elemento card com as informações da Humidade-->
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
    <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-style: solid; border-color: white">
          <div style="background:#ffbd03" class="card-header"><b>Informação</b></div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Tipo de Dispositivo IoT</th>
                  <th scope="col">Dados</th>
                  <th scope="col">Data de Atualização</th>
                  <th scope="col">Estado Alertas</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $nome_lot ?></td>
                  <td><?php echo $valor_lot ?></td>
                  <td><?php echo $hora_lot ?></td>
                  <td><span class="badge badge-pill badge-Dark"><?php echo $estado_lot ?></span></td>
                </tr>
                <tr>
                  <td><?php echo $nome_temp ?></td>
                  <td><?php echo $valor_temp ?></td>
                  <td><?php echo $hora_temp ?></td>
                  <td><span class="badge badge-pill badge-Dark"><?php echo $estado_temp?></span></td>
                </tr>
                <tr>
                  <td><?php echo $nome_door ?></td>
                  <td><?php echo $valor_door ?></td>
                  <td><?php echo $hora_door ?></td>
                  <td><span class="badge badge-pill badge-Dark">Inexistência de estado de alerta</span></td>
                </tr>
                <tr>
                  <td><?php echo $nome_fogo ?></td>
                  <td><?php echo $valor_fogo ?></td>
                  <td><?php echo $hora_fogo ?></td>
                  <td><span class="badge badge-pill badge-Dark"><?php echo $estado_fogo ?></span></td>
                </tr>
                <tr>
                  <td><?php echo $nome_humidade ?></td>
                  <td><?php echo $valor_humidade?></td>
                  <td><?php echo $hora_humidade ?></td>
                  <td><span class="badge badge-pill badge-Dark">Inexistência de estado de alerta</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br><br>

  	  <!--Criação da tabela com os valores dos sensores-->
      <form method="POST">
      <div class="container">
      <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-style: solid; border-color: white">
          <div style="background:#ffbd03" class="card-header"><b>Botões</b></div>
          <div class="card-body">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td >Estado da Porta
                  <?php
                //Botão que permite mudar o valor da porta (Abri\Fechar)
						if($valor_door == "Aberta"){
							echo '<button type="input" type="submit" name="Porta" class="btn btn-outline-danger btn-dark text-light float-right">Fechar</button>';	
						}else if($valor_door == "Fechada"){
							echo '<button type="input" type="submit" name="Porta" class="btn btn-outline-success btn-dark text-light float-right">Abrir</button>';
						}
						?>
                </tr>
                </tr>
                <tr>
                  <!--Botão para tirar foto com a Webcam-->
                  <td><form method="post"> <?php echo $nome_webcam?><button name=button  class="btn btn-dark text-light float-right"  style="margin:5px;">Tirar foto</button></form></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br><br>
  <!--SCRIPTS-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>