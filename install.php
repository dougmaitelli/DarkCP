<?
if ($_GET['step'] == NULL) {
?>
<form name="form1" method="post" action="install.php?step=install">
  <table width="271" border="0" align="center" cellspacing="0">
    <tr>
      <td colspan="2"><div align="center"><strong>Dados do Server:</strong></div></td>
    </tr>
    <tr>
      <td width="111"><strong>SQL Host </strong></td>
      <td width="156"><label>
        <input name="sql_host" type="text" id="sql_host" value="localhost">
      </label></td>
    </tr>
    <tr>
      <td><strong>SQL User </strong></td>
      <td><input name="sql_user" type="text" id="sql_user" value="root"></td>
    </tr>
    <tr>
      <td><strong>SQL Password</strong></td>
      <td><input name="sql_pass" type="text" id="sql_pass"></td>
    </tr>
    <tr>
      <td><strong>SQL Database </strong></td>
      <td><input name="sql_base" type="text" id="sql_base"></td>
    </tr>
    <tr>
      <td><strong>Table Prefix </strong></td>
      <td><input name="sql_prefix" type="text" id="sql_prefix" value="dark"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>Dados do Administrador:</strong></div></td>
    </tr>
    <tr>
      <td><strong>Usu&aacute;rio</strong></td>
      <td><input name="user" type="text" id="user"></td>
    </tr>
    <tr>
      <td><strong>Password</strong></td>
      <td><input name="pass" type="text" id="pass"></td>
    </tr>
    <tr>
      <td><strong>Confirm Pass.</strong> </td>
      <td><input name="confirm_pass" type="text" id="confirm_pass"></td>
    </tr>
    <tr>
      <td><strong>Nickname</strong></td>
      <td><input name="nick" type="text" id="nick"></td>
    </tr>
    <tr>
      <td><strong>Email</strong></td>
      <td><input name="email" type="text" id="email"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>Configura&ccedil;&otilde;es:</strong></div></td>
    </tr>
    <tr>
      <td><strong>Fuso Hor&aacute;rio</strong></td>
      <td><input name="fuso" type="text" id="fuso" value="-3" /></td>
    </tr>
    <tr>
      <td><strong>Local</strong></td>
      <td><input name="local" type="text" id="local" value="pt_BR" /></td>
    </tr>
    <tr>
      <td><label>
        <input type="submit" value="Instalar">
      </label></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?
} elseif ($_GET['step'] == "install") {

	$sql_host = $_POST['sql_host'];
	$sql_base = $_POST['sql_base'];
	$sql_user = $_POST['sql_user'];
	$sql_pass = $_POST['sql_pass'];
	$sql_prefix = $_POST['sql_prefix'];

	$nome = addslashes(trim($_POST['nick']));
	$user = addslashes(trim($_POST['user']));
	$password1 = trim($_POST['pass']);
	$repeat_password1 = trim($_POST['confirm_pass']);
	$password = md5($password1);
	$email = addslashes(trim($_POST['email']));
	
	$fuso = addslashes(trim($_POST['fuso']));
	$local = addslashes(trim($_POST['local']));
	
	if ($password1 != $repeat_password1) { die("As senhas de administrador não correspondem"); }
	
	$configs = "<?php
	\$hostname_database = '" . $sql_host . "';
	\$database_database = '" . $sql_base . "';
	\$username_database = '" . $sql_user . "';
	\$password_database = '" . $sql_pass . "';
	\$prefix_database = '" . $sql_prefix . "';
	\$database = mysql_pconnect(\$hostname_database, \$username_database, \$password_database) or trigger_error(mysql_error(),E_USER_ERROR); 
	?>";
	file_put_contents("conexao.php", $configs);

	require 'conexao.php';
	
	if (!mysql_select_db($database_database, $database)) {
		mysql_select_db("mysql", $database);
		mysql_query("CREATE DATABASE `$database_database`") or die(mysql_error());
		mysql_select_db($database_database, $database);
	}

	$sqllines = explode(";", file_get_contents("install.sql"));
	for ($i=0; ; $i++) {
		if ($i == sizeof($sqllines) - 1) {
			break;
		}
		$sql = str_replace("{prefix}", $prefix_database, $sqllines[$i]);
		$query = mysql_query($sql) or die(mysql_error());
	}
	$sql = "INSERT INTO " . $prefix_database . "_users (Id, Nome, Usuario, Password, Email, Autlvl, Foto, Ip) VALUES ('1', '$nome', '$user', '$password', '$email', '3', 'nenhum.gif', '0')";
	$query = mysql_query($sql) or die(mysql_error());

	$sql = "INSERT INTO " . $prefix_database . "_config (Id, Laynome, Fuso, Local) VALUES ('1', 'Dark', '$fuso', '$local')";
	$query = mysql_query($sql) or die(mysql_error());

	unlink("install.sql");
	unlink("install.php");

	echo "Dark CP Instalado com sucesso...";
}
?>