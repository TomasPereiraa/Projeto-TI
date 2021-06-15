<!--Histórico-->
<!--Verificação se foi iniciada a sessão, se nao indica que o acesso é restrito-->
<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("refresh:5;url=index.php");
  die("Acesso restrito.");
}
//Criação da variável para cada um dos atributos sobra o valor, hora, nome
$valor_lot = file_get_contents("api/files/lotacao/valor.txt");
$hora_lot = file_get_contents("api/files/lotacao/hora.txt");
$nome_lot = file_get_contents("api/files/lotacao/nome.txt");

$valor_temp = file_get_contents("api/files/temperatura/valor.txt");
$hora_temp = file_get_contents("api/files/temperatura/hora.txt");
$nome_temp = file_get_contents("api/files/temperatura/nome.txt");

$valor_door = file_get_contents("api/files/porta/valor.txt");
$hora_door = file_get_contents("api/files/porta/hora.txt");
$nome_door = file_get_contents("api/files/porta/nome.txt");

$valor_humidade=file_get_contents("api/files/humidade/valor.txt");
$hora_humidade=file_get_contents("api/files/humidade/hora.txt");
$nome_humidade=file_get_contents("api/files/humidade/nome.txt");

$valor_fogo=file_get_contents("api/files/incendio/valor.txt");
$hora_fogo=file_get_contents("api/files/incendio/hora.txt");
$nome_fogo=file_get_contents("api/files/incendio/nome.txt");

$doorlog = file_get_contents("api/files/porta/log.txt");
$lotacaolog = file_get_contents("api/files/lotacao/log.txt");
$temperaturalog = file_get_contents("api/files/temperatura/log.txt");
$fogolog = file_get_contents("api/files/incendio/log.txt");
$humidadelog = file_get_contents("api/files/humidade/log.txt");

//com o explode cria um array para cada valor do ficheiro log, separando por um \n, (futuramente irá fazer o mesmo com o ";")
$doorlog = explode("\n", $doorlog);
$lotacaolog = explode("\n", $lotacaolog);
$temperaturalog = explode("\n", $temperaturalog);
$fogolog = explode("\n", $fogolog);
$humidadelog = explode("\n", $humidadelog);

//elimina o ultimo elemento do vetor
array_pop($doorlog);
array_pop($lotacaolog);
array_pop($temperaturalog);
array_pop($fogolog);
array_pop($humidadelog);

?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  <!--Titulo da Página-->
  <title>Smart Restaurant</title>
</head>
<!--Definição de um backgrond-->

