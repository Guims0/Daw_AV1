<?php
$msg = "";
$idUsuario = "";
if (isset($_GET['id'])) { $idUsuario = $_GET['id']; }

if ($idUsuario != "") {
    $todasLinhas = array();
    $arq = fopen("usuarios.txt", "r");
    while (!feof($arq)) {
        $linha = fgets($arq);
        if ($linha === false || trim($linha) == "") break;
        $colunaDados = explode(";", $linha);
        if (trim($colunaDados[0]) != $idUsuario || trim($colunaDados[0]) == "id") {
            $todasLinhas[] = $linha;
        }
    }
    fclose($arq);

    $arq = fopen("usuarios.txt", "w");
    foreach ($todasLinhas as $l) {
        fwrite($arq, $l);
    }
    fclose($arq);

    $msg = "Usuário excluído com sucesso!";
}
?>
<!DOCTYPE html>
<html>
<head><title>Excluir Usuário</title></head>
<body>
<h1>Excluir Usuário</h1>
<p><?php echo $msg; ?></p>
<br><a href="listar_usuarios.php">Voltar para a lista de usuários</a>
</body>
</html>