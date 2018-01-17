<?
mysql_select_db($database_database, $database);
$evento = addslashes(trim($_GET['evento']));
$dia = addslashes(trim($_GET['dia']));
$mes = addslashes(trim($_GET['mes']));
$ano = addslashes(trim($_GET['ano']));
if ($_GET['evento'] == NULL) {
if ($_GET['dia'] == NULL) {
	$sql2 = "SELECT * FROM " . $prefix_database . "_eventos";
} else {
	$sql2 = "SELECT * FROM " . $prefix_database . "_eventos WHERE (Iniciod ='" . $dia . "' AND Iniciom ='" . $mes . "' AND (Inicioy ='" . $ano . "' OR Allyear ='1') OR (Fimd ='" . $dia . "' AND Fimm ='" . $mes . "' AND (Fimy ='" . $ano . "' OR Allyear ='1')";
}
} else {
	$sql2 = "SELECT * FROM " . $prefix_database . "_eventos WHERE Id ='" . $evento . "'";
}
$query2 = mysql_query($sql2) or die(mysql_error());
while ($dados2 = mysql_fetch_assoc($query2)) {
	echo $dados2['Nome'] . "<br>" . "- " . $dados2['Descricao'] . "<BR><BR>";
}
?>