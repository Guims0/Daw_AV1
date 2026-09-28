<?php
   $msg = "";
   $idPergunta = "";
   if (isset($_GET['id'])) { $idPergunta = $_GET['id']; }
   if (isset($_POST['id'])) { $idPergunta = $_POST['id']; }

   $enunciadoAtual = "";
   $respostasAtuais = array("", "", "", "");
   $certaAtual = -1;

   if ($idPergunta != "" && $_SERVER['REQUEST_METHOD'] == 'GET') {
       $arqPergunta = fopen("perguntas.txt","r");
       while (!feof($arqPergunta)) {
           $linha = fgets($arqPergunta);
           if ($linha === false) break;
           $colunaDados = explode(";", $linha);
           if (trim($colunaDados[0]) == $idPergunta) {
               $enunciadoAtual = trim($colunaDados[2]);
           }
       }
       fclose($arqPergunta);

       $arqResposta = fopen("respostas.txt","r");
       $indice = 0;
       while (!feof($arqResposta)) {
           $linha = fgets($arqResposta);
           if ($linha === false) break;
           $colunaDados = explode(";", $linha);
           
           if (trim($colunaDados[1]) == $idPergunta) {
               $respostasAtuais[$indice] = trim($colunaDados[2]);
               if (trim($colunaDados[3]) == "1") {
                   $certaAtual = $indice;
               }
               $indice++;
           }
       }
       fclose($arqResposta);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $enunciado = str_replace(array(";","\r","\n")," ",trim($_POST["enunciado"]));
       $respostas = $_POST["resposta"];
       $certa = "";
       if (isset($_POST["certa"])) {
           $certa = $_POST["certa"];
       }

       $preenchido = true;
       for ($i = 0; $i < 4; $i++) {
           $respostas[$i] = str_replace(array(";","\r","\n")," ",trim($respostas[$i]));
           if ($respostas[$i] == "") {
               $preenchido = false;
           }
       }

       if ($enunciado == "" || !$preenchido || $certa === "") {
           $msg = "Preencha o enunciado, as 4 respostas e marque a resposta certa";
       } else {
           $todasLinhasPerguntas = array();
           $arqPergunta = fopen("perguntas.txt","r");
           while (!feof($arqPergunta)) {
               $linha = fgets($arqPergunta);
               if ($linha === false || trim($linha) == "") break;
               
               $colunaDados = explode(";", $linha);
               if (trim($colunaDados[0]) == $idPergunta) {
                   $todasLinhasPerguntas[] = $idPergunta . ";M;" . $enunciado . "\n";
               } else {
                   $todasLinhasPerguntas[] = $linha;
               }
           }
           fclose($arqPergunta);

           $arqPergunta = fopen("perguntas.txt","w");
           foreach ($todasLinhasPerguntas as $l) {
               fwrite($arqPergunta, $l);
           }
           fclose($arqPergunta);

           $todasLinhasRespostas = array();
           $arqResposta = fopen("respostas.txt","r");
           $indiceControle = 0;
           
           while (!feof($arqResposta)) {
               $linha = fgets($arqResposta);
               if ($linha === false || trim($linha) == "") break;
               
               $colunaDados = explode(";", $linha);
               if (trim($colunaDados[1]) == $idPergunta) {
                   $ehCerta = 0;
                   if ($certa == $indiceControle) {
                       $ehCerta = 1;
                   }
                   $idResp = trim($colunaDados[0]); 
                   $todasLinhasRespostas[] = $idResp . ";" . $idPergunta . ";" . $respostas[$indiceControle] . ";" . $ehCerta . "\n";
                   $indiceControle++;
               } else {
                   $todasLinhasRespostas[] = $linha;
               }
           }
           fclose($arqResposta);

           $arqResposta = fopen("respostas.txt","w");
           foreach ($todasLinhasRespostas as $l) {
               fwrite($arqResposta, $l);
           }
           fclose($arqResposta);

           $msg = "Pergunta alterada com sucesso";
           $enunciadoAtual = $enunciado;
           $respostasAtuais = $respostas;
           $certaAtual = $certa;
       }
   }
?>
<!DOCTYPE html>
<html>
<head><title>Alterar pergunta de multipla escolha</title></head>
<body>
<h1>Alterar pergunta de multipla escolha</h1>
<form action="alterar_pergunta_multipla.php" method="POST">
   <input type="hidden" name="id" value="<?php echo $idPergunta; ?>">
   Pergunta: <input type="text" name="enunciado" size="80" value="<?php echo $enunciadoAtual; ?>"><br><br>
   Respostas (marque a certa):<br><br>
   
   <input type="radio" name="certa" value="0" <?php if($certaAtual == 0) echo "checked"; ?>> A) 
   <input type="text" name="resposta[]" size="60" value="<?php echo $respostasAtuais[0]; ?>"><br>
   
   <input type="radio" name="certa" value="1" <?php if($certaAtual == 1) echo "checked"; ?>> B) 
   <input type="text" name="resposta[]" size="60" value="<?php echo $respostasAtuais[1]; ?>"><br>
   
   <input type="radio" name="certa" value="2" <?php if($certaAtual == 2) echo "checked"; ?>> C) 
   <input type="text" name="resposta[]" size="60" value="<?php echo $respostasAtuais[2]; ?>"><br>
   
   <input type="radio" name="certa" value="3" <?php if($certaAtual == 3) echo "checked"; ?>> D) 
   <input type="text" name="resposta[]" size="60" value="<?php echo $respostasAtuais[3]; ?>"><br><br>
   
   <input type="submit" value="Salvar Alterações">
</form>
<p><?php echo $msg ?></p>
<br><a href="index.html">Voltar</a>
</body>
</html>
