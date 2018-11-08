<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	//iniciar as variaveis deste cadastro
	$id = $nome = $login = $email = $ativo = "";

	//se foi enviado um id por GET - seleciona do banco
	if ( isset ( $_GET["id"] ) ) {
		//incluir o arquivo do banco
		include "app/conecta.php";

		//recuperar o id
		$id = trim ( $_GET["id"] );
		//selecionar os dados do banco
		$sql = "select * from usuario
			where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		//passar a variavel id
		$consulta->bindParam(1, $id);
		//executar o sql
		$consulta->execute();
		//recuperar os resultados
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		$id = $dados->id;
		$nome = $dados->nome;
		$login = $dados->login;
		$email = $dados->email;
		$ativo = $dados->ativo;

	}
?>

<h1>Cadastro de Usuário</h1>

<form name="form1" method="post" action="home.php?op=salvar&pg=usuario" data-parsley-validate>

	<label for="id">ID:</label>
	<input type="text" name="id" class="form-control"
	readonly value="<?=$id;?>">
	<br>

	<label for="nome">Nome do Usuário:</label>
	<input type="text" name="nome" class="form-control"
	required data-parsley-required-message="Por favor, preencha o nome do usuário" value="<?=$nome;?>">
	<br>

	<label for="login">Login:</label>
	<input type="text" name="login" class="form-control" id="validalogin"
	required data-parsley-required-message="Por favor, preencha o login" value="<?=$login;?>"
	maxlength="14" onblur="verificaLogin(this.value)"
	<?php if (!empty($login)) echo "disabled"; ?>
	>
	<br>

	<label for="senha">Senha:</label>
	<input type="password" name="senha" class="form-control" 
	<?php if (empty($login)) echo "required"; ?>
	data-parsley-required-message="Por favor, digite uma senha">
	<br>

	<label for="email">E-mail:</label>
	<input type="email" name="email" class="form-control" required 
	data-parsley-required-message="Por favor, digite um e-mail" 
	data-parsley-type-message="Digite um e-mail válido"
	value="<?=$email;?>">
	<br>

	<label for="ativo">Ativo:</label>
	<select name="ativo" id="ativo" class="form-control"
	required data-parsley-required-message="Selecione uma opção">
		<option value=""></option>
		<option value="Sim">Sim</option>
		<option value="Nao">Não</option>
	</select>
	<br>

	<button type="submit" class="btn btn-success">
		Gravar/Alterar cadastro
	</button>

</form>

<script type="text/javascript">
	//funcao para verificar se o login existe
	function verificaLogin(login) {
		$.get("app/validaLogin.php",
			{
				login:login
			},
			function(data){
				if ( data != "" ) {
					//mostrar o retorno da execução do arquivo
					alert(data);
					//limpar o campo login
					$("#validalogin").val('');
					//focar no campo
					$("#validalogin").focus();
				}
			});
	}

	//verifica se o corpo já foi carregado
	$(document).ready(function(){
		//selecionar a opcao SIM ou NAO do ativo
		$("#ativo").val('<?=$ativo;?>');
	})
</script>