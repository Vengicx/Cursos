<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}
?>
<h1>Cursos Cadastrados</h1>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nome do Curso</td>
			<td>Professor</td>
			<td>Opções</td>
		</tr>
	</thead>
	<?php
	//incluir conexao com o banco
	include "app/conecta.php";
	//selecionar os dados
	$sql = "select c.id, 
		c.nome curso, 
		p.nome professor 
		from curso c
		inner join professor p on ( p.id = c.professor_id )
		order by c.nome";
	$consulta = $pdo->prepare($sql);
	//executar o sql
	$consulta->execute();
	//separar as linhas
	while ( $dados = $consulta->fetch(PDO::FETCH_OBJ ) )
	{

		echo "<tr>
			<td>$dados->id</td>
			<td>$dados->curso</td>
			<td>$dados->professor</td>
			<td>

			</td>
		</tr>";
	}
?>
</table>

<script type="text/javascript">
	//executar apos carregar o documento toto
	$(document).ready(function(){

		//adicionar dataTable na tabela
		 $('.table').dataTable( {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            }
        } );


	});
</script>