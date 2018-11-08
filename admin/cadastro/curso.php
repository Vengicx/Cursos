<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	$id = $nome = $resumo = $descricao = $imagem = $video = $mensalidade = $parcelas = $ativo = $professor_id = $usuario_id = "";

	//incluir o arquivo do banco de dados
	include "app/conecta.php";

	//editar os dados

?>

<h1>Cadastro de Curso</h1>

<form name="form1" method="post" action="home.php?op=salvar&pg=curso" data-parsley-validate enctype="multipart/form-data">

	<label for="id">ID:</label>
	<input type="text" name="id" class="form-control" readonly
	value="<?php echo $id; ?>">
	<br>

	<label for="nome">Nome do Curso:</label>
	<input type="text" name="nome" class="form-control" 
	value="<?php echo $nome; ?>" required data-parsley-required-message="Digite o nome do curso">
	<br>

	<label for="resumo">Resumo do Curso:</label>
	<input type="text" name="resumo" class="form-control" 
	value="<?php echo $resumo; ?>" required data-parsley-required-message="Digite o resumo do curso">
	<br>

	<label for="descricao">Descrição do Curso:</label>
	<textarea name="descricao" id="descricao" 
	class="form-control" 
	required data-parsley-required-message="Digite a descrição do curso" rows="5"><?php echo $descricao; ?></textarea>
	<br>

	<?php
		//tornar o campo imagem requerido
		$r = " required
	data-parsley-required-message=\"Por favor, seleciona uma imagem JPG\" ";


		if ( !empty($imagem) ) $r = "";

	?>

	<label for="imagem">Selecione uma Foto</label>
	<input type="file" name="imagem" class="form-control" <?=$r;?> >
	<br>
	<?php
	//verificar se existe foto - mostrar a foto na tela
	if ( !empty ( $imagem ) ) {
		$fotop = "../fotos/".$imagem."p.jpg";
		echo "<img src='$fotop' class='img-thumbnail' width='100px'>";
	}
	?>
	<br>

	<label for="video">Vídeo do Youtube:</label>
	<input type="text" name="video" 
	class="form-control" value="<?php echo $descricao; ?>">
	<br>

	<label for="mensalidade">Valor da Mensalidade:</label>
	<input type="text" name="mensalidade" class="form-control" id="mensalidade"
	value="<?php echo $mensalidade; ?>" required data-parsley-required-message="Digite a mensalidade do curso">
	<br>

	<label for="parcelas">Número de Parcelas:</label>
	<input type="text" name="parcelas" 
	class="form-control" 
	value="<?php echo $parcelas; ?>" required data-parsley-required-message="Digite a quantidade de parcelas" data-mask="9?9">
	<br>

	<label for="ativo">Ativo?</label>
	<select name="ativo" id="ativo" class="form-control" required data-parsley-required-message="Selecione uma opção">
		<option value=""></option>
		<option value="Sim">Sim</option>
		<option value="Nao">Não</option>
	</select>
	<br>

	<label for="professor_id">Professor:</label>
	<select name="professor_id" id="professor_id"
	class="form-control" required data-parsley-required-message="Selecione um professor">
		<option value=""></option>
		<?php
			//mostrar os professores cadastrados
			$sql = "select * from professor order by nome";
			$consultap = $pdo->prepare($sql);
			$consultap->execute();
			//mostrar os professores dentro de uma opção do select
			while ( $dadosp = $consultap->fetch(PDO::FETCH_OBJ) ) {

				$idp = $dadosp->id;
				$nomep = $dadosp->nome;

				//montar a opcao
				echo "<option value='$idp'>$nomep</option>";
			}
		?>
	</select>

	<br>
	<label for="usuario">Usuário:</label>
	<input type="text" readonly class="form-control" value="<?php echo $_SESSION["sistema"]["nome"];?>">

	<br>
	<button type="submit" class="btn btn-success">
		Salvar Dados
	</button>


<script type="text/javascript">
	//adicionar o summernote ao #descricao
	$(document).ready(function(){
		//aplicar o summernote ao id
		$("#descricao").summernote({
			height: 200
		});

		//adicionar a mascara ao campo
		$("#mensalidade").maskMoney({
			thousands:'.', 
			decimal:','
		});
	})
</script>	