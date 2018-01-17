<?
	require 'conexao.php';

	mysql_select_db($database_database, $database);
	$sql = "SELECT * FROM " . $prefix_database . "_parcerias";
	$query = mysql_query($sql) or die(mysql_errand());
	$parcs = array();
	while ($dados = mysql_fetch_assoc($query)) {
		$parcs[] = $dados['Id'];
	}
	if (sizeof($parcs) < 7) {
		$max = sizeof($parcs);
	} else {
		$max = 7;
	}
	if	(sizeof($parcs) > 0) {
		$sorte = array(array_rand($parcs, $max));
	} else {
		$sorte = $parcs;
	}
	foreach ($sorte as $i) {
		$sql = "SELECT * FROM " . $prefix_database . "_parcerias WHERE Id ='" . $parcs[$i] . "'";
		$query = mysql_query($sql) or die(mysql_errand());
		$dados = mysql_fetch_assoc($query);
		echo "<a href='" . $dados['Link'] . "'><img src='" . $dados['Banner'] . "' alt='" . $dados['Nome'] . "' border='0' /></a><BR>";
	}
?>