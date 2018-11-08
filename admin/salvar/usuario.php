<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	//iniciar as variaveis deste cadastro
	$id = $nome = $login = $email = $ativo = $senha = "";

	if ( isset ( $_POST["id"] ) )
		$id = trim ( $_POST["id"] );
	//quando só tem 1 instrução não precisa de chaves { }
	if ( isset ( $_POST["nome"] ) )
		$nome = trim ( $_POST["nome"] );

	if ( isset ( $_POST["login"] ) )
		$login = trim ( $_POST["login"] );

	if ( isset ( $_POST["email"] ) )
		$email = trim ( $_POST["email"] );

	if ( isset ( $_POST["ativo"] ) )
		$ativo = trim ( $_POST["ativo"] );

	if ( isset ( $_POST["senha"] ) )
		$senha = trim ( $_POST["senha"] );

	//verificar se esta em branco
	if ( empty ( $nome ) ) {
		echo "<script>alert('Preencha o nome');history.back();</script>";
		exit;
	} else  if ( ( empty ( $login ) ) and ( empty($id) ) ) {
		echo "<script>alert('Preencha o login');history.back();</script>";
		exit;
	} else if ( ( empty ( $senha ) ) and ( empty($id) ) ) {
		echo "<script>alert('Preencha a senha');history.back();</script>";
		exit;
	} else if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		echo "<script>alert('Preencha o e-mail');history.back();</script>";
		exit;
	} else if ( empty ( $ativo ) ) {
		echo "<script>alert('Selecione se é ativo');history.back();</script>";
		exit;
	} else {

		//incluir o arquivo do banco
		include "app/conecta.php";

		//verificar se o id esta em branco - insert
		if ( empty ( $id ) ) {

			//criptografar a senha
			$senha = password_hash($senha, PASSWORD_DEFAULT);

			$sql = "insert into usuario 
			(id,nome,email,login,senha,ativo)
			values
			(NULL, ?, ?, ?, ?, ?)";
			$consulta = $pdo->prepare( $sql );
			//passar os parametros
			$consulta->bindParam(1, $nome);
			$consulta->bindParam(2, $email);
			$consulta->bindParam(3, $login);
			$consulta->bindParam(4, $senha);
			$consulta->bindParam(5, $ativo);
		} else {
			//update
			if ( empty($senha) ) {

				$sql = "update usuario 
					set nome = ?, 
					email = ?, 
					ativo = ? 
					where id = ?
					limit 1";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(1,$nome);
				$consulta->bindParam(2,$email);
				$consulta->bindParam(3,$ativo);
				$consulta->bindParam(4,$id);

			} else {

				//criptografar a senha
				$senha = password_hash($senha, PASSWORD_DEFAULT);

				$sql = "update usuario 
					set nome = ?, 
					email = ?, 
					ativo = ?,
					senha = ? 
					where id = ?
					limit 1";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(1,$nome);
				$consulta->bindParam(2,$email);
				$consulta->bindParam(3,$ativo);
				$consulta->bindParam(4,$senha);
				$consulta->bindParam(5,$id);

			}


		}

		//executar o sql
		if ( $consulta->execute() ) {
			echo "<script>alert('Registro salvo');location.href='home.php?op=listas&pg=usuario';</script>";
			exit;
		} else {
			echo "<script>alert('Erro ao salvar');history.back();</script>";
			exit;
		}

	}