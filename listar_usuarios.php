<!DOCTYPE html>
<html>
<head><title>Listar Usuários</title></head>
<body>
<h1>Lista de Usuários</h1>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Ações</th>
    </tr>
    <?php
    if (file_exists("usuarios.txt")) {
        $arq = fopen("usuarios.txt", "r");
        fgets($arq); 
        while (!feof($arq)) {
            $linha = fgets($arq);
            if ($linha === false || trim($linha) == "") break;
            
            $dados = explode(";", $linha);
            $id = trim($dados[0]);
            echo "<tr>";
            echo "<td>" . $id . "</td>";
            echo "<td>" . trim($dados[1]) . "</td>";
            echo "<td>" . trim($dados[2]) . "</td>";
            echo "<td>
                    <a href='alterar_usuario.php?id=$id'>Alterar</a> | 
                    <a href='excluir_usuario.php?id=$id'>Excluir</a>
                  </td>";
            echo "</tr>";
        }
        fclose($arq);
    } else {
        echo "<tr><td colspan='4'>Nenhum usuário cadastrado.</td></tr>";
    }
    ?>
</table>
<br>
<a href="incluir_usuario.php">Incluir Novo Usuário</a> | <a href="index.html">Voltar para o Menu</a>
</body>
</html>