<body style="background: url(imgs/fundo1.png);background-size:cover">

  <!--barra em cima do site  a preto com 4 botoes onde o simbolo leva para o log in, o home, o historico e o log out-->
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
    
    <form class="ml-auto" action="logout.php">
      <button id="logout" class="btn btn-outline-light float-right" type="submit">Logout <i class="fas fa-sign-out-alt"></i> </button>
    </form>
    
  </nav>
  <div style="background:#ffbd03" class="jumbotron cantosretos">
    <h1 style="text-align:center">Histórico</h1>
  </div>
  <!--criação de um container onde será colocado 3 tabelas onde mostra os dados no ficheiro log-->
  <div class="container">
  <!--zona onde vai apresentar o historico sobre a temperatura em formato de tabela-->
    <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-color:black">
          <div class="card-body">
            <table class="table table-bordered" style="margin-left:auto;margin-right:auto">
              <thead>
                <tr style="background:#ffbd03">
                  <th scope="col" style="width:450px"><?php echo $nome_lot ?></th>
				  <th scope="col" style="width:450px; border-right-color:white;border-top-color:white;background:white"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center"><u>Dados</u></td>
                  <td style="text-align:center"><u>Data de Atualização</u></td>
                </tr>
                  <!--foreach cria uma tabela que cresce confrome o tamanho do vetor existente no log.txt-->
                  <?php
                  foreach ($lotacaolog as $a) {
                    //este explode vai buscar o vetor criado e vai separa-los por ";" para poder indicar o valor tempo e lotacao 
                    $a = explode(';', $a);
                    echo '<tr>
                                    <td  style="text-align:center">' . $a[1] . '</td>
                                    <td  style="text-align:center">' . $a[0] . '</td>
                          </tr>';
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--separação entre as tabelas-->
    <br>
    <br>
    <!--zona onde vai apresentar o historico sobre a temperatura-->
    <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-color:black">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr style="background:#ffbd03">
                  <th scope="col" style="width:450px"><b><?php echo $nome_temp ?></b></th>
				  <th scope="col" style="width:450px; border-right-color:white;border-top-color:white;background:white"></th>
                </tr>
              </thead>
              <tbody>
                <tr style="background:#FFFFFF">
                  <td style="text-align:center"><u>Lotação</u></td>
                  <td style="text-align:center"><u>Data de Atualização</u></td>
                </tr>
                  <!--foreach cria uma tabela que cresce confrome o tamanho do vetor existente no log.txt-->
                  <?php
                  foreach ($temperaturalog as $b) {
                    //este explode vai buscar o vetor criado e vai separa-los por ";" para poder indicar o valor tempo e temperatura
                    $b = explode(';', $b);
                    echo '<tr>
                                    <td  style="text-align:center">' . $b[1] . 'ºC</td>
                                    <td  style="text-align:center">' . $b[0] . '</td>
                          </tr>';
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!--separação entre as tabelas-->
    <br>
    <br>
  <!--zona onde vai apresentar o historico sobre o estado da tabela em formato de tabela-->
    <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-color:black">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr style="background:#ffbd03">
                  <th scope="col" style="width:450px"><b>Porta</b></th>
				  <th scope="col" style="width:450px; border-right-color:white;border-top-color:white;background:white"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center"><u>Estado Da Porta</u></td>
                  <td style="text-align:center"><u>Data de Atualização</u></td>
                </tr>
                  <!--foreach cria uma tabela que cresce confrome o tamanho do vetor existente no log.txt-->
                  <?php
                  foreach ($doorlog as $c) {
                    //este explode vai buscar o vetor criado e vai separa-los por ";" para poder indicar o valor tempo e estado da porta 
                    $c = explode(';', $c);
                    echo '<tr>
                                    <td  style="text-align:center">' . $c[1] . '</td>
                                    <td  style="text-align:center">' . $c[0] . '</td>
                          </tr>';
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!--separação entre as tabelas-->
  <br><br>
  <div class="container">
  <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-color:black">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr style="background:#ffbd03">
                  <th scope="col" style="width:450px"><b>Estado de Incêndio</b></th>
				  <th scope="col" style="width:450px; border-right-color:white;border-top-color:white;background:white"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center"><u>Estados</u></td>
                  <td style="text-align:center"><u>Data de Atualização</u></td>
                </tr>
                  <!--foreach cria uma tabela que cresce confrome o tamanho do vetor existente no log.txt-->
                  <?php
                  foreach ($fogolog as $d) {
                    //este explode vai buscar o vetor criado e vai separa-los por ";" para poder indicar o tempo e estado incendio 
                    $d = explode(';', $d);
                    echo '<tr>
                                    <td  style="text-align:center">' . $d[1] . '</td>
                                    <td  style="text-align:center">' . $d[0] . '</td>
                          </tr>';
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br><br>
  <div class="container">
  <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border-color:black">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr style="background:#ffbd03">
                  <th scope="col" style="width:450px"><b>Humidade</b></th>
				  <th scope="col" style="width:450px; border-right-color:white;border-top-color:white;background:white"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center"><u>Valor da Humidade</u></td>
                  <td style="text-align:center"><u>Data de Atualização</u></td>
                </tr>
                  <!--foreach cria uma tabela que cresce confrome o tamanho do vetor existente no log.txt-->
                  <?php
                  foreach ($humidadelog as $e) {
                    //este explode vai buscar o vetor criado e vai separa-los por ";" para poder indicar o valor humidade e tempo
                    $e = explode(';', $e);
                    echo '<tr>
                                    <td  style="text-align:center">' . $e[1] . '</td>
                                    <td  style="text-align:center">' . $e[0] . '</td>
                          </tr>';
                  }
                  ?>
                  
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<br><br>
</body>
</html>