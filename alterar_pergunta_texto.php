<?php
   $msg = "";
   $idPergunta = "";
   if (isset($_GET['id'])) { $idPergunta = $_GET['id']; }
   if (isset($_POST['id'])) { $idPergunta = $_POST['id']; }

   $enunciadoAtual = "";
   $respostaAtual = "";

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
       while (!feof($arqResposta)) {
           $linha = fgets($arqResposta);
           if ($linha === false) break;
           $colunaDados = explode(";", $linha);
           if (trim($colunaDados[1]) == $idPergunta) {
               $respostaAtual = trim($colunaDados[2]);
           }
       }
       fclose($arqResposta);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $enunciado = str_replace(array(";","\r","\n")," ",trim($_POST["enunciado"]));
       $resposta = str_replace(array(";","\r","\n")," ",trim($_POST["resposta"]));

       if ($enunciado == "" || $resposta == "") {
           $msg = "Preencha a pergunta e a resposta";
       } else {
           $todasLinhasPerguntas = array();
           $arqPergunta = fopen("perguntas.txt","r");
           while (!feof($arqPergunta)) {
               $linha = fgets($arqPergunta);
               if ($linha === false || trim($linha) == "") break;
               
               $colunaDados = explode(";", $linha);
               if (trim($colunaDados[0]) == $idPergunta) {
                   $todasLinhasPerguntas[] = $idPergunta . ";T;" . $enunciado . "\n";
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
           while (!feof($arqResposta)) {
               $linha = fgets($arqResposta);
               if ($linha === false || trim($linha) == "") break;
               
               $colunaDados = explode(";", $linha);
               if (trim($colunaDados[1]) == $idPergunta) {
                   $idResp = trim($colunaDados[0]);
                   $todasLinhasRespostas[] = $idResp . ";" . $idPergunta . ";" . $resposta . ";1\n";
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
           $respostaAtual = $resposta;
       }
   }
?>
<!DOCTYPE html>
<html>
<head><title>Alterar pergunta de texto</title></head>
<body>
<h1>Alterar pergunta de texto</h1>
<form action="alterar_pergunta_texto.php" method="POST">
   <input type="hidden" name="id" value="<?php echo $idPergunta; ?>">
   Pergunta: <input type="text" name="enunciado" size="80" value="<?php echo $enunciadoAtual; ?>"><br><br>
   Resposta esperada: <input type="text" name="resposta" size="80" value="<?php echo $respostaAtual; ?>"><br><br>
   <input type="submit" value="Salvar Alterações">
</form>
<p><?php echo $msg ?></p>
<br><a href="index.html">Voltar</a>
</body>
</html>
