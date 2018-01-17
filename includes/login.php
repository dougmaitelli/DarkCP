<?php
$err = "-1";
if (isset($_GET['err'])) {
  $err = (get_magic_quotes_gpc()) ? $_GET['err'] : addslashes($_GET['err']);
}
?>

<body>
<form action="logando.php" method="post">
  <label>  </label>
  <table width="252" border="0" cellspacing="0">
    <tr>
      <td width="85"><label>Usu&aacute;rio </label></td>
      <td width="163"><input name="login" type="text" id="login" /></td>
    </tr>
    <tr>
      <td>Senha</td>
      <td><input name="senha" type="password" id="senha" /></td>
    </tr>
    <tr>
      <td><input name="submit" type="submit" value="Login" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <label></label>
</form>
<?php if ($err <> "-1") { ?>
<div id="err">
<?php if ($err == "1") { ?>
<table border="0" cellspacing="0" width="100%" cellpadding="5">
<tr bgcolor="#BC1818">
  <td><span style="color: #000000">O Seguinte erro ocorreu: </span></td>
</tr>
<tr>
  <td>Insira usu&aacute;rio e senha.</td>
</tr>
</table>
<?php } ?>
<?php if ($err == "2") { ?>
<table border="0" cellspacing="0" width="100%" cellpadding="5">
<tr bgcolor="#BC1818">
  <td><span style="color: #000000">O Seguinte erro ocorreu:</span></td>
</tr>
<tr>
  <td>Usu&aacute;rio inv&aacute;lido.</td>
</tr>
</table>
<?php } ?>
<?php if ($err == "3") { ?>
<table border="0" cellspacing="0" width="100%" cellpadding="5">
<tr bgcolor="#BC1818"><td><span style="color: #000000">O Seguinte erro ocorreu: </span></td>
</tr>
<tr>
  <td>Senha inv&aacute;lida.</td>
</tr>
</table>
<?php } ?>
</div>
<?php } ?>
</body>