<?php
   $msg = "";
   $idUsuario = "";
   if (isset($_GET['id'])) { $idUsuario = $_GET['id']; }
   if (isset($_POST['id'])) { $idUsuario = $_POST['id']; }

   $nomeAtual = "";
   $emailAtual = "";

   if ($idUsuario != "" && $_SERVER['REQUEST_METHOD'] == 'GET') {
       $arq = fopen("usuarios.txt","r");
       while (!feof($arq)) {
           $linha = fgets($arq);
           if ($linha === false) break;
           $colunaDados = explode(";", $linha);
           if (trim($colunaDados[0]) == $idUsuario) {
               $nomeAtual = trim($colunaDados[1]);
               $emailAtual = trim($colunaDados[2]);
           }
       }
       fclose($arq);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $nome = str_replace(array(";","\r","\n")," ",trim($_POST["nome"]));
       $email = str_replace(array(";","\r","\n")," ",trim($_POST["email"]));

       if ($nome == "" || $email == "") {
           $msg = "Preencha o nome e o e-mail";
       } else {
           $todasLinhas = array();
           $arq = fopen("usuarios.txt","r");
           while (!feof($arq)) {
               $linha = fgets($arq);
               if ($linha === false || trim($linha) == "") break;
               
               $colunaDados = explode(";", $linha);
               if (trim($colunaDados[0]) == $idUsuario) {
                   $todasLinhas[] = $idUsuario . ";" . $nome . ";" . $email . "\n";
               } else {
                   $todasLinhas[] = $linha;
               }
           }
           fclose($arq);

           $arq = fopen("usuarios.txt","w");
           foreach ($todasLinhas as $l) {
               fwrite($arq, $l);
           }
           fclose($arq);

           $msg = "Usuário alterado com sucesso!";
           $nomeAtual = $nome;
           $emailAtual = $email;
       }
   }
?>
<!DOCTYPE html>
<html>
<head><title>Alterar Usuário</title></head>
<body>
<h1>Alterar Usuário</h1>
<form action="alterar_usuario.php" method="POST">
   <input type="hidden" name="id" value="<?php echo $idUsuario; ?>">
   Nome: <input type="text" name="nome" size="50" value="<?php echo $nomeAtual; ?>"><br><br>
   E-mail: <input type="text" name="email" size="50" value="<?php echo $emailAtual; ?>"><br><br>
   <input type="submit" value="Salvar Alterações">
</form>
<p><?php echo $msg ?></p>
<br><a href="listar_usuarios.php">Voltar para a lista</a>
</body>
</html>