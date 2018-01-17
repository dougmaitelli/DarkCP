<? $admin = new Admin; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="DougM" />
<meta name="copyright" content="Skin Dark" />
</head>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td height="104" colspan="4" valign="top"><img src="<? $admin->load_img("logo.gif"); ?>" width="300" height="100" /> <strong>V.: 5.0 BETA</strong> </td>
  </tr>
  <tr>
    <td height="19" colspan="2" valign="top">
	  <div align="center">
	  <? $admin->func_barra(); ?>
	  </div></td>
    <td colspan="2" valign="top"> </td>
  </tr>
  <tr>
    <td width="130" rowspan="2" valign="top"><div align="center">
      <p><strong><? $admin->func_menu(); ?></strong></p>
    </div></td>
    <td height="346" colspan="2" valign="top">
	<? $admin->func_content(); ?>
	</td>
  <td width="143" rowspan="2" valign="top">
  <? $admin->func_calendar(); ?>
  </td>
  </tr>
  <tr>
    <td height="35" colspan="2" valign="top"><div align="center"><? $admin->func_copyright(); ?></div></td>
  </tr>
  <tr>
    <td height="0"></td>
    <td width="105"></td>
    <td width="422"></td>
    <td></td>
  </tr>
</table>
</body>
</html>