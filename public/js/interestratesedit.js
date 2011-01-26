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



function addInputEDIT(divName,path){
          var newdiv = document.createElement('font');
          newdiv.innerHTML =  "<div id='row1"+counter+"'> <table  id='hor-minimalist-b'><TR><TD><input size='10'  type='text' name='start_range[]'></TD><TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size='10' type='text' name='end_range[]'></TD><TD>&nbsp;&nbsp;&nbsp;&nbsp;<input size='10'  type='text' name='interest[]'></TD><TD><input size='10'  type='text' name='fee[]'></TD><TD><input size='10'  type='text' name='interest_ballet[]'><a href='#' onClick='removeFormField(\"#row1" + counter + "\"); return false;'> <img src='"+path+"/images/delete.gif'  border=0 width='16' height='16'></a></td></TR></table></div>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
}
function removeFormField(id) {
	if(confirm("Do you  want delete this range ? ")) {
	        $(id).remove();
	}
}

function validation() {
	var i;
	var start_range1=new Array();var end_range1=new Array();var interest1=new Array();var interest_ballet1=new Array();

	start_range1 = document.interestForm.elements["start_range[]"];
	end_range1 = document.interestForm.elements["end_range[]"];
	interest1 = document.interestForm.elements["interest[]"];
	fee1 = document.interestForm.elements["fee[]"];
	interest_ballet1 = document.interestForm.elements["interest_ballet[]"];

	var maxLength=Math.max(start_range1.length,end_range1.length,interest1.length,fee1.length,interest_ballet1.length);

	for(i=0; i< maxLength; i++) {
		if(start_range1[i].value=='' || end_range1[i].value=='' || interest1[i].value=='' || fee1[i].value=='' || interest_ballet1[i].value=='') {
				alert('Enter all range completely...');
				return false;
		}
	}
	return true;
}
