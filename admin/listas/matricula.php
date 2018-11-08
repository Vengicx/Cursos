<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
    }
    
    $nome = $id = "";
?>
<h1>Alunos Matriculados</h1>
<div class="tabela">
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nome do Aluno</td>
			<td>Data de Matrícula</td>
            <td>Nome do Curso</td>
            <td>Ativo</td>
            <td>Opções</td>
		</tr>
	</thead>
	<?php
	//incluir conexao com o banco
	include "app/conecta.php";
	//selecionar os dados
	$sql = "SELECT a.id as aluno_id, a.nome as aluno_nome, m.ativo as matricula_ativo, m.data as data_matricula, c.nome as nome_curso , m.id as matricula_id 
            FROM matricula m 
            INNER JOIN aluno a on aluno_id = a.id 
            INNER JOIN curso c on curso_id = c.id";
    
    $consulta = $pdo->prepare($sql);
	//executar o sql
	$consulta->execute();
	//separar as linhas
	while ( $dados = $consulta->fetch(PDO::FETCH_OBJ ) )
	{

        $id = $dados->matricula_id;
        $nome = $dados->aluno_nome;
        $ativo = $dados->matricula_ativo;

        if($ativo == "S"){
            $ativo = "Sim";

        }else{
            $ativo = "Não";

        }

		echo "<tr>
			<td>$id</td>
			<td>$nome</td>
			<td>$dados->data_matricula</td>
            <td>$dados->nome_curso</td>
            <td>$ativo</td>
            <td><a href=\"javascript:excluir($id,'$nome')\" class='btn btn-danger'>
                    <i class='fa fa-trash'></i>
                </a>
                <a href='home.php?op=cadastro&pg=matricula&id=$id' class='btn btn-success'>
                    <i class='fa fa-pencil'></i>
            </a></td>
		</tr>";
	}
?>
</table>
</div>

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