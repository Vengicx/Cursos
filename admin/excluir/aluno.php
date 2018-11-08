<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	//recuperar o id
	$id = "";
	if ( isset ( $_GET["id"] ) ) {
		$id = trim ( $_GET["id"] );
	}

	//verificar se o id esta em branco ou se é inválido
	$id = (int)$id;
	if ($id == 0) {
		//mensagem de erro
		echo "<script>alert('Requisição inválida');history.back();</script>";
		//alert - mostra uma mensagem na tela
		//history.back() - volta a tela anterior
		exit;
	}

	//incluir o conecta.php
	include "app/conecta.php";

	//verificar se o aluno ligado a matricula
	$sql = "select * from matricula 
		where aluno_id = ?
		limit 1";
	$consulta = $pdo->prepare($sql);
	//passar o id como paramentro
	$consulta->bindParam(1,$id);
	//executar
	$consulta->execute();
	//recuperar os dados se existem
	$dados = $consulta->fetch(PDO::FETCH_OBJ);
	//verifica se existe uma matricula com este aluno cadastrado
	if ( !empty( $dados->id ) ) {
		echo "<script>alert('Este aluno não pode ser excluído pois existe uma matricula ligada a ele');history.back();</script>";
		exit;
	}

	//excluir o registro
	$sql = "delete from aluno 
		where id = ?
		limit 1";
	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(1,$id);
	//verificar se excluiu mesmo
	if ( $consulta->execute() ) {
		//excluir as fotos
		//24 ->24p.jpg
		$fotop = "../fotos/".$id."p.jpg";
		apagarFotos($fotop);

		$fotom = "../fotos/".$id."m.jpg";
		apagarFotos($fotom);

		$fotog = "../fotos/".$id."g.jpg";
		apagarFotos($fotog);

		//se deu certo
		echo "<script>alert('Registro excluído');history.back();</script>";
		exit;
	} else {
		//se não deu erro
		echo "<script>alert('Erro ao excluir registro');history.back();</script>";
		exit;
	}