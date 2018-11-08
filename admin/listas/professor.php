<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}
?>
<h1>Professores Cadastrados</h1>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<td>Id</td>
			<td>Foto</td>
			<td>Professor</td>
			<td>Opções</td>
		</tr>
	</thead>

	<?php
		//conectar no banco
		include "app/conecta.php";
		//selecionar todos os professores
		$sql = "select * from professor order by nome";
		$consulta = $pdo->prepare($sql);
		$consulta->execute();

		//listar todos os professores
		while ( $dados = $consulta->fetch(PDO::FETCH_OBJ))
		{
			//separar os dados
			$id = $dados->id;
			$nome = $dados->nome;
			$foto = $dados->foto;

			// foto = 7 -> ../fotos/7p.jpg
			$foto = "../fotos/".$foto."p.jpg";

			//formar uma linha da tabela
			echo "<tr>
					<td>$id</td>
					<td>
						<img src='$foto' width='80px'>
					</td>
					<td>$nome</td>
					<td>

						<a href=\"javascript:excluir($id,'$nome')\" class='btn btn-danger'>
							<i class='fa fa-trash'></i>
						</a>

						<a href='home.php?op=cadastro&pg=professor&id=$id' class='btn btn-success'>
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
			link = "home.php?pg=professor&op=excluir&id="+id;
			//chamar o link
			location.href = link;
		}
	}
</script>