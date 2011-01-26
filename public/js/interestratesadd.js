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

var counter = 1;
function addInputADD(divName,path) {
          var newdiv = document.createElement('SPAN');

          newdiv.innerHTML =  "<font id='row1"+counter+"'> <TR><TD> <input size='10' id='rows"+counter+"' type='text' name='start_range[]' onBlur=\"checkGreater('"+counter+"')\" ></TD>  <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input size='10'  id='rowe"+counter+"' type='text' name='end_range[]'  onBlur=\"checkGreater('"+counter+"')\"></TD> <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  size='10'id='rowi"+counter+"'  type='text' name='interest[]' onBlur=\"checkGreater('"+counter+"')\"></TD> <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input size='10' id='rowf"+counter+"'  type='text' name='fee[]' onBlur=\"checkGreater('"+counter+"')\"></TD>  <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <input size='10' id='rowb"+counter+"' type='text' name='interest_ballet[]' onBlur=\"checkGreater('"+counter+"')\"> <a href='#' onClick='removeFormField(\"#row1" + counter + "\"); return false;'><img src='"+path+"/images/delete.gif'  border=0 width='16' height='16'></a></td> </TR></font>";
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
	var start_range1=new Array();	var end_range1=new Array();	var interest1=new Array();	var interest_ballet1=new Array();

	start_range1 = document.interestForm.elements["start_range[]"];
	end_range1 = document.interestForm.elements["end_range[]"];
	interest1 = document.interestForm.elements["interest[]"];
	interest_ballet1 = document.interestForm.elements["interest_ballet[]"];

	var ma=Math.max(start_range1.length,end_range1.length,interest1.length,interest_ballet1.length);
	for(i=0; i< ma; i++) {
		if(start_range1[i].value=="" || end_range1[i].value=="" || interest1[i].value=="" || interest_ballet1[i].value=="") {
				alert("Enter all range completely...");
				return false;
		}
	}

	if(document.getElementById("S_rangeID").value=="" || document.getElementById("e_rangeID").value=="" || document.getElementById("interestID").value=="" ||document.getElementById("balletID").value=="") {
		alert("Enter all range completely...");
		return false;
	}
	
	if(document.getElementById("rows1").value < document.getElementById("e_rangeID").value) {
		document.getElementById("rows"+counter).value="";
		return false;
	}
	return true;
}

function isNumericVal() {
	if(isNaN(document.getElementById("S_rangeID").value) || parseInt(document.getElementById("S_rangeID").value) < 1) { document.getElementById("S_rangeID").value="";}
	if(isNaN(document.getElementById("e_rangeID").value) || parseInt(document.getElementById("e_rangeID").value) < 1) { document.getElementById("e_rangeID").value=""; }
	if(isNaN(document.getElementById("interestID").value) || parseInt(document.getElementById("interestID").value) < 1) { document.getElementById("interestID").value=""; }
	if(isNaN(document.getElementById("feeID").value) || parseInt(document.getElementById("feeID").value) < 1) { document.getElementById("feeID").value=""; }
	if(isNaN(document.getElementById("balletID").value) || parseInt(document.getElementById("balletID").value) < 0) { document.getElementById("balletID").value=""; }

	if(document.getElementById("e_rangeID").value!="") {
		if(parseInt(document.getElementById("e_rangeID").value) <= parseInt(document.getElementById("S_rangeID").value)) {
			document.getElementById("e_rangeID").value="";
		}
	}
}

function checkGreater(counter) {
	if(isNaN(document.getElementById("rows"+counter).value) || (document.getElementById("rows"+counter).value)<1) { document.getElementById("rows"+counter).value=""; }
	if(isNaN(document.getElementById("rowe"+counter).value) || (document.getElementById("rowe"+counter).value)<1) { document.getElementById("rowe"+counter).value=""; }
	if(isNaN(document.getElementById("rowi"+counter).value) || (document.getElementById("rowi"+counter).value)<1) { document.getElementById("rowi"+counter).value=""; }
	if(isNaN(document.getElementById("rowf"+counter).value) || (document.getElementById("rowf"+counter).value)<1) { document.getElementById("rowf"+counter).value=""; }
	if(isNaN(document.getElementById("rowb"+counter).value) || (document.getElementById("rowb"+counter).value)<0) { document.getElementById("rowb"+counter).value=""; }
	
	if(document.getElementById("rowe"+counter).value!="") {
		if(parseInt(document.getElementById("rowe"+counter).value) <= parseInt(document.getElementById("rows"+counter).value)) {
			document.getElementById("rowe"+counter).value="";
		}//validate all end with start range
	}
	
	//validate first Interest and second
	if(counter == 1) {
		if(parseInt(document.getElementById("rows"+counter).value) <= parseInt(document.getElementById("e_rangeID").value)) {
			document.getElementById("rows"+counter).value="";
		}
		if(parseInt(document.getElementById("rowi"+counter).value) <= parseInt(document.getElementById("interestID").value)) {
			document.getElementById("rowi"+counter).value="";
		}
		if(parseInt(document.getElementById("rowf"+counter).value) < parseInt(document.getElementById("feeID").value)) {
			document.getElementById("rowf"+counter).value="";
		}
		if(parseInt(document.getElementById("rowb"+counter).value) < parseInt(document.getElementById("balletID").value)) {
			document.getElementById("rowb"+counter).value="";
		}
		
	}
	
	//validate  (after Second REcord)
	if(counter>1) {
		if(parseInt(document.getElementById("rows"+counter).value) <= parseInt(document.getElementById("rowe"+(counter-1)).value)) {
			document.getElementById("rows"+counter).value="";
		}
		if(parseInt(document.getElementById("rowi"+counter).value) <= parseInt(document.getElementById("rowi"+(counter-1)).value)) {
			document.getElementById("rowi"+counter).value="";
		}
		if(parseInt(document.getElementById("rowf"+counter).value) < parseInt(document.getElementById("rowf"+(counter-1)).value)) {
			document.getElementById("rowf"+counter).value="";
		}
		if(parseInt(document.getElementById("rowb"+counter).value) < parseInt(document.getElementById("rowb"+(counter-1)).value)) {
			document.getElementById("rowb"+counter).value="";
		}
	}
}