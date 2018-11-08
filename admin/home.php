<?php
	include "app/login.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>La Paloma System - Controle de Cursos</title>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-inputmask.min.js"></script>
	<script type="text/javascript" src="js/parsley.min.js"></script>
	<script type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

	<script type="text/javascript" src="js/moment-with-locales.min.js"></script>

	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" src="js/jquery.easy-autocomplete.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/easy-autocomplete.min.css">

	<!-- include summernote css/js -->
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="home.php">
	  	LaPaloma System
	  </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="menu">
    	<ul class="navbar-nav ml-auto">
    		<li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Cadastros
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="home.php?op=cadastro&pg=aluno">Aluno</a>

		          <a class="dropdown-item" href="home.php?op=cadastro&pg=professor">Professor</a>

		          <a class="dropdown-item" href="home.php?op=cadastro&pg=curso">Curso</a>

		          <a class="dropdown-item" href="home.php?op=cadastro&pg=usuario">Usuário</a>
		        </div>
		   	</li>

		   	<li class="nav-item">
		   		<a href="home.php?op=cadastro&pg=matricula" class="nav-link">Matrícula</a>
		   	</li>

		   	<li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Listar
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="home.php?op=listas&pg=professor">Professor</a>

		          <a class="dropdown-item" href="home.php?op=listas&pg=aluno">Aluno</a>

		          <a class="dropdown-item" href="home.php?op=listas&pg=curso">
		          Curso</a>

				  <a class="dropdown-item" href="home.php?op=listas&pg=usuario">Usuário</a>
				  <a class="dropdown-item" href="home.php?op=listas&pg=matricula">Matrícula</a>
		       	</div>
		    </li>

		   	<li class="nav-item">
		        <a class="nav-link" href="sair.php">	
		        	<i class="fa fa-power-off"></i> Sair
		        </a>
		    </li>
		</ul>
	  </div>
	</nav>

	<main class="container tela">
		<?php

			$op = $pg = "";
			//recuperar o op
			if ( isset ( $_GET["op"] ) ) {
				$op = trim ( $_GET["op"] );
			}
			if ( isset ( $_GET["pg"] ) ) {
				$pg = trim ( $_GET["pg"] );
			}

			//echo "Conteudo do op e do pg: $op $pg";

			if ( empty ( $pg ) ) {
				$pagina = "dashboard.php";
			} else {
				$pagina = $op."/".$pg.".php";
			}

			//verificar se o arquivo existe
			if ( file_exists( $pagina ) ) {
				include $pagina;
			} else {
				include "erro.php";
			}

		?>
	</main>

	<footer>
		<p>La Paloma System - Desenvolvido por Mateus Chinese Abbadde Tidinha Junior</p>
	</footer>



</body>
</html>
