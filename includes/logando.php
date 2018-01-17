<?php require 'conexao.php' ?>
<?php
session_start();

$login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : FALSE;
$senha = isset($_POST['senha']) ? md5(trim($_POST['senha'])) : FALSE;

if (!$login || !$senha) {
	header ("Location: login.php?err=1");
	exit;
}

mysql_select_db($database_database, $database);
$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Usuario ='" . $login . "'";
$query = mysql_query($sql) or die(mysql_error());
$total = mysql_num_rows($query);

if ($total) {
	
	$dados = mysql_fetch_assoc($query);
	
	if (!strcmp($senha, $dados['Password'])) {
		$_SESSION['ID'] = $dados['Id'];
		$ip = (isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'unknown'); // pegando o endereço remoto ou definindo-o como desconhecido
		$forward = ( isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:false);  // pegando o endereço que foi repassado (se houver)
		$ip=( ($ip=='unknown' &&  $foward && $forward!='unknown' )?$forward:$ip); // verifica se existe um redirecionado e o retorna, caso contrário mantém o remoto.
		mysql_select_db($database_database, $database);
		$sql = "UPDATE " . $prefix_database . "_users SET Ip ='" . $ip . "' WHERE Usuario ='" . $login . "'";
		$query = mysql_query($sql) or die(mysql_error());
		header ("Location: admin.php");
		exit;
	} else {
		header ("Location: login.php?err=3");
		exit;
	}
} else {
	header ("Location: login.php?err=2");
}
?>