<!DOCTYPE html>
<html>
<head>
	<title>Sistemas de Cursos Online</title>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript"
	src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/parsley.min.js"></script>
</head>
<body>
	<div id="login">
		<img src="imagens/logo.png">
		<form name="form1" method="post" action="verificar.php" data-parsley-validate>

			<label for="login">Login:</label>
			<input type="text" name="login" required class="form-control"
			data-parsley-required-message="Por favor preencha o Login"
			>
			<br>
			<label for="senha">Senha:</label>
			<input type="password" name="senha" required class="form-control"
			data-parsley-required-message="Por favor preencha a Senha">
			<br>
			<button type="submit" class="btn btn-success">Efetuar Login</button>

		</form>
	</div>
</body>
</html>