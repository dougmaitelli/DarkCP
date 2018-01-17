<?php require 'conexao.php' ?>
<?php

$nome = addslashes(trim($_POST['nome']));
$user = addslashes(trim($_POST['usuario']));
$password1 = trim($_POST['pass']);
$repeat_password1 = trim($_POST['rpass']);
$password = md5($password1);
$email = addslashes(trim($_POST['email']));

if ($password1 and $repeat_password1 and $nome and $email and $user != "") {

if ($password1 == $repeat_password1) {

if (ereg("[a-z||0-9]@[a-z||0-9].[a-z]", $email)) {

mysql_select_db($database_database, $database);
$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Usuario ='" . $user . "'";
$query = mysql_query($sql) or die(mysql_error());
$totaluser = mysql_num_rows($query);

mysql_select_db($database_database, $database);
$sqll = "SELECT * FROM " . $prefix_database . "_users WHERE Email ='" . $email . "'";
$queryl = mysql_query($sqll) or die(mysql_error());
$totalemail = mysql_num_rows($queryl);

mysql_select_db($database_database, $database);
$sqlll = "SELECT * FROM " . $prefix_database . "_users WHERE Nome ='" . $nome . "'";
$queryll = mysql_query($sqlll) or die(mysql_error());
$totalnome = mysql_num_rows($queryll);

if ($totalnome == 0) {

if ($totalemail == 0) {

if ($totaluser == 0) {

mysql_select_db($database_database, $database);
$sqlid = "SELECT * FROM " . $prefix_database . "_users";
$queryid = mysql_query($sqlid) or die(mysql_error());
$id = mysql_num_rows($queryid) + 1;

mysql_select_db($database_database, $database);
$SQL = "INSERT INTO " . $prefix_database . "_users (Id, Nome, Usuario, Password, Email, Autlvl, Foto) VALUES ('$id', '$nome', '$user', '$password', '$email', '1', 'nenhum.gif')";
$QUERY = mysql_query($SQL) or die(mysql_error());

if ($QUERY) {
echo "<div id=err>Cadastro efetuado com sucesso</div>";
mail($email, "Bem Vindo - Dark Makers", "Seu cadastro foi efetuado com sucesso.");
}
} else {
header ("Location: cadastro.php?err=1");
}
} else {
header ("Location: cadastro.php?err=3");
exit;
}
} else {
header ("Location: cadastro.php?err=5");
}
} else {
header ("Location: cadastro.php?err=6");
}
} else {
header ("Location: cadastro.php?err=2");
}
} else {
header ("Location: cadastro.php?err=4");
}
?>