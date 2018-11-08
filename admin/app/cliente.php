<?php
	session_start();
	if ( !isset ( $_SESSION["sistema"]["id"]) ) {
		exit;
	}
	include "conecta.php";
	//selecionar os clientes
	$sql = "select id, nome, cpf from aluno order by nome";
	$consulta = $pdo->prepare( $sql );
	$consulta->execute();
	//iniciar o array
	$cliente[] = array("id"=>"","nome"=>"");

	while ( $dados = $consulta->fetch(PDO::FETCH_OBJ)){

		$cliente[] = array("id"=>$dados->id,
						"nome"=>"$dados->nome - CPF: $dados->cpf" );

	}
	//transformando array em json
	echo json_encode($cliente);
