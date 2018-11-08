<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	$id = $nome = $cargo = $foto = $curriculo = "";
	//se foi enviado um id por GET - seleciona do banco
	if ( isset ( $_GET["id"] ) ) {

		//recuperar o id
		$id = trim ( $_GET["id"] );
		//selecionar o registro do banco
		include "app/conecta.php";

		//echo $sql = "select * from professor
		//	where id = ".(int)$id." limit 1";

		$sql = "select * from professor
			where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		//passando um parametro - ?
		$consulta->bindParam(1, $id);
		//executar o sql
		$consulta->execute();

		//recuperar os registros do sql
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		//verificar se existe o registro
		if ( isset ( $dados->id ) ) {
			$id = $dados->id;
			$nome = $dados->nome;
			$cargo = $dados->cargo;
			$foto = $dados->foto;
			$curriculo = $dados->curriculo;
		}

	}

?>

<h1>Cadastro de Professor</h1>

<form name="form1" method="post" action="home.php?op=salvar&pg=professor" data-parsley-validate enctype="multipart/form-data">

	<label for="id">ID:</label>
	<input type="text" name="id" class="form-control" readonly
	value="<?php echo $id; ?>">
	<br>

	<label for="nome">Nome do Professor</label>
	<input type="text" name="nome" class="form-control" required
	data-parsley-required-message="Preencha o nome completo do professor"
	value="<?=$nome;?>">
	<br>

	<?php
		$r = " required
	data-parsley-required-message=\"Por favor, seleciona uma imagem JPG\" ";

		if ( !empty($foto) ) $r = "";

	?>

	<label for="foto">Selecione uma Foto</label>
	<input type="file" name="foto" class="form-control" <?=$r;?> >
	<br>
	<?php
	//verificar se existe foto - mostrar a foto na tela
	if ( !empty ( $foto ) ) {
		$fotop = "../fotos/".$foto."p.jpg";
		echo "<img src='$fotop' class='img-thumbnail' width='100px'>";
	}
	?>
	<br>

	<label for="cargo">Cargo:</label>
	<input type="text" name="cargo" class="form-control" required
	data-parsley-required-message="Preencha o cargo"
	value="<?=$cargo;?>">
	<br>

	<label for="curriculo">Currículo do Professor:</label>
	<textarea name="curriculo" class="form-control" required data-parsley-required-message="Preencha o currículo" rows="10"><?=$curriculo;?></textarea>

	<button type="submit" class="btn btn-success">
		Gravar/Alterar cadastro
	</button>
</form>