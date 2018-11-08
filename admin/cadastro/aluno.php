<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	$id = $nome = $cpf = $foto = $datanascimento = $email = $celular = $ativo = "";
	//se foi enviado um id por GET - seleciona do banco
	if ( isset ( $_GET["id"] ) ) {

		//recuperar o id
		$id = trim ( $_GET["id"] );
		//selecionar o registro do banco
		include "app/conecta.php";
		include "app/validaDocs.php";

		//echo $sql = "select * from professor
		//	where id = ".(int)$id." limit 1";

		$sql = "select *, 
		date_format(datanascimento,'%d/%m/%Y') datanascimento from aluno
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
			$cpf = $dados->cpf;
			$foto = $dados->foto;
			$datanascimento = $dados->datanascimento;
			$email = $dados->email;
			$celular = $dados->celular;
			$ativo = $dados->ativo;
		}

	}

?>

<h1>Cadastro de Aluno</h1>

<form name="form1" method="post" action="home.php?op=salvar&pg=aluno" data-parsley-validate enctype="multipart/form-data">

	<label for="id">ID:</label>
	<input type="text" name="id" class="form-control" readonly
	value="<?php echo $id; ?>">
	<br>

	<label for="nome">Nome do Aluno</label>
	<input type="text" name="nome" class="form-control" required
	data-parsley-required-message="Preencha o nome completo do aluno"
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

	<label for="cpf">CPF:</label>
	<input type="text" name="cpf" class="form-control" required
	data-parsley-required-message="Preencha o cpf"
	value="<?=$cpf;?>" data-mask="999.999.999-99">
	<br>

	<label for="datanascimento">Data de Nascimento:</label>
	<input type="text" name="datanascimento" class="form-control" required
	data-parsley-required-message="Preencha a data de nascimento"
	value="<?=$datanascimento;?>" data-mask="99/99/9999">
	<br>

	<label for="email">E-mail:</label>
	<input type="email" name="email" class="form-control" required
	data-parsley-required-message="Preencha o e-mail"
	data-parsley-type-message="Preencha corretamente o e-mail"
	value="<?=$email;?>">
	<br>

	<label for="senha">Senha:</label>
	<input type="password" name="senha" class="form-control" 
	<?php if (empty($id)) echo "required"; ?>
	data-parsley-required-message="Por favor, digite uma senha">
	<br>

	<label for="celular">Celular:</label>
	<input type="text" name="celular" class="form-control" required value="<?=$celular;?>"
	data-parsley-required-message="Preencha o telefone" data-mask="(99) 9999-9999?9">
	<br>

	<label for="ativo">Ativo:</label>
	<select name="ativo" id="ativo" class="form-control" required
	data-parsley-required-message="Selecione se é ativo">
		<option value=""></option>
		<option value="Sim">Sim</option>
		<option value="Nao">Não</option>
	</select>
	<br>

	<script type="text/javascript">
		$("#ativo").val("<?=$ativo;?>");
	</script>

	<button type="submit" class="btn btn-success">
		Gravar/Alterar cadastro
	</button>
</form>