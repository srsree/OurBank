
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
 



      function displayRow(){
	var row = document.getElementById("create_new");
	if (row.style.display == 'none') row.style.display = '';
	}

	function onEdit(id,transaction_type,payment_type,member_type)
	{
	var row1 = document.getElementById("edit");
	if (row1.style.display == 'none') row1.style.display = '';
	
	document.myform.acc_id.value=id;
	document.myform.transaction_typeE.value=transaction_type;
	document.myform.payment_typeE.value=payment_type;
	document.myform.member_typeE.value=member_type;
	}