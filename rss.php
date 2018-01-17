<?PHP
require 'conexao.php';

$sql = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
$query = mysql_query($sql) or die(mysql_error());
$config = mysql_fetch_assoc($query);

setlocale (LC_TIME, $config['Local']);
$stamp = strtotime($config['Fuso'] . " hours");
$dia = date(d, $stamp);
$ano = date(Y, $stamp);
$mes = date(m, $stamp);

echo "<?xml version='1.0' encoding='ISO-8859-1' ?>
		<rss version='2.00'>
			<channel>
				<title>Dark Domain</title>
				<link>http://darkdomain.pandela.net</link>
				<description>Informações sobre usuário</description>
				<category></category>
				<image>
					<link>softarquiv.blogspot.com</link>
					<url>http://www.feedburner.com/fb/images/pub/fb_pwrd.gif</url>
					<title>SoftArquivo</title>
				</image>
				<language>pt-br</language>
				<copyright>Copyright: Copyright© Dark Domain X7</copyright>
				<managingEditor>noreply@blogger.com (Jeff)</managingEditor>
				<lastBuildDate>Tue, 01 Sep 2009 18:03:13 PDT</lastBuildDate>
				<generator>Blogger http://www.blogger.com</generator>
				<webMaster></webMaster>
				<pubDate></pubDate>";

$user = $_GET['user'];

if ($user != NULL) {

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
	
	echo "<item>
			<title>" . $dados['Nome'] . " - " . $logado . "</title>
			<description>" . $anos . " Anos - Nas. " . $dados['Dia'] . "/" . $dados['Mes'] . "/" . $dados['Ano'] . " - " . $lvl . "</description>
			<category>User Info</category>
			<link>http://www.darkdomain.pandela.net</link>
			<pubDate>" . $dia . "/" . $mes . "/" . $ano . "</pubDate>
			<guid>http://www.darkdomain.pandela.net</guid>
			<author>noreply@blogger.com (Jeff)</author>
			<comments>http://ekzemplo.com/entry/4403/comments</comments>
		</item>";	
}

$sql = "SELECT * FROM " . $prefix_database . "_news";
$query = mysql_query($sql) or die(mysql_error());

while ($dados = mysql_fetch_assoc($query)) {
	
	$sql2 = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $dados['User'] . "'";
	$query2 = mysql_query($sql2) or die(mysql_error());
	$user = mysql_fetch_assoc($query2);

	echo "<item>
			<title>" . $dados['Nome'] . "</title>
			<description>" . $dados['News'] . "</description>
			<category>" . $dados['Categoria'] . "</category>
			<link>http://darkdomain.pandela.net</link>
			<pubDate>" . $dados['Data'] . "</pubDate>
			<guid>http://darkdomain.pandela.net</guid>
			<author>" . $user['Email'] . " (" . $user['Nome'] . ")</author>
	</item>";
}

$sql = "SELECT * FROM " . $prefix_database . "_eventos WHERE (Iniciod ='" . $dia . "' AND Iniciom ='" . $mes . "' AND (Inicioy ='" . $ano . "' OR Allyear ='1')) OR (Fimd ='" . $dia . "' AND Fimm ='" . $mes . "' AND (Fimy ='" . $ano . "' OR Allyear ='1'))";
$query = mysql_query($sql) or die(mysql_error());
	
while ($dados = mysql_fetch_assoc($query)) {
	echo "<item>
			<title>" . $dados['Nome'] . "</title>
			<description>" . $dados['Descricao'] . "</description>
			<category>Eventos</category>
			<link>http://www.darkdomain.pandela.net</link>
			<pubDate>" . $dados['Iniciod'] . "/" . $dados['Iniciom'] . "/" . $dados['Inicioy'] . " - " . $dados['Fimd'] . "/" . $dados2['Fimm'] . "/" . $dados['Fimy'] . "</pubDate>
			<guid>http://www.darkdomain.pandela.net</guid>
			<author>noreply@blogger.com (Jeff)</author>
		</item>";
}

$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Dia ='" . $dia . "' AND Mes ='" . $mes . "'";
$query = mysql_query($sql) or die(mysql_error());
$aniver = "";

if (mysql_num_rows($query) > 0) {

	while ($dados = mysql_fetch_assoc($query)) {
		$aniver = $aniver . $dados['Nome'] . ", ";
	}
		
	echo "<item>
			<title>Aniversários</title>
			<description>" . $aniver . "</description>
			<category>Aniversários</category>
			<link>http://www.darkdomain.pandela.net</link>
			<pubDate>" . $dia . "/" . $mes . "/" . $ano . "</pubDate>
			<guid>http://www.darkdomain.pandela.net</guid>
			<author>noreply@blogger.com (Jeff)</author>
		</item>";
}

echo "</channel>
	</rss>";
?>