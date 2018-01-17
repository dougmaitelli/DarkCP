<?
require 'conexao.php';
	
	mysql_select_db($database_database, $database);
	$sql2 = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
	$query2 = mysql_query($sql2) or die(mysql_error());
	$dados2 = mysql_fetch_assoc($query2);
	setlocale (LC_TIME, $dados2['Local']);
	$stamp = strtotime($dados2['Fuso'] . " hours");
	$dia = date(d, $stamp);
	$ano = date(Y, $stamp);
	$mes = date(m, $stamp);
	$mesnome = date(F, $stamp);
	$days = date(t, $stamp);
	$linha = date(w, mktime(0, 0, 0, $mes, 1, $ano));
	echo "<table class='calendario' width='100' border='1' cellpadding='0' cellspacing='0'>
	<tr>
	<td colspan='7'>" . $mesnome . " de " . $ano . "</td>
	</tr>
	<tr>
	<td width='14%'>D</td>
	<td width='14%'>S</td>
	<td width='14%'>T</td>
	<td width='14%'>Q</td>
	<td width='14%'>Q</td>
	<td width='14%'>S</td>
	<td width='14%'>S</td>
	</tr>
	<tr>";
	if ($linha != 0) {
		echo "<td colspan='" . $linha . "'>&nbsp;</td>";
	}
	for ($ind = 1; ; $ind++) {
		if ($linha == 0) {
			echo "<tr>";
		} //end if ($linha == 0)
		echo "<td>";
		$sql2 = "SELECT * FROM " . $prefix_database . "_eventos WHERE ((Iniciod <='" . $ind . "' AND Iniciom ='" . $mes . "' AND ((Inicioy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Iniciom <'" . $mes . "' AND ((Inicioy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Inicioy <'" . $ano . "' AND Allyear ='0')) AND ((Fimd >='" . $ind . "' AND Fimm ='" . $mes . "' AND ((Fimy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Fimm >'" . $mes . "' AND ((Fimy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Fimy >'" . $ano . "' AND Allyear ='0'))";
		$query2 = mysql_query($sql2) or die(mysql_error());
		$eventos = mysql_num_rows($query2);
		$sql3 = "SELECT * FROM " . $prefix_database . "_users WHERE Dia ='" . $ind . "' AND Mes ='" . $mes . "' AND Ano ='" . $ano . "'";
		$query3 = mysql_query($sql3) or die(mysql_error());
		$aniverssarios = mysql_num_rows($query3);
		if ($ind == $dia) { echo "<font color=#FF0000>"; }
		if ($aniverssarios != 0) {
			echo "<a class='aniverssario' href='index.php?cat=show_eventos&dia=" . $ind . "&mes=" . $mes . "&ano=" . $ano . "'>";
		} elseif ($eventos != 0) {
			echo "<a href='index.php?cat=show_eventos&dia=" . $ind . "&mes=" . $mes . "&ano=" . $ano . "'>";
		}
		echo $ind;
		if ($aniverssarios != 0) {
			echo "</a>";
		} elseif ($eventos != 0) {
			echo "</a>";
		}
		if ($ind == $dia) { echo "</font>"; }
		echo "</td>";
		$linha++;
		if ($linha == 7 or $ind == $days) {
			echo "</tr>";
			$linha = 0;
		} //end if ($linha == 7 or $ind == $days)
		if ($ind == $days) {
			break;
		} //end if ($ind == $days)
	} //end for ($ind = 1; ; $ind++)
	echo "</table>";