<?php

@session_start();

require 'conexao.php';

global $admin;
$admin = new Admin;
	
$admin->func_start();

class Admin { 

	function func_content() {

		$cat = $_GET['cat'];
		$action = $_GET['action'];
		
		switch ($cat) {
			
			case NULL:
				$this->act_home();
				break;
				
			case "users":
				if ($action == NULL) { $this->act_user(); }
				if ($action == "edit") { $this->act_edituser(); }
				if ($action == "cria") { $this->act_criauser(); }
				if ($action == "deleta") { $this->act_deletauser(); }
				if ($action == "imprime") { $this->act_imprimeuser(); }
				break;
				
			case "projetos":
				if ($action == NULL) { $this->act_projeto(); }
				if ($action == "edit") { $this->act_editprojeto(); }
				if ($action == "cria") { $this->act_criaprojeto(); }
				if ($action == "deleta") { $this->act_deletaprojeto(); }
				break;
				
			case "eventos":
				if ($action == NULL) { $this->act_evento(); }
				if ($action == "edit") { $this->act_editevento(); }
				if ($action == "cria") { $this->act_criaevento(); }
				if ($action == "deleta") { $this->act_deletaevento(); }
				break;
				
			case "news":
				if ($action == NULL) { $this->act_news(); }
				if ($action == "edit") { $this->act_editnews(); }
				if ($action == "cria") { $this->act_crianews(); }
				if ($action == "deleta") { $this->act_deletanews(); }
				break;
				
			case "parceria":
				if ($action == NULL) { $this->act_parc(); }
				if ($action == "edit") { $this->act_editparc(); }
				if ($action == "cria") { $this->act_criaparc(); }
				if ($action == "deleta") { $this->act_deletaparc(); }
				break;
				
			case "layout":
				if ($action == NULL) { $this->act_layout(); }
				if ($action == "edit") { $this->act_editlayout(); }
				if ($action == "deleta") { $this->act_deletalayout(); }
				break;
				
			case "config":
				if ($action == NULL) { $this->act_config(); }
				break;
				
			case "upload":
				if ($action == NULL) { $this->act_upload(); }
				if ($action == "cria") { $this->act_criaupload(); }
				if ($action == "deleta") { $this->act_deletaupload(); }
				break;
				
			case "enquete":
				if ($action == NULL) { $this->act_enquete(); }
				if ($action == "edit") { $this->act_editenquete(); }
				if ($action == "cria") { $this->act_criaenquete(); }
				if ($action == "deleta") { $this->act_deletaenquete(); }
				break;
				
			case "contato":
				if ($action == NULL) { $this->act_contato(); }
				if ($action == "ver") { $this->act_vercontato(); }
				if ($action == "deleta") { $this->act_deletacontato(); }
				break;
				
			case "logout":
				$this->act_logout();
				break;
				
			default:
				break;
		}
	}
	
	function func_menu() {
	
			echo "<a href='admin.php'>Home</a><BR>
					<a href='admin.php?cat=users'>Usuários</a><BR>
					<a href='admin.php?cat=projetos'>Projetos</a><BR>
					<a href='admin.php?cat=eventos'>Eventos</a><BR>
					<a href='admin.php?cat=news'>News</a><BR>
					<a href='admin.php?cat=parceria'>Parcerias</a><BR>
					<a href='admin.php?cat=layout'>Layout</a><BR>
					<a href='admin.php?cat=config'>Configurações</a><BR>
					<a href='admin.php?cat=upload'>Upload</a><BR>
					<a href='admin.php?cat=enquete'>Enquetes</a><BR>
					<a href='admin.php?cat=contato'>Menssagens de Contato</a>";
	}
	
	function func_barra() {
	
		$dados = $this->func_dados();
	
		echo $dados['Nome'] . "<a href='admin.php?cat=logout'>(Logout)</a>";
	}
	
	function func_copyright() {
	
		require 'conexao.php';
		
		$sql = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
		$query = mysql_query($sql) or die(mysql_error());
		$lay = mysql_fetch_assoc($query);
	
		$tags = get_meta_tags("layouts/" . $lay['Laynome'] . "/admin.layout.php");
	
		echo $tags['copyright'] . " - by " . $tags['author'] . "<BR>";
		echo "Copyright© Dark CP<BR>
		Programed and Designed by DougM<BR>
		2006 - 2009";
	}
	
	function func_calendar() {
	
		require 'conexao.php';
		
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
				echo "<a class='aniverssario' href='admin.php?cat=eventos&dia=" . $ind . "&mes=" . $mes . "&ano=" . $ano . "'>";
			} elseif ($eventos != 0) {
				echo "<a href='admin.php?cat=eventos&dia=" . $ind . "&mes=" . $mes . "&ano=" . $ano . "'>";
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
	}
	
	function load_img($img) {
	
		$lay = $this->load_layout();
	
		echo "layouts/" . $lay['Laynome'] . "/imgs/" . $img;
	}
	
	function func_start() {
	
		$lay = $this->load_layout();

		echo "<link href='layouts/" . $lay['Laynome'] . "/style.css' rel='stylesheet' type='text/css' />
			<title>Dark CP</title>
			<script src='codigos/SpryValidationTextField.js' type='text/javascript'></script>
			<link href='codigos/SpryValidationTextField.css' rel='stylesheet' type='text/css' />
			<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
			<link rel='alternate' type='application/rss+xml' title='Notícias - RSS' href='rss.php' />
			<link rel='alternate' type='application/atom+xml' title='Notícias - Atom' href='atom.php'/>
			<link rel='search' type='application/opensearchdescription+xml' title='Dark CP' href='http://localhost/dark/opensearch.xml' />";
		
		if ($_SESSION['ID'] == NULL) { die("Você deve estar logado"); }
			
		$dados = $this->func_dados();
	
		if ($dados['Autlvl'] != 3) { die("Você não tem permissão para acessar este painel"); }
	
		if ($_POST['confirm'] != NULL) { $_SESSION['confirm'] = md5(trim($_POST['confirm'])); }
	
		if ($_SESSION['confirm'] == NULL) { die($this->func_confirm()); }
	
		if ($_SESSION['confirm'] != $dados['Password']) { 
			
			$_SESSION['confirm'] = NULL;
			die("Senha incorreta");
		}
		
		include("layouts/" . $lay['Laynome'] . "/admin.layout.php");
		$this->func_ativo();
	}

	private function func_dados() {
	
		require 'conexao.php';
		
		$id = addslashes($_SESSION['ID']);
		
		$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $id . "'";
		$query = mysql_query($sql) or die(mysql_error());
		$dados = mysql_fetch_assoc($query);
		
		return $dados;
	}
	
