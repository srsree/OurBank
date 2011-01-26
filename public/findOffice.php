<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/

/**to fil sub office select box based on any changes in office type*/
$country=intval($_GET['office_id']);
$hostname = "localhost";
$database = "newbank";
$username = "newbank";
$password = "new_bank";
$conn = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $conn);

$quer=mysql_query("SELECT * FROM  ourbank_officenames where (parentoffice_id = '$country') && (recordstatus_id = 3 || recordstatus_id = 1)"); 

?>
<select name='subOffice1'  id="subOffice1" class="txt_put">
<option value=''>Select one</option>
<? while($noticia=mysql_fetch_array($quer)) 
					{ ?>

<option value=<?=$noticia["office_id"]?>><?=$noticia["office_name"]?>(<?=$noticia["office_id"]?>)</option>
<? } ?>
</select><b class="star">*</b>