<?php
/*
 * @version $Id$
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2006 by the INDEPNET Development Team.
 
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------

 LICENSE

	This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
*/

// Based on:
// IRMA, Information Resource-Management and Administration
// Christian Bauer 
// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

function showPasswordForm($target,$name) {

	global $cfg_glpi, $lang;
	
	$user = new User();
	if ($user->getFromDBbyName($name)){
		echo "<form method='post' action=\"$target\">";
		echo "<div align='center'>&nbsp;<table class='tab_cadre' cellpadding='5' width='30%'>";
		echo "<tr><th colspan='2'>".$lang["setup"][11]." '".$user->fields["name"]."':</th></tr>";
		echo "<tr><td width='100%' align='center' class='tab_bg_1'>";
		echo "<input type='password' name='password' size='10'>";
		echo "</td><td align='center' class='tab_bg_2'>";
		echo "<input type='hidden' name='name' value=\"".$name."\">";
		echo "<input type='submit' name='changepw' value=\"".$lang["buttons"][14]."\" class='submit'>";
		echo "</td></tr>";
		echo "</table></div>";
		echo "</form>";
	}
}








function showLangSelect($target) {

	global $cfg_glpi, $lang;
	
	$l = $_SESSION["glpilanguage"]; 
	
	echo "<form method='post' action=\"$target\">";
	echo "<div align='center'>&nbsp;<table class='tab_cadre' cellpadding='5' width='30%'>";
	echo "<tr><th colspan='2'>".$lang["setup"][41].":</th></tr>";
	echo "<tr><td width='100%' align='center' class='tab_bg_1'>";
	echo "<select name='language'>";

	while (list($cle)=each($cfg_glpi["languages"])){
		echo "<option value=\"".$cle."\"";
			if ($l==$cle) { echo " selected"; }
		echo ">".$cfg_glpi["languages"][$cle][0]." ($cle)";
	}
	echo "</select>";
	echo "</td>";
	echo "<td align='center' class='tab_bg_2'>";
	echo "<input type='submit' name='changelang' value=\"".$lang["buttons"][14]."\" class='submit'>";
	echo "<input type='hidden' name='ID' value=\"".$_SESSION["glpiID"]."\">";
	echo "</td></tr>";
	echo "</table></div>";
	echo "</form>";
}

function showSortForm($target) {

	global $cfg_glpi, $lang;
	
	$order = $_SESSION["glpitracking_order"];
	
	echo "<div align='center'>\n";
	echo "<form method='post' action=\"$target\">\n";

	echo "<table class='tab_cadre' cellpadding='5' width='30%'>\n";
	echo "<tr><th colspan='2'>".$lang["setup"][40]."</th></tr>\n";
	echo "<tr><td width='100%' align='center' class='tab_bg_1'>\n";
	echo "<select name='tracking_order'>\n";
	echo "<option value=\"yes\"";
	if ($order=="yes") { echo " selected"; }	
	echo ">".$lang["choice"][1];
	echo "<option value=\"no\"";
	if ($order=="no") { echo " selected"; }
	echo ">".$lang["choice"][0];
	echo "</select>\n";
	echo "</td>\n";
	echo "<td align='center' class='tab_bg_2'>\n";
	echo "<input type='hidden' name='ID' value=\"".$_SESSION["glpiID"]."\">";
	echo "<input type='submit' name='updatesort' value=\"".$lang["buttons"][14]."\" class='submit'>\n";
	echo "</td></tr>\n";
	echo "</table>";
	echo "</form>\n";

	echo "</div>\n";
}

function showAddExtAuthUserForm($target){
	global $lang;
	
	if (!haveRight("user","w")) return false;


	echo "<div align='center'>\n";
	echo "<form method='get' action=\"$target\">\n";

	echo "<table class='tab_cadre' cellpadding='5'>\n";
	echo "<tr><th colspan='3'>".$lang["setup"][126]."</th></tr>\n";
	echo "<tr class='tab_bg_1'><td>".$lang["login"][6]."</td>\n";
	echo "<td>";
	echo "<input type='text' name='login'>";
	echo "</td>";
	echo "<td align='center' class='tab_bg_2' rowspan='2'>\n";
	echo "<input type='hidden' name='ext_auth' value='1'>\n";
	echo "<input type='submit' name='add_ext_auth' value=\"".$lang["buttons"][8]."\" class='submit'>\n";
	echo "</td></tr>\n";
	
	echo "</table>";
	echo "</form>\n";

	echo "</div>\n";
	
}

function dropdownUserType($myname,$value="post-only"){
		echo "<select name='$myname' >";
		echo "<option value=\"post-only\"";
		if ($value=="post-only") { echo " selected"; }
		echo ">Post Only</option>";
		echo "<option value=normal";
		if ($value=="normal") { echo " selected"; }
		echo ">Normal</option>";
		echo "<option value='admin'";
		if ($value=="admin") { echo " selected"; }
		echo ">Admin</option>";
		echo "<option value='super-admin'";
		if ($value=="super-admin") { echo " selected"; }
		echo ">Super-Admin</option>";
		echo "</select>";
	
}

function useAuthExt(){
global $cfg_glpi;	
return (!empty($cfg_glpi["imap_auth_server"])||!empty($cfg_glpi["ldap_host"])||!empty($cfg_glpi["cas_host"]));
}