	private function func_ativo() {
	
		require 'conexao.php';
		
		$id = addslashes($_SESSION['ID']);
		
		$sql = "UPDATE " . $prefix_database . "_users SET Ativo =NOW() WHERE Id ='" . $id . "'";
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	private function load_layout() {
	
		require 'conexao.php';
		
		$sql = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
		$query = mysql_query($sql) or die(mysql_error());
		$lay = mysql_fetch_assoc($query);
		
		return $lay;
	}
	
	private function func_confirm() {
	
		echo "<form name='form1' method='post' action='admin.php'>
		<span id='confirmlay'>
		Confirmação de senha
		<label>
		<input name='confirm' size='30' maxlength='100' type='password' id='confirm'>
		</label>
		<span class='textfieldRequiredMsg'>A value is required.</span></span>
		<BR>
		<input type='submit' value='Enviar'>
		<BR>
		</form>
		<script type='text/javascript'>
		<!--
		var confirmlay = new Spry.Widget.ValidationTextField(\"confirmlay\");
		//-->
		</script>";
	}
	
	private function act_home() {
	
		require 'conexao.php';
		
		$sql = "SELECT * FROM " . $prefix_database . "_users";
		$query = mysql_query($sql) or die(mysql_error());
		$usersnum = mysql_num_rows($query);
		echo "Escolha uma das opções...<BR><BR>";
		echo "Temos um total de " . $usersnum . " usuários cadastrados...<BR><BR>";
		$sql = "SELECT * FROM " . $prefix_database . "_projetos";
		$query = mysql_query($sql) or die(mysql_error());
		$prjsnum = mysql_num_rows($query);
		echo "Temos um total de " . $prjsnum . " projetos monitorados...<BR><BR>";
		$sql = "SELECT * FROM " . $prefix_database . "_eventos";
		$query = mysql_query($sql) or die(mysql_error());
		$eventsnum = mysql_num_rows($query);
		echo "Temos um total de " . $eventsnum . " eventos monitorados...<BR><BR>";
		$sql = "SELECT * FROM " . $prefix_database . "_news";
		$query = mysql_query($sql) or die(mysql_error());
		$newsnum = mysql_num_rows($query);
		echo "Temos um total de " . $newsnum . " news ativas...<BR><BR>";
		$sql = "SELECT * FROM " . $prefix_database . "_parcerias";
		$query = mysql_query($sql) or die(mysql_error());
		$parcsnum = mysql_num_rows($query);
		echo "Temos um total de " . $parcsnum . " parcerias cadastradas...<BR><BR>";
	}
	
	private function act_user() {
	
		require 'conexao.php';
		
		echo "<script>
				<!--
					function deleta() {
						document.del.action = \"admin.php?cat=users&action=deleta\";
						document.del.submit();
					}
					function imprime() {
						document.del.action = \"admin.php?cat=users&action=imprime\";
						document.del.submit();
					}
				//-->
			</script>";
			
		$busca = $_GET['busca'];
		$pg = isset($_GET['pg']) ? trim($_GET['pg']) : 1;
		
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=users'>
				<input name='cat' type='hidden' id='cat' value='users'>
				<input type='text' size='30' maxlength='100' name='busca'>
				<input type='submit' value='Buscar' />
			</form>";
			
		echo "<form id='del' name='del' method='post'>
				<input type='submit' value='Deletar' onClick='deleta()'/>
				<input type='submit' value='Imprimir' onClick='imprime()'/><br /><br />";
				
		$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Nome LIKE '%" . $busca . "%' OR Usuario LIKE '%" . $busca . "%' LIMIT " . ($pg-1)*10 . "," . $pg*10;
		$query = mysql_query($sql) or die(mysql_error());
				
		while ($dados = mysql_fetch_assoc($query)) {
			
			echo "<input type='checkbox' name='user" . $dados['Id'] . "' value='true' />";
			echo "<a href='admin.php?cat=users&action=edit&user=" . $dados['Id'] . "'>" . $dados['Id'] . " - " . $dados['Nome'] . "</a><br>";
		} //end while ($dados = mysql_fetch_assoc($query))
		
		echo "</form>";
		
		$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Nome LIKE '%" . $busca . "%' OR Usuario LIKE '%" . $busca . "%'";
		$query = mysql_query($sql) or die(mysql_error());
		
		for ($i = 1; ($i-1) * 10 < mysql_num_rows($query); $i++) {
			echo "<input type='submit' value='" . $i . "' onClick=\"parent.location='admin.php?cat=users&busca=" . $busca . "&pg=" . $i . "'\" />&nbsp;";
		}
		
		echo "<br><br>";
		
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=users&action=cria'>	
				<input type='submit' value='Novo' />
			</form>";
	}
	
	private function act_criauser() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		
		if ($cria == NULL) {
			
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=users&action=cria&cria=cria'>
			<table width='539' border='0' cellspacing='0'>
			<tr>
			<td width='105'>Nome</td>
			<td width='430'><span id='camponome'>
			<input name='nome' type='text' size='30' maxlength='100' id='nome' />
			<span class='textfieldRequiredMsg'>Não deve ficar em branco.</span></span></td>
			</tr>
			<tr>
			<td>Usuário</td>
			<td><span id='campouser'>
			<input name='usuario' type='text' size='30' maxlength='100' id='usuario' />
			<span class='textfieldRequiredMsg'>Não deve ficar em branco.</span></span></td>
			</tr>
			<tr>
			<td>Senha</td>
			<td><span id='camposenha'>
			<input name='pass' size='30' maxlength='100' type='password' id='pass' />
			<span class='textfieldRequiredMsg'>Não deve ficar em branco.</span></span></td>
			</tr>
			<tr>
			<td>Email</td>
			<td><span id='campoemail'>
			<input name='email' type='text' size='30' maxlength='100' id='email' />
			<span class='textfieldRequiredMsg'>Não deve ficar em branco.</span></span></td>
			</tr>
			<tr>
			<td>Nasc.</td>
			<td><span id='camponasc'>
			<input name='dia' type='text' size='5' maxlength='2' id='dia' />&nbsp;/
			<input name='mes' type='text' size='5' maxlength='2' id='mes' />&nbsp;/
			<input name='ano' type='text' size='5' maxlength='4' id='ano' />
			<span class='textfieldRequiredMsg'>Não deve ficar em branco.</span></span></td></td>
			</tr>
			<tr>
			<td>AutLevel</td>
			<td>
			<select name='autlevel' id='autlevel'>
			<option value='1' selected='selected'>Usu&aacute;rio</option>
			<option value='2'>Moderador</option>
			<option value='3'>Admin</option>
			</select>
			</td>
			</tr>
			<tr>
			<td><input name='submit' type='submit' value='Criar' /></td>
			</tr>
			</table>
			</form>
			<script type='text/javascript'>
			<!--
			var camponome = new Spry.Widget.ValidationTextField(\"camponome\");
			var campouser = new Spry.Widget.ValidationTextField(\"campouser\");
			var camposenha = new Spry.Widget.ValidationTextField(\"camposenha\");
			var campoemail = new Spry.Widget.ValidationTextField(\"campoemail\",\"email\");
			var camponasc = new Spry.Widget.ValidationTextField(\"camponasc\");
			//-->
			</script>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
		
			$nome = isset($_POST['nome']) ? trim($_POST['nome']) : FALSE;
			$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : FALSE;
			$password = isset($_POST['pass']) ? md5(trim($_POST['pass'])) : FALSE;
			$email = isset($_POST['email']) ? trim($_POST['email']) : FALSE;
			$dia = isset($_POST['dia']) ? trim($_POST['dia']) : FALSE;
			$mes = isset($_POST['mes']) ? trim($_POST['mes']) : FALSE;
			$ano = isset($_POST['ano']) ? trim($_POST['ano']) : FALSE;
			$autlevel = isset($_POST['autlevel']) ? trim($_POST['autlevel']) : FALSE;
			
			$criar = true;
			
			if (!$nome || !$usuario || !$password || !$email || !$autlevel) {
				
				$criar = false;
				echo "Nenhum campo deve ficar em branco...<BR>";
			} //end if (!$nome || !$usuario || !$password || !$email)
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				
				$criar = false;
				echo "O email informado não é valido.<BR>";
			} //end if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			
			$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Usuario ='" . $usuario . "'";
			$query = mysql_query($sql) or die(mysql_error());
			$totaluser = mysql_num_rows($query);
			
			if ($totaluser != 0) {
				
				$criar = false;
				echo "Usuário já está sendo utilizado.<BR>";
			} //end if ($totaluser == 0)
			
			$sqlll = "SELECT * FROM " . $prefix_database . "_users WHERE Nome ='" . $nome . "'";
			$queryll = mysql_query($sqlll) or die(mysql_error());
			$totalnome = mysql_num_rows($queryll);
			
			if ($totalnome != 0) {
				
				$criar = false;
				echo "Nome já está sendo utilizado.<BR>";
			} //end if ($totalnome == 0)
			
			if ($criar == true) {
				
				$SQL = "INSERT INTO " . $prefix_database . "_users (Nome, Usuario, Password, Email, Autlvl, Dia, Mes, Ano, Foto) VALUES ('$nome', '$usuario', '$password', '$email', '$autlevel', '$dia', '$mes', '$ano', 'nenhum.gif')";
				$QUERY = mysql_query($SQL) or die(mysql_error());
				echo "Usuário criado com sucesso...";
			} //end if ($criar == true)
		} //end if ($action == NULL)
	}
	
	private function act_edituser() {
	
		require 'conexao.php';
		
		$dados = $this->func_dados();
		
		$user = $_GET['user'];
		$edit = $_GET['edit'];
		
		if ($edit == NULL) {
			
			$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $user . "'";
			$query = mysql_query($sql) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query);
			echo "<form id='form2' name='form2' method='post' enctype='multipart/form-data' action='admin.php?cat=users&action=edit&user=" . $user .  "&edit=edit'>
			<table width='466' border='0' cellspacing='0'>
			<tr>
			<td width='77'>Nome</td>
			<td width='232'>
			<input name='newnome' type='text' size='30' maxlength='100' id='newnome' value='" . $dados2['Nome'] . "' />
			</td>
			<td width='151' rowspan='7' valign='top'>
			<img src='avatars/" . $dados2['Foto'] . "' />
			</td>
			</tr>
			<tr>
			<td>Usu&aacute;rio</td>
			<td>
			<input name='newusuario' type='text' size='30' maxlength='100' id='newusuario' value='" . $dados2['Usuario'] . "' />
			</td>
			</tr>
			<tr>
			<td>Email</td>
			<td>
			<input name='newemail' type='text' size='30' maxlength='100' id='newemail' value='" . $dados2['Email'] . "' />
			</td>
			</tr>
			<tr>
			<td>Nova senha</td>
			<td>
			<input name='newsenha' size='30' maxlength='100' type='password' id='newsenha' />
			</td>
			</tr>
			<tr>
			<td>Nasc.</td>
			<td>
			<input name='newdia' type='text' size='5' maxlength='2' value='" . $dados2['Dia'] . "' id='newdia' />&nbsp;/
			<input name='newmes' type='text' size='5' maxlength='2' value='" . $dados2['Mes'] . "' id='newmes' />&nbsp;/
			<input name='newano' type='text' size='5' maxlength='4' value='" . $dados2['Ano'] . "' id='newano' /></td>
			</tr>
			<tr>
			<td>End. IP</td>
			<td>" . $dados2['Ip'] . "</td>
			</tr>
			<tr>
			<td>Ultima Ação</td>
			<td>" . $dados2['Ativo'] . "</td>
			</tr>";
			
			if ($dados2['Id'] != 1) {
				echo "<tr>
				<td>AutLevel</td>
				<td><select name='newautlevel' id='newautlevel'>
				<option value='1'";
				if ($dados2['Autlvl'] == 1) { echo "selected='selected'"; } 
				echo ">Usu&aacute;rio</option>
				<option value='2'";
				if ($dados2['Autlvl'] == 2) { echo "selected='selected'"; } 
				echo ">Moderador</option>
				<option value='3'";
				if ($dados2['Autlvl'] == 3) { echo "selected='selected'"; } 
				echo ">Admin</option>
				</select></td>
				</tr>";
			} //end if ($dados2['Id'] != 1)
			echo "<tr>
			<td>
			<div align='right'>Foto
			<input type='radio' name='fotoounenhum' value='foto' />
			</div>
			</td>
			<td>
			<input name='foto' size='30' maxlength='100' type='file' id='foto'>
			</td>
			</tr>
			<tr>
			<td>
			<div align='right'>
			<input type='radio' name='fotoounenhum' value='nenhum' />
			</div>
			</td>
			<td>Remover foto.</td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='Editar' />
			</td>
			<td>&nbsp;</td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elsif if ($edit == NULL)
		
			$newnome = isset($_POST['newnome']) ? trim($_POST['newnome']) : FALSE;
			$newusuario = isset($_POST['newusuario']) ? trim($_POST['newusuario']) : FALSE;
			$newemail = isset($_POST['newemail']) ? trim($_POST['newemail']) : FALSE;
			$newsenha = isset($_POST['newsenha']) ? trim($_POST['newsenha']) : FALSE;
			$newautlevel = isset($_POST['newautlevel']) ? trim($_POST['newautlevel']) : FALSE;;
			$newdia = isset($_POST['newdia']) ? trim($_POST['newdia']) : FALSE;
			$newmes = isset($_POST['newmes']) ? trim($_POST['newmes']) : FALSE;
			$newano = isset($_POST['newano']) ? trim($_POST['newano']) : FALSE;
			$fotoounenhum = $_POST['fotoounenhum'];
			
			$modifica = true;
			
			if ($user == 1) {
				
				if ($dados['Id'] != 1) {
					
					$modifica = false;
					echo "Você não tem permissão para alterar este usuário...";
				} //end if ($dados['Id'] == 1)
			} //end if ($user == 1)
			
			if ($modifica == true) {
				
				if ($newemail) {
					
					if (filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
						
						$update = "UPDATE " . $prefix_database . "_users SET Email ='" . $newemail . "' WHERE Id ='" . $user . "'";
						$updateq = mysql_query($update) or die(mysql_error());
						echo "Email atualizado.<BR>";
					} else { //else if (filter_var($newemail, FILTER_VALIDATE_EMAIL))
					
						echo "O email informado não é válido.<BR>";
					} //end if (filter_var($newemail, FILTER_VALIDATE_EMAIL))
				} //end if ($newemail)
				
				if ($newusuario) {
					
					$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Usuario ='" . $newusuario . "'";
					$query = mysql_query($sql) or die(mysql_error());
					$totaluser = mysql_num_rows($query);
					
					if ($totaluser == 0) {
						
						$update = "UPDATE " . $prefix_database . "_users SET Usuario ='" . $newusuario . "' WHERE Id ='" . $user . "'";
						$updateq = mysql_query($update) or die(mysql_error());
						echo "Usuário atualizado.<BR>";
					} else { //else if ($totaluser == 0)
					
						echo "O usuário já existe...<BR>";
					} //end if ($totaluser == 0)
				} //end if ($newusuario)
				
				if ($newnome) {
					
					$sql = "SELECT * FROM " . $prefix_database . "_users WHERE Nome ='" . $newnome . "'";
					$query = mysql_query($sql) or die(mysql_error());
					$totalnome = mysql_num_rows($query);
					
					if ($totalnome == 0) {
						
						$update = "UPDATE " . $prefix_database . "_users SET Nome ='" . $newnome . "' WHERE Id ='" . $user . "'";
						$updateq = mysql_query($update) or die(mysql_error());
						echo "Nome atualizado.<BR>";
					} else { //else if ($totalnome == 0)
						
						echo "Este nome já está sendo usado...<BR>";
					} //end if ($totalnome == 0)
				} //end if ($newnome)
				
				if ($user != 1) {
					
					if ($newautlevel) {
					
						$update = "UPDATE " . $prefix_database . "_users SET Autlvl ='" . $newautlevel . "' WHERE Id ='" . $user . "'";
						$updateq = mysql_query($update) or die(mysql_error());
						echo "AutLevel atualizado.<BR>";
					} // end if ($autlevel)
				} //end if ($user != 1)
				
				if ($newsenha) {
					
					$update = "UPDATE " . $prefix_database . "_users SET Password ='" . md5($newsenha) . "' WHERE Id ='" . $user . "'";
					$updateq = mysql_query($update) or die(mysql_error());
					echo "Senha atualizada.<BR>";
				} //end if ($newsenha)
				
				if ($newdia) {
					
					$update = "UPDATE " . $prefix_database . "_users SET Dia ='" . $newdia . "' WHERE Id ='" . $user . "'";
					$updateq = mysql_query($update) or die(mysql_error());
					echo "Dia atualizado.<BR>";
				} //end if ($newdia)
				
				if ($newmes) {
					
					$update = "UPDATE " . $prefix_database . "_users SET Mes ='" . $newmes . "' WHERE Id ='" . $user . "'";
					$updateq = mysql_query($update) or die(mysql_error());
					echo "Mês atualizado.<BR>";
				} //end if ($newmes)
				
				if ($newano) {
					
					$update = "UPDATE " . $prefix_database . "_users SET Ano ='" . $newano . "' WHERE Id ='" . $user . "'";
					$updateq = mysql_query($update) or die(mysql_error());
					echo "Ano atualizado.<BR>";
				} //end if ($newano)
				
				$mudoufoto = false;
				
				if ($fotoounenhum == "foto") {
					
					$erro = $config = array();
					$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
					$config["tamanho"] = 106883;
					$config["largura"] = 100;
					$config["altura"]  = 150;
					
					if ($arquivo) {
						
						if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])) {
							
							$erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outra imagem...";
						} else { //else if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
							
							if ($arquivo["size"] > $config["tamanho"]) {
								
								$erro[] = "A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. Envie outra imagem...";
							} //end if ($arquivo["size"] > $config["tamanho"])
							
							$tamanhos = getimagesize($arquivo["tmp_name"]);
							
							if ($tamanhos[0] > $config["largura"]) {
								
								$erro[] = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels..."; 
							} //end if ($tamanhos[0] > $config["largura"])
							
							if ($tamanhos[1] > $config["altura"]) {
								
								$erro[] = "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels..."; 
							} //end if ($tamanhos[1] > $config["altura"])
						} //end if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
						
						if (sizeof($erro)) {
							
							foreach ($erro as $err) {
								
								echo " - " . $err . "<BR>";
							} //end foreach ($erro as $err)
						} else { //else if (sizeof($erro))
							
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
							$imagem_nome = $user . "." . $ext[1];
							$imagem_dir = "avatars/" . $imagem_nome;
							move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
							chmod($imagem_dir, 0755);
							echo "Sua foto foi enviada com sucesso!";
							$mudoufoto = true;
						} //end if (sizeof($erro))
					} //end if ($arquivo)
				} elseif ($fotoounenhum == "nenhum") { //elseif if ($fotoounenhum == "foto")
					
					$imagem_nome = "nenhum.gif";
					echo "Foto atualizada com sucesso...";
					$mudoufoto = true;
				} //end if ($fotoounenhum == "foto")
				
				if ($mudoufoto == true) {
					
					$update = "UPDATE " . $prefix_database . "_users SET Foto ='" . $imagem_nome . "' WHERE Id ='" . $user . "'";
					$updateq = mysql_query($update) or die(mysql_error());
				} //end if ($mudoufoto == true)
			} //end if ($modifica == true)
		} //end if ($edit == NULL)
	}
	
	private function act_deletauser() {
	
		require 'conexao.php';
		
		$sql = "SELECT * FROM " . $prefix_database . "_users";
		$query = mysql_query($sql) or die(mysql_error());
		
		while ($dados = mysql_fetch_assoc($query)) {
			
			if ($dados['Id'] != 1) {
				
				if ($_POST['user' . $dados['Id']] == "true") {
					
					$delete = "DELETE FROM " . $prefix_database . "_users WHERE Id = '" . $dados['Id'] . "'";
					$deleteq = mysql_query($delete) or die(mysql_error());
					echo "Usuário " . $dados['Id'] . " - " . $dados['Nome'] . " foi deletado...<br />";
				} //end if ($_POST['user' . $dados['Id']])
			} //end if ($dados['Id'] != 1)
		} //end while ($dados = mysql_fetch_assoc($query))
		
		echo "Todos Usuários selecionados foram deletados...";
	}
	
	private function act_imprimeuser() {
		
		require 'conexao.php';
		
		$sql = "SELECT * FROM " . $prefix_database . "_users";
		$query = mysql_query($sql) or die(mysql_error());
		$handle = printer_open("EPSON Stylus COLOR 777");
		
		while ($dados = mysql_fetch_assoc($query)) {
			
			if ($_POST['user' . $dados['Id']] == "true") {
				
				$impresso .= $dados['Id'] . " - " . $dados['Nome'] . " - " . $dados['Email'] . " - " . $dados['Autlvl'] . "\n";
				echo "Usuário " . $dados['Id'] . " - " . $dados['Nome'] . " foi impresso...<br />";
			} //end if ($_POST['user' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		
		printer_write($handle, $impresso);
		printer_close($handle);
		echo "Todos Usuários selecionados foram imprimidos...";
	}
	
	private function act_projeto() {
	
		require 'conexao.php';
		
		$busca = $_GET['busca'];
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_projetos";
		$query2 = mysql_query($sql2) or die(mysql_error());
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=projetos'>	
		<input name='cat' type='hidden' id='cat' value='projetos'>
		<input type='text' size='30' maxlength='100' name='busca'>
		<input type='submit' value='Buscar' />
		</form>";
		echo "<form id='del' name='del' method='post' action='admin.php?cat=projetos&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		if ($busca == NULL) {
			while ($dados2 = mysql_fetch_assoc($query2)) {
				echo "
				<input type='checkbox' name='projeto" . $dados2['Id'] . "' value='true' />
				";
				echo "<a href='admin.php?cat=projetos&action=edit&prj=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'] . " - " . $dados2['Porcentagem'] . "%</a><br>";
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} else { //else if ($busca == NULL)
			while ($dados2 = mysql_fetch_assoc($query2)) {
				if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0) {
					echo "
					<input type='checkbox' name='projeto" . $dados2['Id'] . "' value='true' />
					";
					echo "<a href='admin.php?cat=projetos&action=edit&prj=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'] . " - " . $dados2['Porcentagem'] . "%</a><br>";
				} //end if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0)
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} //end if ($busca == NULL)
		echo "</form>";
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=projetos&action=cria'>
		<input type='submit' value='Novo' />
		</form>";
	}
	
	private function act_editprojeto() {
	
		require 'conexao.php';
		
		$prj = $_GET['prj'];
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			mysql_select_db($database_database, $database);
			$sql2 = "SELECT * FROM " . $prefix_database . "_projetos WHERE Id ='" . $prj . "'";
			$query2 = mysql_query($sql2) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query2);
			echo "
			<form id='form1' name='form1' method='post' action='admin.php?cat=projetos&action=edit&prj=" . $prj .  "&edit=edit'>
			<table width='413' border='0' cellspacing='0'>
			<tr>
			<td width='79'>Nome</td>
			<td width='330'>
			<input name='newnome' value='" . $dados2['Nome'] . "' type='text' size='30' maxlength='100' id='nome' />
			</td>
			</tr>
			<tr>
			<td>Descri&ccedil;&atilde;o</td>
			<td>
			<textarea name='newdesc' cols='50' rows='10' id='descricao'>" . $dados2['Descricao'] . "</textarea>
			</td>
			</tr>
			<tr>
			<td>Porcentagem</td>
			<td>
			<input name='newperc' value='" . $dados2['Porcentagem'] . "' type='text' size='30' maxlength='100' id='perc' />
			</td>
			</tr>
			<tr>
			<td>Lan&ccedil;amento</td>
			<td>
			<input name='newlanca' value='" . $dados2['Lancamento'] . "' type='text' size='30' maxlength='100' id='lanca' />
			</td>
			</tr>
			<tr>
			<td>Equipe</td>
			<td>
			<textarea name='newequipe' cols='50' rows='10' id='equipe'>" . $dados2['Equipe'] . "				</textarea>
			</td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='Editar' />
			</td>
			<td>&nbsp;</td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$newnome = trim($_POST['newnome']);
			$newequipe = trim($_POST['newequipe']);
			$newlanca = trim($_POST['newlanca']);
			$newdesc = trim($_POST['newdesc']);
			$newperc = trim($_POST['newperc']);
			mysql_select_db($database_database, $database);
			$update = "UPDATE " . $prefix_database . "_projetos SET Nome ='" . $newnome . "' WHERE Id ='" . $prj . "'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update2 = "UPDATE " . $prefix_database . "_projetos SET Equipe ='" . $newequipe . "' WHERE Id ='" . $prj . "'";
			$updateq2 = mysql_query($update2) or die(mysql_error());
			$update3 = "UPDATE " . $prefix_database . "_projetos SET Lancamento ='" . $newlanca . "' WHERE Id ='" . $prj . "'";
			$updateq3 = mysql_query($update3) or die(mysql_error());
			$update4 = "UPDATE " . $prefix_database . "_projetos SET Descricao ='" . $newdesc . "' WHERE Id ='" . $prj . "'";
			$updateq4 = mysql_query($update4) or die(mysql_error());
			$update5 = "UPDATE " . $prefix_database . "_projetos SET Porcentagem ='" . $newperc . "' WHERE Id ='" . $prj . "'";
			$updateq5 = mysql_query($update5) or die(mysql_error());
			echo "Projeto atualizado...";
		} //end if ($edit == NULL)
	}
	
