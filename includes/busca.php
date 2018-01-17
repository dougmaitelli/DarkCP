<?
require 'conexao.php';

$busca = $_GET['busca'];
$tipo = $_GET['tipo'];

if ($busca != NULL) {
	if ($tipo == ("geral" or "noticias")) {
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_news";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0) {
				echo "<a href='?cat=show_news&news=" . $dados2['Id'] . "'>" . $dados2['Nome'] . "</a><br>";
			}
		}
	}
	if ($tipo == ("geral" or "projetos")) {
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_projetos";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0) {
				echo "<a href='?cat=show_projetos&prj=" . $dados2['Id'] . "'>" . $dados2['Nome'] . "</a><br>";
			}
		}
	}
	if ($tipo == ("geral" or "eventos")) {
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_eventos";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0) {
				echo "<a href='?cat=show_eventos&evento=" . $dados2['Id'] . "'>" . $dados2['Nome'] . "</a><br>";
			}
		}
	}
}
?>