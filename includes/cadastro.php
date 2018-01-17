<?php $err = $_GET['err']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="cadastrando.php">
  <table width="539" border="0" cellspacing="0">
    <tr>
      <td width="105">Nome
      <label></label></td>
      <td width="430"><input name="nome" type="text" id="nome" />
	  <?php if ($err == 5) { ?>Nome j&aacute; em uso.<?php } ?></td>
    </tr>
    <tr>
      <td><label>Usu&aacute;rio </label></td>
      <td><input name="usuario" type="text" id="usuario" />
      <?php if ($err == 1) { ?>Usu&aacute;rio j&aacute; em uso.<?php } ?></td>
    </tr>
    <tr>
      <td><label>Senha </label></td>
      <td><input name="pass" type="password" id="pass" /></td>
    </tr>
    <tr>
      <td>Repita a senha
        <label></label></td>
      <td><input name="rpass" type="password" id="rpass" />
      <?php if ($err == 2) { ?>Repita a senha corretamente.<?php } ?></td>
    </tr>
    <tr>
      <td><label>Email </label></td>
      <td><input name="email" type="text" id="email" />
      <?php if ($err == 6) { ?>Email n&atilde;o valido.<?php } ?><?php if ($err == 3) { ?>Email j&aacute; em uso.<?php } ?></td>
    </tr>
    <tr>
      <td><input name="submit" type="submit" value="Enviar" /></td>
      <td><?php if ($err == 4) { ?>Verifique se nenhum campo ficou em branco.<?php } ?></td>
    </tr>
  </table>
</form>
</body>
</html>
