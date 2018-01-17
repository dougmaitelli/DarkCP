<?php
function Manutencao() {
	require 'conexao.php';
	
	mysql_select_db($database_database, $database);
	$sql = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
	$query = mysql_query($sql) or die(mysql_error());
	$dados = mysql_fetch_assoc($query);
	
	if ($dados['Manutencao'] == 1) {
		die(include("includes/login.php"));
	} else {
		return FALSE;
	}
}
?>