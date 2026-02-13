<?php
// Abre ou cria o arquivo bloco1.txt
// "a" representa que o arquivo é aberto para ser escrito
$fp = fopen("config.inc.php", "a");

// Escreve "exemplo de escrita" no bloco1.txt
$escreve = fwrite($fp, "Conta Não paga!");

// Fecha o arquivo
fclose($abre);
?>