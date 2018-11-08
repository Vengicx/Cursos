<?php
	//verifica se existe a variavel $pagina
	//$pagina esta sendo configurada no home.php
	if ( !isset ( $pagina ) ) {
		echo "Acesso negado";
		exit;
	}

	include "app/conecta.php";
	include "app/validaDocs.php";

	$id = $aluno_id = $curso_id = $ativo = $data = "";

	//print_r ( $_POST );
	if ( isset ( $_POST["data"] ) ) {
		$data = trim ( $_POST["data"] );
		$data = formataData($data);

	}

	if ( isset ( $_POST["aluno_id"] ) )
		$aluno_id = trim ( $_POST["aluno_id"] );

	if ( isset ( $_POST["curso_id"] ) )
		$curso_id = trim ( $_POST["curso_id"] );

	if ( isset ( $_POST["ativo"] ) )
		$ativo = trim ( $_POST["ativo"] );

	if ( isset ( $_POST["id"] ) )
		$id = trim ( $_POST["id"] );

	if ( empty ( $data ) ) {
		echo "<script>alert('Preencha a data');history.back();</script>";
		exit;
	} else if ( empty ( $aluno_id ) ) {
		echo "<script>alert('Selecione um aluno');history.back();</script>";
		exit;
	} else {

		//iniciar uma transacao
		$pdo->beginTransaction();

		//verificar se ira inserir ou se atualizar
		if ( empty ( $id ) ) {
			//inserir uma matricula

			$sql = "insert into matricula 
				values (NULL, ?, ?, ?, ?)";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1,$data);
			$consulta->bindParam(2,$ativo);
			$consulta->bindParam(3,$curso_id);
			$consulta->bindParam(4,$aluno_id);

			if ( $consulta->execute() ) {
				//gravou matricula

				//recuperar o id da matricula
				$matricula = $pdo->lastInsertId();

				//mensalidade e parcelas do curso
				$sql = "select mensalidade,parcelas 
					from curso
					where id = ? limit 1";
				$consultacurso = $pdo->prepare($sql);
				$consultacurso->bindParam(1,$curso_id);
				$consultacurso->execute();

				$dados = $consultacurso->fetch(PDO::FETCH_OBJ);

				$mensalidade = $dados->mensalidade;
				$parcelas = $dados->parcelas;

				//echo "$mensalidade $parcelas";
				//valor total = mensalidade / parcelas
				$valor = $mensalidade / $parcelas;

				$dia = 0;

				for ($i=0; $i < $parcelas ; $i++) { 
					
					$dia = $dia + 30;

					$datavencimento = date("Y-m-d", strtotime("+$dia days",strtotime($data)));
					
					$sql = "insert into parcela (id, datalancamento, datavencimento, valor, ativo, matricula_id)
					values (NULL, NOW(), ?, ?, 'S', ?)";
					$consulta = $pdo->prepare($sql);
					$consulta->bindParam(1,$datavencimento);
					$consulta->bindParam(2,$valor);
					$consulta->bindParam(3,$matricula);

					//verifica se não executou !
					if ( !$consulta->execute() ) {
						echo "<script>alert('Erro ao gravar parcela');history.back();</script>";
						exit;
					}
				}
				//mensagem de ok e mandar gravar
				$pdo->commit();
				echo "<script>alert('Matrícula gerada!');location.href='home.php?pg=matricula&op=listas';</script>";
				exit;


			} else {
				//deu erro
				echo "<script>alert('Erro ao matricular');history.back();</script>";
				exit;
			}

		} else {
			$sql = "UPDATE matricula SET data = :data, ativo = :ativo, curso_id = :curso_id, aluno_id = :aluno_id WHERE id = :id";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(':data', $data);
			$consulta->bindParam(':ativo', $ativo);
			$consulta->bindParam(':curso_id', $curso_id);
			$consulta->bindParam(':aluno_id', $aluno_id);
			$consulta->bindParam(':id', $id);

			if($consulta->execute()){
				$pdo->commit();
				echo "<script>alert('Matrícula atualizada!');location.href='home.php?pg=matricula&op=listas';</script>";
				exit;
			}else{
				//deu erro
				echo "<script>alert('Erro ao atualizar matrícula');</script>";
				$pdo->rollBack();
				exit;

			}

		}

	}
