<?
	require 'conexao.php';
	
	global $dados;
	global $user;
	
	$lay = load_layout();
	
	$page = trim($_GET['page']);
	$perpage = 5;
	if ($page == NULL) {
		$page = 1;
	}

	mysql_select_db($database_database, $database);
	$sql = "SELECT * FROM " . $prefix_database . "_news ORDER BY Id DESC LIMIT " . ($page-1) * $perpage . "," . $page * $perpage;
	$query = mysql_query($sql) or die(mysql_error());
	while ($dados = mysql_fetch_assoc($query)) {
		$sqluser = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $dados['User'] . "'";
		$queryuser = mysql_query($sqluser) or die(mysql_error());
		$user = mysql_fetch_assoc($queryuser);
		include("layouts/" . $lay['Laynome'] . "/news.layout.php");
	}
	
	mysql_select_db($database_database, $database);
	$sqlpag = "SELECT * FROM " . $prefix_database . "_news";
	$querypag = mysql_query($sql) or die(mysql_error());
	$paginas = mysql_num_rows($querypag);
	
	$paginas2 = $paginas /  $perpage;
	for ($i = 1; ; $i++) {
		if ($i >= $paginas2) {
			break;
		}
		echo "<a href='index.php?cat=news&page=" . $i . "'>" . $i . "</a>&nbsp;";
	}
	
	function load_layout() {

		require 'conexao.php';
	
		mysql_select_db($database_database, $database);
		$sqllay = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
		$querylay = mysql_query($sqllay) or die(mysql_error());
		$lay = mysql_fetch_assoc($querylay);
	
		return $lay;
	}
	
	function load_img($img) {

		$lay = load_layout();

		echo "layouts/" . $lay['Laynome'] . "/imgs/" . $img;
	}
	
	function Show_Titulo() {
		global $dados;
		echo $dados2['Nome'];
	}
	
	function Show_News() {
		global $dados;
		echo $dados2['News'];
	}
	
	function Show_Data() {
		global $dados;
		echo $dados2['Data'];
	}
	
	function Show_Nome() {
		global $user;
		echo $user['Nome'];
	}
	
	function Show_Foto() {
		global $user;
		echo "<img src='avatars/" . $user['Foto'] . "' />";
	}
?>