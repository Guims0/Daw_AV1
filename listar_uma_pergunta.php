<?php
$idPergunta = "";
if (isset($_GET['id'])) { $idPergunta = $_GET['id']; }

$enunciado = "";
$tipo = "";
$respostas = array();

if ($idPergunta != "") {
    $arqPergunta = fopen("perguntas.txt","r");
    while (!feof($arqPergunta)) {
        $linha = fgets($arqPergunta);
        if ($linha === false || trim($linha) == "") break;
        $colunaDados = explode(";", $linha);
        if (trim($colunaDados[0]) == $idPergunta) {
            $tipo = trim($colunaDados[1]);
            $enunciado = trim($colunaDados[2]);
        }
    }
    fclose($arqPergunta);

    $arqResposta = fopen("respostas.txt","r");
    while (!feof($arqResposta)) {
        $linha = fgets($arqResposta);
        if ($linha === false || trim($linha) == "") break;
        $colunaDados = explode(";", $linha);
        if (trim($colunaDados[1]) == $idPergunta) {
            $respostas[] = array(
                "texto" => trim($colunaDados[2]),
                "certa" => trim($colunaDados[3])
            );
        }
    }
    fclose($arqResposta);
}
?>
<!DOCTYPE html>
<html>
<head><title>Visualizar Pergunta</title></head>
<body>
<h1>Detalhes da Pergunta</h1>
<?php if ($enunciado != ""): ?>
    <p><strong>ID:</strong> <?php echo $idPergunta; ?></p>
    <p><strong>Tipo:</strong> <?php echo $tipo == 'M' ? 'Múltipla Escolha' : 'Texto'; ?></p>
    <p><strong>Enunciado:</strong> <?php echo $enunciado; ?></p>
    
    <h3>Respostas:</h3>
    <ul>
        <?php foreach ($respostas as $resp): ?>
            <li>
                <?php echo $resp['texto']; ?> 
                <?php if ($resp['certa'] == '1') echo "<strong>(Resposta Correta)</strong>"; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Pergunta não encontrada.</p>
<?php endif; ?>
<br><a href="listar_perguntas.php">Voltar para a lista</a>
</body>
</html>