<?php
   $msg = "";

   if (!file_exists("usuarios.txt")) {
       $arqUsuario = fopen("usuarios.txt","w") or die("erro ao criar arquivo");
       $linha = "id;nome;email\n";
       fwrite($arqUsuario, $linha);
       fclose($arqUsuario);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $nome = str_replace(array(";","\r","\n")," ",trim($_POST["nome"]));
       $email = str_replace(array(";","\r","\n")," ",trim($_POST["email"]));

       if ($nome == "" || $email == "") {
           $msg = "Preencha o nome e o e-mail!";
       } else {
           $idUsuario = 1;
           $arqUsuario = fopen("usuarios.txt","r") or die("erro ao abrir arquivo");
           $linha = fgets($arqUsuario); 
           while (!feof($arqUsuario)) {
               $linha = fgets($arqUsuario);
               if ($linha === false) break;
               $colunaDados = explode(";", $linha);
               if (trim($colunaDados[0]) >= $idUsuario) {
                   $idUsuario = trim($colunaDados[0]) + 1;
               }
           }
           fclose($arqUsuario);

           $arqUsuario = fopen("usuarios.txt","a") or die("erro ao criar arquivo");
           $linha = $idUsuario . ";" . $nome . ";" . $email . "\n";
           fwrite($arqUsuario, $linha);
           fclose($arqUsuario);

           $msg = "Usuário incluído com sucesso!";
       }
   }
?>
<!DOCTYPE html>
<html>
<head><title>Incluir Usuário</title></head>
<body>
<h1>Incluir Usuário</h1>
<form action="incluir_usuario.php" method="POST">
   Nome: <input type="text" name="nome" size="50"><br><br>
   E-mail: <input type="text" name="email" size="50"><br><br>
   <input type="submit" value="Incluir Usuário">
</form>
<p><?php echo $msg ?></p>
<br><a href="listar_usuarios.php">Listar Usuários</a> | <a href="index.html">Voltar para o Menu</a>
</body>
</html>