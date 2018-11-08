<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	//adicionar vazio as variaveis
	$id = $nome = $cpf = $foto = $datanascimento = $email = $celular = $ativo = "";

	if ( isset ( $_POST["id"] ) ) {
		$id = trim ( $_POST["id"] ); 	
	}
	if ( isset ( $_POST["nome"] ) ) {
		$nome = trim ( $_POST["nome"] ); 	
	}
	if ( isset ( $_POST["cpf"] ) ) {
		$cpf = trim ( $_POST["cpf"] ); 	
	}
	if ( isset ( $_POST["datanascimento"] ) ) {
		$datanascimento = trim ( $_POST["datanascimento"] ); 	
	}
	if ( isset ( $_POST["email"] ) ) {
		$email = trim ( $_POST["email"] ); 	
	}
	if ( isset ( $_POST["celular"] ) ) {
		$celular = trim ( $_POST["celular"] ); 	
	}
	if ( isset ( $_POST["ativo"] ) ) {
		$ativo = trim ( $_POST["ativo"] ); 	
	}
	if ( isset ( $_POST["senha"] ) ) {
		$senha = trim ( $_POST["senha"] ); 	
	}

	//validação de documentos / cpf - cnpj
	include "app/validaDocs.php"; 

	
	//retorna mensagem para CPF inválido ou 1 (true) para válido
	$msg = validaCPF($cpf);

	//verificar se os campos estão branco
	if ( empty ( $nome ) ) {
		echo "<script>alert('Preencha o nome');history.back();</script>";
		exit;
	} else if ( empty ( $cpf ) ) {
		echo "<script>alert('Preencha o CPF');history.back();</script>";
		exit;
	} else if ( empty ( $datanascimento ) ) {
		echo "<script>alert('Preencha a data de nascimento');history.back();</script>";
		exit;
	} else if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		echo "<script>alert('Preencha o e-mail');history.back();</script>";
		exit;
	} else if ( $msg != 1 ) {

		echo "<script>alert('$msg');history.back();</script>";
		exit;

	} else {

		//salvar os dados - insert ou update
		include "app/conecta.php"; //conecta no banco
		

		//iniciar a transacao
		$pdo->beginTransaction();

		//formatar a data para o formato do banco
		$datanascimento = formataData($datanascimento);

		//criptografar a senha, se ela foi digitada
		if ( !empty ( $senha ) ) 
			$senha = password_hash($senha, PASSWORD_DEFAULT);

		//se o id estiver vazio - INSERT
		if ( empty ($id) ) {

			//criar um sql para insert
			$sql = "insert into aluno 
				(id,nome,cpf,datanascimento,email,senha,celular,ativo)
				values
				(NULL, ?, ?, ?, ?, ?, ?, ?)";
			//utilizar o pdo para peparar o sql
			$consulta = $pdo->prepare($sql);
			//passar os 3 parametros: nome, cargo e curriculo
			$consulta->bindParam(1, $nome);
			$consulta->bindParam(2, $cpf);
			$consulta->bindParam(3, $datanascimento);
			$consulta->bindParam(4, $email);
			$consulta->bindParam(5, $senha);
			$consulta->bindParam(6, $celular);
			$consulta->bindParam(7, $ativo);
		} else {

			
			if ( empty ( $senha ) ) {
				//se a senha estiver em branco, não modificá-la

				//criar um update
				$sql = "update aluno set
					nome = ?,
					cpf = ?,
					datanascimento = ?,
					email = ?,
					celular = ?,
					ativo = ?
					where id = ? 
					limit 1";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(1, $nome);
				$consulta->bindParam(2, $cpf);
				$consulta->bindParam(3, $datanascimento);
				$consulta->bindParam(4, $email);
				$consulta->bindParam(5, $celular);
				$consulta->bindParam(6, $ativo);
				$consulta->bindParam(7, $id);


			} else {
				//se a senha não estiver em branco, mudar

				//criar um update
				$sql = "update aluno set
					nome = ?,
					cpf = ?,
					datanascimento = ?,
					email = ?,
					senha = ?,
					celular = ?,
					ativo = ?
					where id = ? 
					limit 1";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(1, $nome);
				$consulta->bindParam(2, $cpf);
				$consulta->bindParam(3, $datanascimento);
				$consulta->bindParam(4, $email);
				$consulta->bindParam(5, $senha);
				$consulta->bindParam(6, $celular);
				$consulta->bindParam(7, $ativo);
				$consulta->bindParam(8, $id);
			}
		}

		//verificar se os comandos são executado
		if ( $consulta->execute() ) {

			//verificar se existe imagem
			if ( !empty ( $_FILES["foto"]["name"] ) ){
				//copiar o arquivo para a pasta ../fotos
				if ( copy ( $_FILES["foto"]["tmp_name"], "../fotos/".$_FILES["foto"]["name"] ) ) {					
					//mudar o tamanho e renomear
					if ( empty ( $id ) ) {
						$id = $pdo->lastInsertId();
					}
					
					//incluir o arquivo da imagem
					include "app/imagem.php";

					//chamar a função para alterar a imagem
					LoadImg("../fotos/".$_FILES["foto"]["name"],
						$id,
						"../fotos/");

					//foto = nome da foto - id do registro
					$foto = $id;

					$sql = "update aluno set foto = ? where id = ? limit 1";
					$consulta = $pdo->prepare($sql);
					$consulta->bindParam(1,$foto);
					$consulta->bindParam(2,$id);
					//executar
					$consulta->execute();

				} else {
					$pdo->rollBack();
					//se der erro - mensagem de erro
					echo "<script>alert('Erro ao copiar arquivo');history.back();</script>";
					//sair da programação
					exit;
				}


			}
			$pdo->commit();
			echo "<script>alert('Registro salvo');location.href='home.php?op=listas&pg=aluno';</script>";



			//$pdo->commit();

		} else {
			//recuperar erro - array
			$erro = $consulta->errorInfo()[2];
			// 0 - codigo 2 - mensagem de erro [2]
			echo $erro;

			echo "<script>alert('Não foi possível salvar');</script>";
			//rollBack - voltar a transacao
			$pdo->rollBack();
			exit;

		}


	}