/**
*  show onglet for Users
*
* @param 
* @param 
* @param 
* @return nothing
*/
function showUsersTitle($target,$actif) {
	global $lang, $HTMLRel;

	echo "<div align='center'><table border='0'><tr>";
	echo "<td><a  class='icon_consol' href='".$target."&onglet=tracking'><b>".$lang["title"][24]."</b></a>";
	echo "</td>";
	echo "<td><a class='icon_consol' href='".$target."&onglet=hardware'>".$lang["common"][1]."</a></td>";
	echo "</tr></table></div><br>";
}

function showDeviceUser($ID){
	global $db,$cfg_glpi, $lang, $HTMLRel,$LINK_ID_TABLE,$INFOFORM_PAGES;

	$group_where="";
	$groups=array();
	$query="SELECT glpi_users_groups.FK_groups, glpi_groups.name FROM glpi_users_groups LEFT JOIN glpi_groups ON (glpi_groups.ID = glpi_users_groups.FK_groups) WHERE glpi_users_groups.FK_users='$ID';";
	$result=$db->query($query);
	if ($db->numrows($result)>0){
		while ($data=$db->fetch_array($result)){
			$group_where=" OR FK_groups = '".$data["FK_groups"]."' ";
			$groups[$data["FK_groups"]]=$data["name"];
		}
	}
	
	
	$ci=new CommonItem();
	echo "<div align='center'><table class='tab_cadre'><tr><th>".$lang["common"][17]."</th><th>".$lang["common"][16]."</th><th>&nbsp;</th></tr>";
	
	foreach ($cfg_glpi["linkuser_type"] as $type){
		$query="SELECT * from ".$LINK_ID_TABLE[$type]." WHERE FK_users='$ID' $group_where";
		$result=$db->query($query);
		if ($db->numrows($result)>0){
			$ci->setType($type);
			$type_name=$ci->getType();
			$cansee=haveTypeRight($type,"r");
			while ($data=$db->fetch_array($result)){
				$link=$data["name"];
				if ($cansee) $link="<a href='".$cfg_glpi["root_doc"]."/".$INFOFORM_PAGES[$type]."?ID=".$data["ID"]."'>".$link.($cfg_glpi["view_ID"]?" (".$data["ID"].")":"")."</a>";
				$linktype="";
				if ($data["FK_users"]==$ID)
					$linktype.=$lang["common"][34];
				if (isset($groups[$data["FK_groups"]])){
					if (!empty($linktype)) $linktype.=" / ";
					$linktype.=$lang["common"][35]." ".$groups[$data["FK_groups"]];
				}
				echo "<tr class='tab_bg_1'><td>$type_name</td><td>$link</td><td>$linktype</td></tr>";
			}
		}

	}
	echo "</table></div>";
}

function showGroupAssociated($ID){
	global $db,$cfg_glpi, $lang,$HTMLRel;

	if (!haveRight("user","r")||!haveRight("group","r"))	return false;

	$canedit=haveRight("user","w");
	
	$nb_per_line=5;

	echo "<div align='center'><table class='tab_cadre'><tr><th colspan='$nb_per_line'>".$lang["Menu"][36]."</th></tr>";
	$query="SELECT glpi_groups.* from glpi_users_groups LEFT JOIN glpi_groups ON (glpi_groups.ID = glpi_users_groups.FK_groups) WHERE glpi_users_groups.FK_users='$ID' ORDER BY glpi_groups.name";
	
	$result=$db->query($query);
	if ($db->numrows($result)>0){
		$i=0;
		
		while ($data=$db->fetch_array($result)){
			if ($i%$nb_per_line==0) {
				if ($i!=0) echo "</tr>";
				echo "<tr class='tab_bg_1'>";
			}

			echo "<td><a href='".$cfg_glpi["root_doc"]."/front/group.form.php?ID=".$data["ID"]."'>".$data["name"].($cfg_glpi["view_ID"]?" (".$data["ID"].")":"")."</a>";
			echo "&nbsp;";
			if ($canedit)
				echo "<a href='".$_SERVER["PHP_SELF"]."?deleteuser=deleteuser&amp;gID=$ID&amp;ID=".$data["ID"]."'><img src='".$HTMLRel."pics/delete.png' alt='".$lang["buttons"][6]."'></a>";
			
			echo "</td>";
			$i++;
		}
		while ($i%$nb_per_line!=0){
			echo "<td>&nbsp;</td>";
			$i++;
		}
		echo "</tr>";
	}
	
	echo "</table></div><br>";

	if ($canedit){
		echo "<div align='center'><form method='post' action=\"".$cfg_glpi["root_doc"]."/front/group.form.php\">";
		echo "<table  class='tab_cadre_fixe'>";
	
		echo "<tr class='tab_bg_1'><th colspan='2'>".$lang["setup"][604]."</tr><tr><td class='tab_bg_2' align='center'>";
		echo "<input type='hidden' name='FK_users' value='$ID'>";
		dropdownValue("glpi_groups","FK_groups",0);
		echo "</td><td align='center' class='tab_bg_2'>";
		echo "<input type='submit' name='adduser' value=\"".$lang["buttons"][8]."\" class='submit'>";
		echo "</td></tr>";
	
		echo "</table></form></div>";
	}

}


?>
