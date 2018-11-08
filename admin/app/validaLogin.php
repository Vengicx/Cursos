<?php
	//iniciar a sessao
	session_start();
	//validar a sessao
	if ( !isset( $_SESSION["sistema"]["id"] ) ) {

		echo "Usuário não logado";
		exit;

	} else {

		//incluir o arquivo do banco de dados
		include "conecta.php";

		//recuperar o login
		if ( isset ( $_GET["login"] ) ) {

			$login = trim($_GET["login"]);
			//buscar no banco de dados
			$sql = "select id from usuario 
				where login = ? limit 1";
			$consulta = $pdo->prepare($sql);
			//passar o paramentro login
			$consulta->bindParam(1,$login);
			//executar o sql
			$consulta->execute();
			//recuperar os resultados
			$dados = $consulta->fetch(PDO::FETCH_OBJ);

			//verificar se existe
			if ( isset($dados->id)) {
				echo "O Login $login já está cadastrado no sistema";
			}

		} else {
			//mensagem de erro
			echo "Login inválido";
		}
	}