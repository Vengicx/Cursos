<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	$labelId = $data = $ativo = $curso_id = $aluno = "";

	include "app/conecta.php";
	include "app/validaDocs.php";

	if(isset($_GET["id"])){

		$id = trim($_GET["id"]);

		$labelId = "required data-parsley-required-message=\"O ID não pode ser vazio quando está alterando a matrícula\"";

		$sql = "SELECT 
					m.id as matricula_id, 
					m.data as matricula_data,
					m.ativo as matricula_ativo,
					m.curso_id as matricula_curso,
					c.nome as curso_nome,
					c.id as curso_id,
					m.aluno_id as matricula_aluno,
					a.nome as aluno_nome
		from matricula m
		INNER JOIN curso c ON m.curso_id = c.id
		INNER JOIN aluno a ON m.aluno_id = a.id
		WHERE m.id = ?";

		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $id);
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_OBJ);
		
		$data = $dados->matricula_data;
		$data = formataDataBR($data);
		$ativo = $dados->matricula_ativo;
		$curso_id = $dados->curso_id;
		$aluno = $dados->aluno_nome;

	}
?>
<h1>Matrícula</h1>
<form name="form1" method="post" action="home.php?op=salvar&pg=matricula" data-parsley-validate>
<div class="row">
	<div class="col-12">
		<label for="id">ID:</label>
		<input type="number" name="id" value="<?=$id?>" <?=$labelId?> class="form-control" readonly>
	</div>
	<div class="col-6">
		<label for="data">
			Data da Matrícula:
		</label>
		<input type="text" name="data" class="form-control" data-mask="99/99/9999" value="<?=$data?>">
	</div>
	<div class="col-6">
		<label for="ativo">
			Matrícula Ativa:
		</label>
		<select name="ativo" id="ativo" class="form-control" required
		data-parsley-required-message="Selecione uma opção" id="ativo" value="<?=$ativo?>">
			<option value=""></option>
			<option value="S">Sim</option>
			<option value="N">Não</option>
		</select>
	</div>

	<div class="col-6">
		<label for="curso_id">
			Selecione o Curso:
		</label>
		<select name="curso_id" id="curso_id" class="form-control" required data-parsley-required-message="Selecione um curso" value="<?=$curso_id?>">
			<option value=""></option>
			<?php
				$consulta = $pdo->prepare("select id,nome,mensalidade from curso order by nome");
				$consulta->execute();
				while ( $d = $consulta->fetch(PDO::FETCH_OBJ)) {

					echo "<option value='$d->id'>$d->nome</option>";

				}
			?>
		</select>
	</div>

	<div class="col-6">
		<label for="aluno_id">Aluno:</label>
		<input type="hidden" name="aluno_id" id="aluno_id">
		<input type="text" id="aluno" class="form-control" required data-parsley-required-message="Selecione um aluno" value="<?=$aluno?>">
	</div>

</div>
<br>
<button type="submit" class="btn btn-success">
	Gravar/Atualizar
</button>
	
</form>

<script type="text/javascript">
	
	$("#ativo").val("<?=$ativo;?>");

	$("#curso_id").val("<?=$curso_id;?>");


    $(function () {
        $('#data').datetimepicker();
    });

    options = {
    	url: "app/cliente.php",
    	getValue: function( element ){
    		//nome do campo desejado do array
    		return element.nome;
    	},
    	list: {
	        onSelectItemEvent: function() {
            	var aluno = $("#aluno").getSelectedItemData().id;

            	$("#aluno_id").val(aluno).trigger("change");	
	    	},
        	match: {
	            enabled: true
	        },
        
    	}
    }
    $("#aluno").easyAutocomplete(options);
</script>