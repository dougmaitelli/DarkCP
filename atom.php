<?PHP
require 'conexao.php';

echo "<?xml version='1.0' encoding='ISO-8859-1' ?>
<feed xmlns='http://www.w3.org/2005/Atom'>

<title>Exemplo Home Page — News Feed</title>
<link href='http://www.exemplo.com' />
<updated>2006—01—05 3:05:47</updated>

<author>
<name>Nome do autor</name>
<email>email@exemplo.com</email>
<uri>http://www.exemplo.com/about—me</uri>
</author> 

<id>http://www.exemplo.com/</id>
<icon>http://www.exemplo.com/img/image.ico</icon>
<logo>http://www.exemplo.com/img/logo.jpg</logo>
<rights> © 2002—2006 Nome da Empresa/Site </rights>
<subtitle>Esteja atualizado com o que há de melhor na web</subtitle>
<category term='Informática' />";

mysql_select_db($database_database, $database);
$sql2 = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
$query2 = mysql_query($sql2) or die(mysql_error());
$dados2 = mysql_fetch_assoc($query2);

setlocale (LC_TIME, $dados2['Local']);
$stamp = strtotime($dados2['Fuso'] . " hours");
$dia = date(d, $stamp);
$ano = date(Y, $stamp);
$mes = date(m, $stamp);

$user = $_GET['user'];

if ($user != NULL) {

mysql_select_db($database_database, $database);
$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $user . "'";
$query = mysql_query($sql) or die(mysql_error());
$dados = mysql_fetch_assoc($query);

$anos = $ano - $dados['Ano'];
if ($mes < $dados['Mes']) {
	$anos = $ano - $dados['Ano'] - 1;
} elseif ($mes == $dados['Mes']) {
	if ($dia < $dados['Dia']) {
		$anos = $ano - $dados['Ano'] - 1;
	}
}

$acesso = strtotime($dados['Ativo']);

if (time() - $acesso >= 300) {
	$logado = "Offline";
} else {
	$logado = "Online";
}

switch ($dados['Autlvl']) {
	case 1:
		$lvl = "Usuário";
		break;
	case 2:
		$lvl = "Moderador";
		break;
	case 3:
		$lvl = "Admin";
		break;
}

echo "<entry>
		<title>" . $dados['Nome'] . " - " . $logado . "</title>
		<link>http://www.darkdomain.pandela.net</link>
		<id>http://www.exemplo.com/artigos.php?id=46/</id>
		<updated>" . $dia . "-" . $mes . "-" . $ano . " 00:00:00</updated>
		<summary>" . $anos . " Anos - Nas. " . $dados['Dia'] . "/" . $dados['Mes'] . "/" . $dados['Ano'] . " - " . $lvl . "</summary>
		<author>
<name>Nome do autor</name>
</author>
	</entry>";	
}

$sql = "SELECT * FROM " . $prefix_database . "_news";
$query = mysql_query($sql) or die(mysql_error());
$news = array();
while ($dados = mysql_fetch_assoc($query)) {
	$news[] = $dados['Id'];
}
$sql = "SELECT * FROM " . $prefix_database . "_news WHERE Id ='" . $news[sizeof($news)-1] . "'";
$query = mysql_query($sql) or die(mysql_error());
$dados2 = mysql_fetch_assoc($query);
$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $dados2['User'] . "'";
$query = mysql_query($sql) or die(mysql_error());
$user = mysql_fetch_assoc($query);

echo "<entry>
		<title>" . $dados2['Nome'] . " By " . $user['Nome'] . "</title>
		<link>http://darkdomain.pandela.net</link>
		<id>http://www.exemplo.com/artigos.php?id=46/</id>
		<updated>" . $dados2['Data'] . "</updated>
		<summary>" . $dados2['News'] . " By " . $user['Nome'] . "</summary>
		<author>
<name>Nome do autor</name>
</author>
	</entry>";

	$sql2 = "SELECT * FROM " . $prefix_database . "_eventos WHERE (Iniciod ='" . $dia . "' AND Iniciom ='" . $mes . "' AND (Inicioy ='" . $ano . "' OR Allyear ='1')) OR (Fimd ='" . $dia . "' AND Fimm ='" . $mes . "' AND (Fimy ='" . $ano . "' OR Allyear ='1'))";
	$query2 = mysql_query($sql2) or die(mysql_error());
	
	while ($dados2 = mysql_fetch_assoc($query2)) {
		echo "<entry>
				<title>" . $dados2['Nome'] . "</title>
				<link>http://www.darkdomain.pandela.net</link>
				<id>http://www.exemplo.com/artigos.php?id=46/</id>
				<updated>" . $dados2['Iniciod'] . "/" . $dados2['Iniciom'] . "/" . $dados2['Inicioy'] . " - " . $dados2['Fimd'] . "/" . $dados2['Fimm'] . "/" . $dados2['Fimy'] . "</updated>
				<summary>" . $dados2['Descricao'] . "</summary>
				<author>
<name>Nome do autor</name>
</author>
			</entry>";
	}

	$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Dia ='" . $dia . "' AND Mes ='" . $mes . "'";
	$query = mysql_query($sql) or die(mysql_error());
	$aniver = "";
	while ($dados = mysql_fetch_assoc($query)) {
		$aniver = $aniver . $dados['Nome'] . ", ";
	}
	
	echo "<entry>
			<title>Aniversários</title>
			<link>http://www.darkdomain.pandela.net</link>
			<id>http://www.exemplo.com/artigos.php?id=46/</id>
			<updated>" . $dia . "/" . $mes . "/" . $ano . "</updated>
			<summary>" . $aniver . "</summary>
			<guid>http://www.darkdomain.pandela.net</guid>
			<author>
<name>Nome do autor</name>
</author>
		</entry>"; 

echo "</feed>";
?> 