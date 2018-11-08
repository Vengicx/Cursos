<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	$id = $nome = $resumo = $descricao = $imagem = $video = 
	$mensalidade = $parcelas = $ativo = $professor_id = 
	$usuario_id = "";

	if ( isset ( $_POST["id"] ) )
		$id = trim ( $_POST["id"] ); 	

	if ( isset ( $_POST["nome"] ) ) 
		$nome = trim ( $_POST["nome"] ); 

	if ( isset ( $_POST["descricao"] ) ) 
		$descricao = trim ( $_POST["descricao"] );	

	if ( isset ( $_POST["resumo"] ) ) {
		$resumo = trim ( $_POST["resumo"] ); 	
	}
	if ( isset ( $_POST["mensalidade"] ) ) {
		$mensalidade = trim ( $_POST["mensalidade"] ); 	
	}
	if ( isset ( $_POST["video"] ) ) {
		$video = trim ( $_POST["video"] ); 	
	}
	if ( isset ( $_POST["parcelas"] ) ) {
		$parcelas = trim ( $_POST["parcelas"] ); 	
	}
	if ( isset ( $_POST["ativo"] ) ) {
		$ativo = trim ( $_POST["ativo"] ); 	
	}
	if ( isset ( $_POST["professor_id"] ) ) {
		$professor_id = trim ( $_POST["professor_id"] ); 	
	}

	$usuario_id = $_SESSION["sistema"]["id"];

	if ( empty ( $nome ) ) {
		echo "<script>alert('Preencha o nome');history.back();</script>";
		exit;
	} else {
		//conectar no banco de dados
		include "app/conecta.php";

		//iniciar a transacao
		$pdo->beginTransaction();

		//verificar se o id esta em branco - insert
		if ( empty ( $id ) ) {
			//fazer um insert
			$sql = "insert into curso (id,nome,resumo,descricao,video,mensalidade,parcelas,ativo,professor_id,usuario_id)
			values (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1, $nome);
			$consulta->bindParam(2, $resumo);
			$consulta->bindParam(3, $descricao);
			$consulta->bindParam(4, $video);
			$consulta->bindParam(5, $mensalidade);
			$consulta->bindParam(6, $parcelas);
			$consulta->bindParam(7, $ativo);
			$consulta->bindParam(8, $professor_id);
			$consulta->bindParam(9, $usuario_id);
		} else {
			//fazer um update
			$sql = "update curso set nome = ?, resumo = ?, descricao = ?, video = ?, mensalidade = ?, parcelas = ?, ativo = ?, professor_id = ?, usuario_id = ? where id = ? limit 1";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1, $nome);
			$consulta->bindParam(2, $resumo);
			$consulta->bindParam(3, $descricao);
			$consulta->bindParam(4, $video);
			$consulta->bindParam(5, $mensalidade);
			$consulta->bindParam(6, $parcelas);
			$consulta->bindParam(7, $ativo);
			$consulta->bindParam(8, $professor_id);
			$consulta->bindParam(9, $usuario_id);
			$consulta->bindParam(10, $id);

		}

		//verificar se os comandos são executado
		if ( $consulta->execute() ) {

			//verificar se existe imagem
			if ( !empty ( $_FILES["imagem"]["name"] ) ){
				//copiar o arquivo para a pasta ../fotos
				if ( copy ( $_FILES["imagem"]["tmp_name"], "../fotos/".$_FILES["imagem"]["name"] ) ) {					
					//mudar o tamanho e renomear
					if ( empty ( $id ) ) {
						$id = $pdo->lastInsertId();
					}
					
					//incluir o arquivo da imagem
					include "app/imagem.php";

					//chamar a função para alterar a imagem
					LoadImg("../fotos/".$_FILES["imagem"]["name"],
						$id,
						"../fotos/");

					//foto = nome da foto - id do registro
					$foto = $id;

					$sql = "update curso set imagem = ? where id = ? limit 1";
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

				$pdo->commit();
				echo "<script>alert('Registro salvo');location.href='home.php?op=listas&pg=curso';</script>";
			}
		}
	}