	private function act_criaprojeto() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		if ($cria == NULL) {
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=projetos&action=cria&cria=cria'>
			<table width='413' border='0' cellspacing='0'>
			<tr>
			<td width='79'>Nome</td>
			<td width='330'>
			<input name='nome' type='text' size='30' maxlength='100' id='nome' />
			</td>
			</tr>
			<tr>
			<td>Descri&ccedil;&atilde;o</td>
			<td>
			<textarea name='descricao' cols='50' rows='10' id='descricao'></textarea>
			</td>
			</tr>
			<tr>
			<td>Porcentagem</td>
			<td>
			<input name='perc' type='text' size='30' maxlength='100' id='perc' />
			</td>
			</tr>
			<tr>
			<td>Lan&ccedil;amento</td>
			<td>
			<input name='lanca' type='text' size='30' maxlength='100' id='lanca' />
			</td>
			</tr>
			<tr>
			<td>Equipe</td>
			<td>
			<textarea name='equipe' cols='50' rows='10' id='equipe'></textarea>
			</td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='Criar' />
			</td>
			<td>&nbsp;</td>
			</tr>
			</table>
			</form>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
			$nome = trim($_POST['nome']);
			$equipe = trim($_POST['equipe']);
			$perc = trim($_POST['perc']);
			$desc = trim($_POST['descricao']);
			$lanca = trim($_POST['lanca']);
			mysql_select_db($database_database, $database);
			$SQL = "INSERT INTO " . $prefix_database . "_projetos (Nome, Equipe, Porcentagem, Descricao, Lancamento) VALUES ('$nome', '$equipe', '$perc', '$desc', '$lanca')";
			$QUERY = mysql_query($SQL) or die(mysql_error());
			echo "Projeto criado com sucesso...";
		} //end if ($cria == NULL)
	}
	
	private function act_deletaprojeto () {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_projetos";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if ($_POST['projeto' . $dados2['Id']] == "true") {
				$delete = "DELETE FROM " . $prefix_database . "_projetos WHERE Id = '" . $dados2['Id'] . "'";
				$deleteq = mysql_query($delete) or die(mysql_error());
				echo "Projeto " . $dados2['Id'] . " - " . $dados2['Nome'] . " foi deletado...<br />";
			} //end if ($_POST['projeto' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "Todos Projetos selecionados foram deletados...";
	}
	
	private function act_evento() {
	
		require 'conexao.php';
		
		$dia = $_GET['dia'];
		$mes = $_GET['mes'];
		$ano = $_GET['ano'];
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=eventos'>
		<input name='cat' type='hidden' id='cat' value='eventos'>
		<input type='text' size='5' maxlength='2' name='dia'>&nbsp;/
		<input type='text' size='5' maxlength='2' name='mes'>&nbsp;/
		<input type='text' size='5' maxlength='4' name='ano'>
		<input type='submit' value='Ir' />
		</form>";
		mysql_select_db($database_database, $database);
		if ($dia == NULL and $mes == NULL and $ano == NULL) {
			$sql2 = "SELECT * FROM " . $prefix_database . "_eventos";
		} else { //else if ($dia == NULL and $mes == NULL and $ano == NULL)
			$sql2 = "SELECT * FROM " . $prefix_database . "_eventos WHERE ((Iniciod <='" . $dia . "' AND Iniciom ='" . $mes . "' AND ((Inicioy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Iniciom <'" . $mes . "' AND ((Inicioy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Inicioy <'" . $ano . "' AND Allyear ='0')) AND ((Fimd >='" . $dia . "' AND Fimm ='" . $mes . "' AND ((Fimy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Fimm >'" . $mes . "' AND ((Fimy ='" . $ano . "' AND Allyear ='0') OR Allyear ='1')) OR (Fimy >'" . $ano . "' AND Allyear ='0'))";
		} //end if ($dia == NULL and $mes == NULL and $ano == NULL)
		$query2 = mysql_query($sql2) or die(mysql_error());
		echo "<form id='del' name='del' method='post' action='admin.php?cat=eventos&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		while ($dados2 = mysql_fetch_assoc($query2)) {
			echo "<input type='checkbox' name='evento" . $dados2['Id'] . "' value='true' />";
			echo "<a href='admin.php?cat=eventos&action=edit&evento=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'];
			if (($dados2['Allyear'] == 1)) {
				echo "(" . (date(Y) - $dados2['Inicioy']) . ")";
			}
			echo "</a><br>";
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "</form>";
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=eventos&action=cria'>
		<input type='submit' value='Novo' />
		</form>";
	}
	
	private function act_editevento() {
	
		require 'conexao.php';
		
		$event = $_GET['evento'];
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			mysql_select_db($database_database, $database);
			$sql2 = "SELECT * FROM " . $prefix_database . "_eventos WHERE Id ='" . $event . "'";
			$query2 = mysql_query($sql2) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query2);
			echo "
			<form id='form1' name='form1' method='post' action='admin.php?cat=eventos&action=edit&evento=" . $event . "&edit=edit'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Nome</td>
			<td width='322'>
			<input name='newnome' type='text' size='30' maxlength='100' value='" . $dados2['Nome'] . "' id='nome' /></td>
			</tr>
			<tr>
			<td>Descrição</td>
			<td><textarea name='newdesc' cols='50' rows='10' id='desc'>" . $dados2['Descricao'] . "</textarea></td>
			</tr>
			<tr>
			<td>Inicio</td>
			<td>
			<input name='newiniciod' type='text' size='5' maxlength='2' value='" . $dados2['Iniciod'] . "' id='iniciod' />&nbsp;/
			<input name='newiniciom' type='text' size='5' maxlength='2' value='" . $dados2['Iniciom'] . "' id='iniciom' />&nbsp;/
			<input name='newinicioy' type='text' size='5' maxlength='4' value='" . $dados2['Inicioy'] . "' id='inicioy' /></td>
			</tr>
			<tr>
			<td>Fim</td>
			<td>
			<input name='newfimd' type='text' size='5' maxlength='2' value='" . $dados2['Fimd'] . "' id='fimd' />&nbsp;/
			<input name='newfimm' type='text' size='5' maxlength='2' value='" . $dados2['Fimm'] . "' id='fimm' />&nbsp;/
			<input name='newfimy' type='text' size='5' maxlength='4' value='" . $dados2['Fimy'] . "' id='fimy' /></td>
			</tr>
			<tr>
			<td>Todos Anos</td>
			<td><input type='checkbox' name='allyear' ";
			if ($dados2['Allyear'] == 1) {
				echo "checked='checked' ";
			} //end if ($dados2['Allyear'] == 1)
			echo "value='1' /></td>
			</tr>
			<tr>
			<td><input type='submit' value='Editar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$newnome = trim($_POST['newnome']);
			$newdesc = trim($_POST['newdesc']);
			$newiniciod = trim($_POST['newiniciod']);
			$newiniciom = trim($_POST['newiniciom']);
			$newinicioy = trim($_POST['newinicioy']);
			$newfimd = trim($_POST['newfimd']);
			$newfimm = trim($_POST['newfimm']);
			$newfimy = trim($_POST['newfimy']);
			$allyear = trim($_POST['allyear']);
			mysql_select_db($database_database, $database);
			$update = "UPDATE " . $prefix_database . "_eventos SET Nome ='" . $newnome . "' WHERE Id ='" . $event . "'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update2 = "UPDATE " . $prefix_database . "_eventos SET Descricao ='" . $newdesc . "' WHERE Id ='" . $event . "'";
			$updateq2 = mysql_query($update2) or die(mysql_error());
			$update3 = "UPDATE " . $prefix_database . "_eventos SET Iniciod ='" . $newiniciod . "' WHERE Id ='" . $event . "'";
			$updateq3 = mysql_query($update3) or die(mysql_error());
			$update4 = "UPDATE " . $prefix_database . "_eventos SET Iniciom ='" . $newiniciom . "' WHERE Id ='" . $event . "'";
			$updateq4 = mysql_query($update4) or die(mysql_error());
			$update5 = "UPDATE " . $prefix_database . "_eventos SET Inicioy ='" . $newinicioy . "' WHERE Id ='" . $event . "'";
			$updateq5 = mysql_query($update5) or die(mysql_error());
			$update6 = "UPDATE " . $prefix_database . "_eventos SET Fimd ='" . $newfimd . "' WHERE Id ='" . $event . "'";
			$updateq6 = mysql_query($update6) or die(mysql_error());
			$update7 = "UPDATE " . $prefix_database . "_eventos SET Fimm ='" . $newfimm . "' WHERE Id ='" . $event . "'";
			$updateq7 = mysql_query($update7) or die(mysql_error());
			$update8 = "UPDATE " . $prefix_database . "_eventos SET Fimy ='" . $newfimy . "' WHERE Id ='" . $event . "'";
			$updateq8 = mysql_query($update8) or die(mysql_error());
			$update9 = "UPDATE " . $prefix_database . "_eventos SET Allyear ='" . $allyear . "' WHERE Id ='" . $event . "'";
			$updateq9 = mysql_query($update9) or die(mysql_error());
			echo "Evento atualizado...";
		} //end if ($edit == NULL)
	}
	
	private function act_criaevento() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		if ($cria == NULL) {
			echo "
			<form id='form1' name='form1' method='post' action='admin.php?cat=eventos&action=cria&cria=cria'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Nome</td>
			<td width='322'>
			<input name='nome' type='text' size='30' maxlength='100' id='nome' />
			</td>
			</tr>
			<tr>
			<td>Descri&ccedil;&atilde;o</td>
			<td>
			<textarea name='desc' cols='50' rows='10' id='desc'></textarea>
			</td>
			</tr>
			<tr>
			<td>Inicio</td>
			<td>
			<input name='iniciod' type='text' id='iniciod' size='5' maxlength='2' />&nbsp;/
			<input name='iniciom' type='text' id='iniciom' size='5' maxlength='2' />&nbsp;/
			<input name='inicioy' type='text' id='inicioy' size='5' maxlength='4' />
			</td>
			</tr>
			<tr>
			<td>Fim</td>
			<td>
			<input name='fimd' type='text' id='fimd' size='5' maxlength='2' />&nbsp;/
			<input name='fimm' type='text' id='fimm' size='5' maxlength='2' />&nbsp;/
			<input name='fimy' type='text' id='fimy' size='5' maxlength='4' />
			</td>
			</tr>
			<tr>
			<td>Todos Anos</td>
			<td><input type='checkbox' name='allyear' value='1' /></td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='Criar' />
			</td>
			</tr>
			</table>
			</form>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
			$nome = trim($_POST['nome']);
			$desc = trim($_POST['desc']);
			$iniciod = trim($_POST['iniciod']);
			$iniciom = trim($_POST['iniciom']);
			$inicioy = trim($_POST['inicioy']);
			$fimd = trim($_POST['fimd']);
			$fimm = trim($_POST['fimm']);
			$fimy = trim($_POST['fimy']);
			$allyear = trim($_POST['allyear']);
			mysql_select_db($database_database, $database);
			$SQL = "INSERT INTO " . $prefix_database . "_eventos (Nome, Descricao, Iniciod, Iniciom, Inicioy, Fimd, Fimm, Fimy, Allyear) VALUES ('$nome', '$desc', '$iniciod', '$iniciom', '$inicioy', '$fimd', '$fimm', '$fimy', '$allyear')";
			$QUERY = mysql_query($SQL) or die(mysql_error());
			echo "Evento criado com sucesso...";
		} //end if ($cria == NULL)
	}
	
	private function act_deletaevento() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_eventos";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if ($_POST['evento' . $dados2['Id']] == "true") {
				$delete = "DELETE FROM " . $prefix_database . "_eventos WHERE Id = '" . $dados2['Id'] . "'";
				$deleteq = mysql_query($delete) or die(mysql_error());
				echo "Evento " . $dados2['Id'] . " - " . $dados2['Nome'] . " foi deletado...<br />";
			} //end if ($_POST['evento' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "Todos Eventos selecionados foram deletados...";
	}
	
	private function act_news() {
	
		require 'conexao.php';
		
		$busca = $_GET['busca'];
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_news";
		$query2 = mysql_query($sql2) or die(mysql_error());
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=news'>
		<input name='cat' type='hidden' id='cat' value='news'>
		<input type='text' size='30' maxlength='100' name='busca'>
		<input type='submit' value='Buscar' />
		</form>";
		echo "<form id='del' name='del' method='post' action='admin.php?cat=news&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		if ($busca == NULL) {
			while ($dados2 = mysql_fetch_assoc($query2)) {
				echo "
				<input type='checkbox' name='news" . $dados2['Id'] . "' value='true' />
				";
				echo "<a href='admin.php?cat=news&action=edit&news=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'] . "</a><br>";
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} else { //else if ($busca == NULL)
			while ($dados2 = mysql_fetch_assoc($query2)) {
				if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0 or strrpos(strtolower(" " . $dados2['Usuario']), strtolower($busca)) != 0) {
					echo "
					<input type='checkbox' name='news" . $dados2['Id'] . "' value='true' />
					";
					echo "<a href='admin.php?cat=news&action=edit&news=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'] . "</a><br>";
				} //end if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0 or strrpos(strtolower(" " . $dados2['Usuario']), strtolower($busca)) != 0)
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} //end if ($busca == NULL)
		echo "</form>";
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=news&action=cria'>	
		<input type='submit' value='Novo' />
		</form>";
	}
	
	private function act_editnews() {
	
		require 'conexao.php';
		
		$news = $_GET['news'];
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			mysql_select_db($database_database, $database);
			$sql2 = "SELECT * FROM " . $prefix_database . "_news WHERE Id ='" . $news . "'";
			$query2 = mysql_query($sql2) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query2);
			mysql_select_db($database_database, $database);
			$sql3 = "SELECT * FROM " . $prefix_database . "_users WHERE Id ='" . $dados2['User'] . "'";
			$query3 = mysql_query($sql3) or die(mysql_error());
			$user = mysql_fetch_assoc($query3);
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=news&action=edit&news=" . $news . "&edit=edit'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Nome</td>
			<td width='322'>
			<input name='newnome' type='text' size='30' maxlength='100' value='" . $dados2['Nome'] . "' id='newnome' />
			</td>
			</tr>
			<tr>
			<td>Categoria</td>
			<td>
			<input name='newcategoria' type='text' size='30' maxlength='100' value='" . $dados2['Categoria'] . "' id='newcategoria' />
			</td>
			</tr>
			<tr>
			<td>News</td>
			<td>
			<textarea name='newnews' cols='50' rows='10' id='newnews'>" . $dados2['News'] . "</textarea>
			</td>
			</tr>
			<tr>
			<td>" . $user['Nome'] . "</td>
			<td>" . $dados2['Data'] . "</td>
			</tr>
			<tr>
			<td><input type='submit' value='Editar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$newnome = trim($_POST['newnome']);
			$newcategoria = trim($_POST['newcategoria']);
			$newnews = trim($_POST['newnews']);
			$stamp = strtotime("-3 hours");
			$data = date(d, $stamp) . "/" . date(m, $stamp) . "/" . date(Y, $stamp);
			mysql_select_db($database_database, $database);
			$update = "UPDATE " . $prefix_database . "_news SET Nome ='" . $newnome . "' WHERE Id ='" . $news . "'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update2 = "UPDATE " . $prefix_database . "_news SET Categoria ='" . $newcategoria . "' WHERE Id ='" . $news . "'";
			$updateq2 = mysql_query($update) or die(mysql_error());
			$update3 = "UPDATE " . $prefix_database . "_news SET News ='" . $newnews . "' WHERE Id ='" . $news . "'";
			$updateq3 = mysql_query($update2) or die(mysql_error());
			$update4 = "UPDATE " . $prefix_database . "_news SET Data ='" . $data . "' WHERE Id ='" . $news . "'";
			$updateq5 = mysql_query($update3) or die(mysql_error());
			echo "News atualizada...";
		} //end if ($edit == NULL)
	}
	
	private function act_crianews() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		if ($cria == NULL) {
			echo "
			<form id='form1' name='form1' method='post' action='admin.php?cat=news&action=cria&cria=cria'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Nome</td>
			<td width='322'>
			<input name='nome' type='text' size='30' maxlength='100' id='nome' />
			</td>
			</tr>
			<tr>
			<td>Categoria</td>
			<td>
			<input name='categoria' type='text' size='30' maxlength='100' id='categoria' />
			</td>
			</tr>
			<tr>
			<td>News</td>
			<td>
			<textarea name='news' cols='50' rows='10' id='news'></textarea>
			</td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='Criar' />
			</td>
			<td>&nbsp;</td>
			</tr>
			</table>
			</form>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
			$nome = trim($_POST['nome']);
			$categoria = trim($_POST['categoria']);
			$news = trim($_POST['news']);
			$stamp = strtotime("-3 hours");
			$data = date(d, $stamp) . "/" . date(m, $stamp) . "/" . date(Y, $stamp);
			$dados = $this->func_dados();
			$user = $dados['Id'];
			mysql_select_db($database_database, $database);
			$SQL = "INSERT INTO " . $prefix_database . "_news (Nome, Categoria, News, User, Data) VALUES ('$nome', '$categoria', '$news', '$user', '$data')";
			$QUERY = mysql_query($SQL) or die(mysql_error());
			echo "News criada com sucesso...";
		} //end if ($cria == NULL)
	}
	
	private function act_deletanews() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_news";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if ($_POST['news' . $dados2['Id']] == "true") {
				$delete = "DELETE FROM " . $prefix_database . "_news WHERE Id = '" . $dados2['Id'] . "'";
				$deleteq = mysql_query($delete) or die(mysql_error());
				echo "News " . $dados2['Id'] . " - " . $dados2['Nome'] . " foi deletada...<br />";
			} //end if ($_POST['news' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "Todas News selecionadas foram deletadas...";
	}
	
	private function act_parc() {
	
		require 'conexao.php';
		
		$busca = $_GET['busca'];
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_parcerias";
		$query2 = mysql_query($sql2) or die(mysql_error());
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=parceria'>
		<input name='cat' type='hidden' id='cat' value='parceria'>
		<input type='text' size='30' maxlength='100' name='busca'>
		<input type='submit' value='Buscar' />
		</form>";
		echo "<form id='del' name='del' method='post' action='admin.php?cat=parceria&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		if ($busca == NULL) {
			while ($dados2 = mysql_fetch_assoc($query2)) {
				echo "
				<input type='checkbox' name='parc" . $dados2['Id'] . "' value='true' />
				";
				echo "<a href='admin.php?cat=parceria&action=edit&parc=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'] . "</a><br>";
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} else { //else if ($busca == NULL)
			while ($dados2 = mysql_fetch_assoc($query2)) {
				if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0) {
					echo "
					<input type='checkbox' name='parc" . $dados2['Id'] . "' value='true' />
					";
					echo "<a href='admin.php?cat=parceria&action=edit&parc=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Nome'] . "</a><br>";
				} //end if (strrpos(strtolower(" " . $dados2['Nome']), strtolower($busca)) != 0)
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} //end if ($busca == NULL)
		echo "</form>";
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=parceria&action=cria'>
		<input type='submit' value='Nova' />
		</form>";
	}
	
	private function act_editparc() {
	
		require 'conexao.php';
		
		$parc = $_GET['parc'];
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			mysql_select_db($database_database, $database);
			$sql2 = "SELECT * FROM " . $prefix_database . "_parcerias WHERE Id ='" . $parc . "'";
			$query2 = mysql_query($sql2) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query2);
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=parceria&action=edit&parc=" . $parc . "&edit=edit'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Nome</td>
			<td width='322'>
			<input name='newnome' type='text' size='30' maxlength='100' value='" . $dados2['Nome'] . "' id='newnome' /></td>
			</tr>
			<tr>
			<td>Link</td>
			<td><input name='newlink' type='text' size='30' maxlength='100' value='" . $dados2['Link'] . "' id='newlink'></td>
			</tr>
			<tr>
			<td>Banner</td>
			<td><input name='newbanner' type='text' size='30' maxlength='100' value='" . $dados2['Banner'] . "' id='newbanner'></td>
			</tr>
			<tr>
			<td>Categoria</td>
			<td><input name='newcategoria' type='text' size='30' maxlength='100' value='" . $dados2['Categoria'] . "' id='newcategoria'></td>
			</tr>
			<tr>
			<td>Descrição</td>
			<td><textarea name='newdescricao' cols='50' rows='10' id='newdescricao'>" . $dados2['Descricao'] . "</textarea></td>
			</tr>
			<tr>
			<td><input type='submit' value='Editar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$newnome = trim($_POST['newnome']);
			$newlink = trim($_POST['newlink']);
			$newbanner = trim($_POST['newbanner']);
			$newcategoria = trim($_POST['newcategoria']);
			$newdescricao = trim($_POST['newdescricao']);
			mysql_select_db($database_database, $database);
			$update = "UPDATE " . $prefix_database . "_parcerias SET Nome ='" . $newnome . "' WHERE Id ='" . $parc . "'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update2 = "UPDATE " . $prefix_database . "_parcerias SET Link ='" . $newlink . "' WHERE Id ='" . $parc . "'";
			$updateq2 = mysql_query($update2) or die(mysql_error());
			$update3 = "UPDATE " . $prefix_database . "_parcerias SET Banner ='" . $newbanner . "' WHERE Id ='" . $parc . "'";
			$updateq3 = mysql_query($update3) or die(mysql_error());
			$update4 = "UPDATE " . $prefix_database . "_parcerias SET Categoria ='" . $newcategoria . "' WHERE Id ='" . $parc . "'";
			$updateq4 = mysql_query($update4) or die(mysql_error());
			$update5 = "UPDATE " . $prefix_database . "_parcerias SET Descricao ='" . $newdescricao . "' WHERE Id ='" . $parc . "'";
			$updateq5 = mysql_query($update5) or die(mysql_error());
			echo "Parceria atualizada...";
		} //end if ($edit == NULL)
	}
	
	private function act_criaparc() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		if ($cria == NULL) {
			echo "
			<form id='form1' name='form1' method='post' action='admin.php?cat=parceria&action=cria&cria=cria'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Nome</td>
			<td width='322'><input name='nome' type='text' size='30' maxlength='100' id='nome' /></td>
			</tr>
			<tr>
			<td>Link</td>
			<td><input name='link' type='text' size='30' maxlength='100' id='link' /></td>
			</tr>
			<tr>
			<td>Banner</td>
			<td><input name='banner' type='text' size='30' maxlength='100' id='banner' /></td>
			</tr>
			<tr>
			<td>Categoria</td>
			<td><input name='categoria' type='text' size='30' maxlength='100' id='categoria' /></td>
			</tr>
			<tr>
			<td>Descrição</td>
			<td><textarea name='descricao' cols='50' rows='10' id='descricao'></textarea></td>
			</tr>
			<tr>
			<td><input type='submit' value='Criar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
			$nome = trim($_POST['nome']);
			$link = trim($_POST['link']);
			$banner = trim($_POST['banner']);
			$categoria = trim($_POST['categoria']);
			$descricao = trim($_POST['descricao']);
			mysql_select_db($database_database, $database);
			$SQL = "INSERT INTO " . $prefix_database . "_parcerias (Nome, Link, Banner, Categoria, Descricao) VALUES ('$nome', '$link', '$banner', '$categoria', '$descricao')";
			$QUERY = mysql_query($SQL) or die(mysql_error());
			echo "Parceria criada com sucesso...";
		} //end if ($cria == NULL)
	}
	
	private function act_deletaparc() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_parcerias";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if ($_POST['parc' . $dados2['Id']] == "true") {
				$delete = "DELETE FROM " . $prefix_database . "_parcerias WHERE Id = '" . $dados2['Id'] . "'";
				$deleteq = mysql_query($delete) or die(mysql_error());
				echo "Parceria " . $dados2['Id'] . " - " . $dados2['Nome'] . " foi deletada...<br />";
			} //end if ($_POST['parc' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "Todas Parcerias selecionadas foram deletadas...";
	}
	
	private function act_layout() {
	
		require 'conexao.php';
		
		$lay = $this->load_layout();
		echo "<form id='del' name='del' method='post' action='admin.php?cat=layout&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		foreach (glob("layouts/*") as $layoutname) {
			$layoutname2 = explode("/", $layoutname);
			$layname = $layoutname2[1];
			echo "
			<input type='checkbox' name='layout" . $layname . "' value='true' />
			";
			echo "<a href='admin.php?cat=layout&action=edit&lay=" . $layname . "'>" . $layname;
			if ($lay['Nome'] == $layname) { echo " - Padrão"; }
			echo "</a><br>";
		} //end foreach (glob("layouts/*.layout.php") as $layoutname)
		echo "</form>";
	}
	
	private function act_editlayout() {
	
		require 'conexao.php';
		
		$lay = $_GET['lay'];
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			$dadoslay = $this->load_layout();
			$tags = get_meta_tags("layouts/" . $lay . "/admin.layout.php");
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=layout&action=edit&lay=" . $lay . "&edit=edit'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Layout</td>
			<td width='322'>" . $lay . " - by " . $tags['author'] . "</td>
			</tr>
			<tr>
			<td>Padrão</td>
			<td>
			<input type='checkbox' name='padrao' value='true'";
			if ($lay == $dadoslay['Nome']) { echo "checked='checked'"; }
			echo "/>
			</td>
			</tr>
			<tr>
			<td>CSS</td>
			<td>
			<textarea name='csslay' cols='50' rows='10' id='csslay'>";
			echo file_get_contents("layouts/" . $lay . "/style.css");
			echo "</textarea>
			</td>
			</tr>
			<tr>
			<td>Admin</td>
			<td>
			<textarea name='adminlay' cols='50' rows='10' id='adminlay'>";
			echo file_get_contents("layouts/" . $lay . "/admin.layout.php");
			echo "</textarea>
			</td>
			</tr>
			<tr>
			<td>News</td>
			<td>
			<textarea name='newslay' cols='50' rows='10' id='newslay'>";
			echo file_get_contents("layouts/" . $lay . "/news.layout.php");
			echo "</textarea>
			</td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='Editar' />
			</td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$padrao = $_POST['padrao'];
			$newcsslay = stripslashes($_POST['csslay']);
			$newadminlay = stripslashes($_POST['adminlay']);
			$newnewslay = stripslashes($_POST['newslay']);
			if ($padrao == "true") {
				$update = "UPDATE " . $prefix_database . "_config SET Laynome ='" . $lay . "' WHERE Id ='1'";
				$updateq = mysql_query($update) or die(mysql_error());
			} //end if ($padrao == "true")
			echo "Layout modificado...<BR>";
			file_put_contents("layouts/" . $lay . "/style.css", $newcsslay);
			echo "CSS atualizado...<br />";
			file_put_contents("layouts/" . $lay . "/admin.layout.php", $newadminlay);
			echo "Admin Layout atualizado...<br />";
			file_put_contents("layouts/" . $lay . "/news.layout.php", $newnewslay);
			echo "News Layout atualizado...";
		} //end if ($edit == NULL)
	}
	
	private function act_deletalayout() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$lay = $this->load_layout();
		foreach (glob("layouts/*") as $layoutname) {
			$layoutname2 = explode("/", $layoutname);
			$layname = $layoutname2[1];
			if ($layname != $lay['Nome']) {
				if ($_POST['layout' . $layname] == "true") {
					foreach (glob("layouts/" . $layname . "/*.*") as $dellay) {
						unlink($dellay);
					} //end foreach (glob("layouts/" . $layname) as $dellay)
					rmdir("layouts/" . $layname);
					echo "Layout " . $layname . " foi deletado...<br />";
				} //end if ($layname != $dados2['Nome'])
			} //end if ($_POST['layout' . $layname])
		} //end foreach (glob("layouts/*.layout.php" as $layoutname))
		echo "Todos Layouts selecionados foram deletados...";
	}
	
	private function act_config() {
	
		require 'conexao.php';
		
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			mysql_select_db($database_database, $database);
			$sql2 = "SELECT * FROM " . $prefix_database . "_config WHERE Id ='1'";
			$query2 = mysql_query($sql2) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query2);
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=config&edit=edit'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Fuso Horário</td>
			<td width='322'>
			<input name='fuso' type='text' size='5' maxlength='3' value='" . $dados2['Fuso'] . "' id='fuso' /></td>
			</tr>
			<tr>
			<td>Local</td>
			<td><input name='local' type='text' size='30' maxlength='100' value='" . $dados2['Local'] . "' id='local' /></td>
			</tr>
			<tr>
			<td>Manutenção</td>
			<td><input type='checkbox' name='manutencao' value='1'";
			if ($dados2['Manutencao'] == 1) {
				echo "checked='checked'";
			} //end ($dados2['Manutencao'] == 1)
			echo "/></td>
			</tr>
			<tr>
			<td>Nome do Cookie</td>
			<td><input name='cookienome' type='text' size='30' maxlength='100' value='" . $dados2['Cookienome'] . "' id='cookienome' /></td>
			</tr>
			<tr>
			<td>Tempo do Cookie</td>
			<td><input name='cookietempo' type='text' size='30' maxlength='100' value='" . $dados2['Cookietempo'] . "' id='cookietempo' /></td>
			</tr>
			<tr>
			<td>Cookie Seguro</td>
			<td><input type='checkbox' name='cookieseguro' value='1'";
			if ($dados2['Cookieseguro'] == 1) {
				echo "checked='checked'";
			} //end ($dados2['Cookieseguro'] == 1)
			echo "/></td>
			</tr>
			<tr>
			<td><input type='submit' value='Editar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$fuso = trim($_POST['fuso']);
			$local = trim($_POST['local']);
			$manutencao = $_POST['manutencao'];
			mysql_select_db($database_database, $database);
			$update = "UPDATE " . $prefix_database . "_config SET Fuso ='" . $fuso . "' WHERE Id ='1'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update = "UPDATE " . $prefix_database . "_config SET Local ='" . $local . "' WHERE Id ='1'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update = "UPDATE " . $prefix_database . "_config SET Manutencao ='" . $manutencao . "' WHERE Id ='1'";
			$updateq = mysql_query($update) or die(mysql_error());
			echo "Configurações auteradas...";
		} //end if ($edit == NULL)
	}
	
	private function act_upload() {
	
		require 'conexao.php';
		
		echo "<form id='del' name='del' method='post' action='admin.php?cat=upload&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		foreach (glob("uploads/*") as $uploadname) {
			$uploadname2 = explode("/", $uploadname);
			$upname = $uploadname2[1];
			echo "<input type='checkbox' name='upload" . $upname . "' value='true' />";
			echo $upname . "<br>";
		} //end foreach (glob("uploads/*") as $uploadname)
		echo "</form>";
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=upload&action=cria'>
		<input type='submit' value='Novo' />
		</form>";
	}
	
	private function act_criaupload() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		if ($cria == NULL) {
			echo "
			<form id='form1' name='form1' method='post' enctype='multipart/form-data' action='admin.php?cat=upload&action=cria&cria=cria'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='61'>Arquivo</td>
			<td width='322'><input name='arquivo' size='30' maxlength='100' type='file' id='arquivo'></td>
			</tr>
			<tr>
			<td><input type='submit' value='Upload' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
			$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
			if ($arquivo) {
				if (!file_exists("uploads/" . $arquivo["name"])) {
					move_uploaded_file($arquivo["tmp_name"], "uploads/" . $arquivo["name"]);
					chmod($imagem_dir, 0755);
					echo "Upload feito com sucesso...";
				} else { //else if (!file_exists("uploads/" . $arquivo["name"])
					echo "Já existe um arquivo com este nome...";
				} //end if (!file_exists("uploads/" . $arquivo["name"])
			} else { //else if ($arquivo)
				echo "Seleciona um arquivo...";
			} //end if ($arquivo)
		} //end if ($cria == NULL)
	}
	
	private function act_deletaupload() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		foreach (glob("uploads/*") as $uploadname) {
			$uploadname2 = explode("/", $uploadname);
			$upname = $uploadname2[1];
			echo "upload" . $upname;
			if ($_POST['upload' . $upname] == "true") {
				unlink("uploads/" . $upname);
				echo "Upload " . $upname . " foi deletado...<br />";
			} //end if ($_POST['upload' . $upname] == "true")
		} //end foreach (glob("uploads/*") as $uploadname)
		echo "Todos Uploads selecionados foram deletados...";
	}
	
	private function act_enquete() {
	
		require 'conexao.php';
		
		$busca = $_GET['busca'];
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_enquetes";
		$query2 = mysql_query($sql2) or die(mysql_error());
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=enquete'>
		<input name='cat' type='hidden' id='cat' value='enquete'>
		<input type='text' size='30' maxlength='100' name='busca'>
		<input type='submit' value='Buscar' />
		</form>";
		echo "<form id='del' name='del' method='post' action='admin.php?cat=enquete&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		if ($busca == NULL) {
			while ($dados2 = mysql_fetch_assoc($query2)) {
				echo "
				<input type='checkbox' name='enquete" . $dados2['Id'] . "' value='true' />
				";
				echo "<a href='admin.php?cat=enquete&action=edit&enquete=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Pergunta'] . "</a><br>";
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} else { //else if ($busca == NULL)
			while ($dados2 = mysql_fetch_assoc($query2)) {
				if (strrpos(strtolower(" " . $dados2['Pergunta']), strtolower($busca)) != 0) {
					echo "
					<input type='checkbox' name='enquete" . $dados2['Id'] . "' value='true' />
					";
					echo "<a href='admin.php?cat=enquete&action=edit&enquete=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Pergunta'] . "</a><br>";
				} //end if (strrpos(strtolower(" " . $dados2['Pergunta']), strtolower($busca)) != 0)
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} //end if ($busca == NULL)
		echo "</form>";
		echo "<form id='novo' name='novo' method='post' action='admin.php?cat=enquete&action=cria'>
		<input type='submit' value='Nova' />
		</form>";
	}
	
	private function act_editenquete() {
	
		require 'conexao.php';
		
		$enquete = $_GET['enquete'];
		$edit = $_GET['edit'];
		if ($edit == NULL) {
			mysql_select_db($database_database, $database);
			$sql2 = "SELECT * FROM " . $prefix_database . "_enquetes WHERE Id ='" . $enquete . "'";
			$query2 = mysql_query($sql2) or die(mysql_error());
			$dados2 = mysql_fetch_assoc($query2);
			echo "<form id='form1' name='form1' method='post' action='admin.php?cat=enquete&action=edit&enquete=" . $enquete . "&edit=edit'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='70'>Pergunta</td>
			<td width='313'>
			<input name='newpergunta' type='text' size='30' maxlength='100' value='" . $dados2['Pergunta'] . "' id='newpergunta' /></td>
			</tr>
			<tr>
			<td>Resposta 1</td>
			<td><input name='newresp1' type='text' size='30' maxlength='100' value='" . $dados2['Resp1'] . "' id='newresp1'>>
			<input name='newnum1' type='text' size='10' maxlength='100' value='" . $dados2['Num1'] . "' id='newnum1'></td>
			</tr>
			<tr>
			<td>Resposta 2</td>
			<td><input name='newresp2' type='text' size='30' maxlength='100' value='" . $dados2['Resp2'] . "' id='newresp2'>>
			<input name='newnum2' type='text' size='10' maxlength='100' value='" . $dados2['Num2'] . "' id='newnum2'></td>
			</tr>
			<tr>
			<td>Resposta 3</td>
			<td><input name='newresp3' type='text' size='30' maxlength='100' value='" . $dados2['Resp3'] . "' id='newresp3'>>
			<input name='newnum3' type='text' size='10' maxlength='100' value='" . $dados2['Num3'] . "' id='newnum3'></td>
			</tr>
			<tr>
			<td>Resposta 4</td>
			<td><input name='newresp4' type='text' size='30' maxlength='100' value='" . $dados2['Resp4'] . "' id='newresp4'>>
			<input name='newnum4' type='text' size='10' maxlength='100' value='" . $dados2['Num4'] . "' id='newnum4'></td>
			</tr>
			<tr>
			<td>Resposta 5</td>
			<td><input name='newresp5' type='text' size='30' maxlength='100' value='" . $dados2['Resp5'] . "' id='newresp5'>>
			<input name='newnum5' type='text' size='10' maxlength='100' value='" . $dados2['Num5'] . "' id='newnum5'></td>
			</tr>
			<tr>
			<td><input type='submit' value='Editar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($edit == "edit") { //elseif if ($edit == NULL)
			$newpergunta = trim($_POST['newpergunta']);
			$newresp1 = trim($_POST['newresp1']);
			$newresp2 = trim($_POST['newresp2']);
			$newresp3 = trim($_POST['newresp3']);
			$newresp4 = trim($_POST['newresp4']);
			$newresp5 = trim($_POST['newresp5']);
			$newnum1 = trim($_POST['newnum1']);
			$newnum2 = trim($_POST['newnum2']);
			$newnum3 = trim($_POST['newnum3']);
			$newnum4 = trim($_POST['newnum4']);
			$newnum5 = trim($_POST['newnum5']);
			mysql_select_db($database_database, $database);
			$update = "UPDATE " . $prefix_database . "_enquetes SET Pergunta ='" . $newpergunta . "' WHERE Id ='" . $enquete . "'";
			$updateq = mysql_query($update) or die(mysql_error());
			$update2 = "UPDATE " . $prefix_database . "_enquetes SET Resp1 ='" . $newresp1 . "' WHERE Id ='" . $enquete . "'";
			$updateq2 = mysql_query($update2) or die(mysql_error());
			$update3 = "UPDATE " . $prefix_database . "_enquetes SET Resp2 ='" . $newresp2 . "' WHERE Id ='" . $enquete . "'";
			$updateq3 = mysql_query($update3) or die(mysql_error());
			$update4 = "UPDATE " . $prefix_database . "_enquetes SET Resp3 ='" . $newresp3 . "' WHERE Id ='" . $enquete . "'";
			$updateq4 = mysql_query($update4) or die(mysql_error());
			$update5 = "UPDATE " . $prefix_database . "_enquetes SET Resp4 ='" . $newresp4 . "' WHERE Id ='" . $enquete . "'";
			$updateq5 = mysql_query($update5) or die(mysql_error());
			$update6 = "UPDATE " . $prefix_database . "_enquetes SET Resp5 ='" . $newresp5 . "' WHERE Id ='" . $enquete . "'";
			$updateq6 = mysql_query($update6) or die(mysql_error());
			$update7 = "UPDATE " . $prefix_database . "_enquetes SET Num1 ='" . $newnum1 . "' WHERE Id ='" . $enquete . "'";
			$updateq7 = mysql_query($update7) or die(mysql_error());
			$update8 = "UPDATE " . $prefix_database . "_enquetes SET Num2 ='" . $newnum2 . "' WHERE Id ='" . $enquete . "'";
			$updateq8 = mysql_query($update8) or die(mysql_error());
			$update9 = "UPDATE " . $prefix_database . "_enquetes SET Num3 ='" . $newnum3 . "' WHERE Id ='" . $enquete . "'";
			$updateq9 = mysql_query($update9) or die(mysql_error());
			$update10 = "UPDATE " . $prefix_database . "_enquetes SET Num4 ='" . $newnum4 . "' WHERE Id ='" . $enquete . "'";
			$updateq10 = mysql_query($update10) or die(mysql_error());
			$update11 = "UPDATE " . $prefix_database . "_enquetes SET Num5 ='" . $newnum5 . "' WHERE Id ='" . $enquete . "'";
			$updateq11 = mysql_query($update11) or die(mysql_error());
			echo "Enquete atualizada...";
		} //end if ($edit == NULL)
	}
	
	private function act_criaenquete() {
	
		require 'conexao.php';
		
		$cria = $_GET['cria'];
		if ($cria == NULL) {
			echo "
			<form id='form1' name='form1' method='post' action='admin.php?cat=enquete&action=cria&cria=cria'>
			<table width='387' border='0' cellspacing='0'>
			<tr>
			<td width='70'>Pergunta</td>
			<td width='313'><input name='pergunta' type='text' size='30' maxlength='100' id='pergunta' /></td>
			</tr>
			<tr>
			<td>Resposta 1</td>
			<td><input name='resp1' type='text' size='30' maxlength='100' id='resp1' /></td>
			</tr>
			<tr>
			<td>Resposta 2</td>
			<td><input name='resp2' type='text' size='30' maxlength='100' id='resp2' /></td>
			</tr>
			<tr>
			<td>Resposta 3</td>
			<td><input name='resp3' type='text' size='30' maxlength='100' id='resp3' /></td>
			</tr>
			<tr>
			<td>Resposta 4</td>
			<td><input name='resp4' type='text' size='30' maxlength='100' id='resp4' /></td>
			</tr>
			<tr>
			<td>Resposta 5</td>
			<td><input name='resp5' type='text' size='30' maxlength='100' id='resp5' /></td>
			</tr>
			<tr>
			<td><input type='submit' value='Criar' /></td>
			</tr>
			</table>
			</form>";
		} elseif ($cria == "cria") { //elseif if ($cria == NULL)
			$pergunta = trim($_POST['pergunta']);
			$resp1 = trim($_POST['resp1']);
			$resp2 = trim($_POST['resp2']);
			$resp3 = trim($_POST['resp3']);
			$resp4 = trim($_POST['resp4']);
			$resp5 = trim($_POST['resp5']);
			mysql_select_db($database_database, $database);
			$SQL = "INSERT INTO " . $prefix_database . "_enquetes (Pergunta, Resp1, Resp2, Resp3, Resp4, Resp5) VALUES ('$pergunta', '$resp1', '$resp2', '$resp3', '$resp4', '$resp5')";
			$QUERY = mysql_query($SQL) or die(mysql_error());
			echo "Enquete criada com sucesso...";
		} //end if ($cria == NULL)
	}
	
	private function act_deletaenquete() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_enquetes";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if ($_POST['enquete' . $dados2['Id']] == "true") {
				$delete = "DELETE FROM " . $prefix_database . "_enquetes WHERE Id = '" . $dados2['Id'] . "'";
				$deleteq = mysql_query($delete) or die(mysql_error());
				echo "Enquete " . $dados2['Id'] . " - " . $dados2['Pergunta'] . " foi deletada...<br />";
			} //end if ($_POST['enquete' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "Todas Enquetes selecionadas foram deletadas...";
	}

	private function act_contato() {
	
		require 'conexao.php';
		
		$busca = $_GET['busca'];
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_contato";
		$query2 = mysql_query($sql2) or die(mysql_error());
		echo "<form id='busca' name='busca' method='get' action='admin.php?cat=contato'>
		<input name='cat' type='hidden' id='cat' value='enquete'>
		<input type='text' size='30' maxlength='100' name='busca'>
		<input type='submit' value='Buscar' />
		</form>";
		echo "<form id='del' name='del' method='post' action='admin.php?cat=contato&action=deleta'>
		<input type='submit' value='Deletar' />
		<br /><br />";
		if ($busca == NULL) {
			while ($dados2 = mysql_fetch_assoc($query2)) {
				echo "
				<input type='checkbox' name='contato" . $dados2['Id'] . "' value='true' />
				";
				echo "<a href='admin.php?cat=contato&action=edit&contato=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Assunto'] . "</a><br>";
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} else { //else if ($busca == NULL)
			while ($dados2 = mysql_fetch_assoc($query2)) {
				if (strrpos(strtolower(" " . $dados2['Assunto']), strtolower($busca)) != 0) {
					echo "
					<input type='checkbox' name='contato" . $dados2['Id'] . "' value='true' />
					";
					echo "<a href='admin.php?cat=contato&action=edit&contato=" . $dados2['Id'] . "'>" . $dados2['Id'] . " - " . $dados2['Assunto'] . "</a><br>";
				} //end if (strrpos(strtolower(" " . $dados2['Assunto']), strtolower($busca)) != 0)
			} //end while ($dados2 = mysql_fetch_assoc($query2))
		} //end if ($busca == NULL)
		echo "</form>";
	}
	
	private function act_vercontato() {
	
		require 'conexao.php';
		
		$contato = $_GET['contato'];
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_contato WHERE Id ='" . $contato . "'";
		$query2 = mysql_query($sql2) or die(mysql_error());
		$dados2 = mysql_fetch_assoc($query2);
		echo "<form id='form1' name='form1' method='post' action='admin.php?cat=enquete&action=deleta'>
		<input name='contato" . $dados2['Id'] . "' type='hidden' id='contato" . $dados2['Id'] . "' value='true'>
		<table width='387' border='0' cellspacing='0'>
		<tr>
		<td width='70'>Assunto</td>
		<td width='313'>" . $dados2['Assunto'] . "</td>
		</tr>
		<tr>
		<td>Usuário</td>
		<td>" . $dados2['User'] . "</td>
		</tr>
		<tr>
		<td>Menssagem</td>
		<td>" . $dados2['Texto'] . "</td>
		</tr>
		<tr>
		<td>Data</td>
		<td>" . $dados2['Data'] . "</td>
		</tr>
		<tr>
		<td><input type='submit' value='Deletar' /></td>
		</tr>
		</table>
		</form>";
	}
	
	private function act_deletacontato() {
	
		require 'conexao.php';
		
		mysql_select_db($database_database, $database);
		$sql2 = "SELECT * FROM " . $prefix_database . "_contato";
		$query2 = mysql_query($sql2) or die(mysql_error());
		while ($dados2 = mysql_fetch_assoc($query2)) {
			if ($_POST['contato' . $dados2['Id']] == "true") {
				$delete = "DELETE FROM " . $prefix_database . "_contato WHERE Id = '" . $dados2['Id'] . "'";
				$deleteq = mysql_query($delete) or die(mysql_error());
				echo "Menssagem de Contato " . $dados2['Id'] . " - " . $dados2['Assunto'] . " foi deletada...<br />";
			} //end if ($_POST['contato' . $dados2['Id']])
		} //end while ($dados2 = mysql_fetch_assoc($query2))
		echo "Todas Menssagens de Contato selecionadas foram deletadas...";
	}
	
	private function act_logout() {

		@session_destroy();
		@session_unset();
		echo "Logout efetuado com sucesso...";
	}
	
}//end class Admin
?>