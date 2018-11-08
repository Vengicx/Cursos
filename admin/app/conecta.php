<?php
	//criar uma conexao com PDO
	$server = "127.0.0.1";
	$dbname = "aula20180322";
	$user = "root";
	$pwd = ""; 



	try {
		//codigo de conexao
		$pdo = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8",$user,$pwd);

	} catch (PDOException $erro) {
		//se não conseguir
		echo $erro->getMessage();
		exit;
	}


	//funcao para apagar fotos
	function apagarFotos($foto) {

		if ( file_exists( $foto ) ) {
			unlink($foto);
		}

	}