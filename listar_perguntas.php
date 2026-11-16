<!DOCTYPE html>
<html>
<head><title>Listar Perguntas</title></head>
<body>
<h1>Lista de Perguntas</h1>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Enunciado</th>
        <th>Ações</th>
    </tr>
    <?php
    if (file_exists("perguntas.txt")) {
        $arqPergunta = fopen("perguntas.txt", "r");
        $cabecalho = fgets($arqPergunta); 
        while (!feof($arqPergunta)) {
            $linha = fgets($arqPergunta);
            if ($linha === false || trim($linha) == "") break;
            
            $colunaDados = explode(";", $linha);
            $id = trim($colunaDados[0]);
            $tipo = trim($colunaDados[1]) == 'M' ? "Múltipla Escolha" : "Texto";
            $enunciado = trim($colunaDados[2]);
            
            $linkAlterar = trim($colunaDados[1]) == 'M' ? "alterar_pergunta_multipla.php?id=$id" : "alterar_pergunta_texto.php?id=$id";
            
            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$tipo</td>";
            echo "<td>$enunciado</td>";
            echo "<td>
                    <a href='listar_uma_pergunta.php?id=$id'>Ver</a> | 
                    <a href='$linkAlterar'>Alterar</a> | 
                    <a href='excluir_pergunta.php?id=$id'>Excluir</a>
                  </td>";
            echo "</tr>";
        }
        fclose($arqPergunta);
    } else {
        echo "<tr><td colspan='4'>Nenhuma pergunta cadastrada.</td></tr>";
    }
    ?>
</table>

<br><a href="index.html">Voltar</a>
</body>
</html>