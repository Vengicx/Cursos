<h1>Usuários Cadastrados</h1>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nome</td>
			<td>E-mail</td>
			<td>Login</td>
			<td>Opções</td>
		</tr>
	</thead>

	<?php
		//conectar no banco
		include "app/conecta.php";
		//selecionar todos os professores
		$sql = "select * from usuario order by nome";
		$consulta = $pdo->prepare($sql);
		$consulta->execute();

		//listar todos os professores
		while ( $dados = $consulta->fetch(PDO::FETCH_OBJ))
		{
			//separar os dados
			$id = $dados->id;
			$nome = $dados->nome;
			$login = $dados->login;
			$email = $dados->email;

			//formar uma linha da tabela
			echo "<tr>
					<td>$id</td>
					<td>$nome</td>
					<td>$email</td>
					<td>$login</td>
					<td>

						<a href=\"javascript:excluir($id,'$nome')\" class='btn btn-danger'>
							<i class='fa fa-trash'></i>
						</a>

						<a href='home.php?op=cadastro&pg=usuario&id=$id' class='btn btn-success'>
							<i class='fa fa-pencil'></i>
						</a>

					</td>
				</tr>";
		}
	?>
	
</table>




<script type="text/javascript">
	//funcao para perguntar se deseja excluir
	function excluir(id,nome) {
		//pergunta e confirmar
		if ( confirm( "Deseja realmente excluir "+nome+" ? ") ) {
			//mandar excluir
			link = "home.php?pg=usuario&op=excluir&id="+id;
			//chamar o link
			location.href = link;
		}
	}
</script>