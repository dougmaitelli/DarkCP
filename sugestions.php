<?PHP
require 'conexao.php';

$s = $_GET['s'];
mysql_select_db($database_database, $database);
$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Nome LIKE '%" . $s . "%'";
$query = mysql_query($sql) or die(mysql_error());

$arr = array();

while ($dados = mysql_fetch_assoc($query)) {
	$arr[] = $dados["Nome"];
}

echo json_encode(array($s, $arr));
?>