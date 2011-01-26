
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
/**to select the value of sub office when there is any changes in office type*/					
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
/**end*/
	function getSavingAccount(savingtypeId) {		
		var strURL="savingtype?savingtypeId="+savingtypeId;
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {						
					document.getElementById('savingdiv').innerHTML=req.responseText;						
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
		if(savingtypeId != '') {
			$('#lastdiv').show();
			$('#lastdiv1').hide();
		} else {
			$('#lastdiv').hide();
			$('#lastdiv1').show();
		}
		}
		
	} 


$(document).ready(function() {
$('input[name=sShortName]').autotab({ target: 'sShortName', maxlength: 2, format: 'alpha' });
});


$(function() {
  	$('.error').hide();
  	$('.error1').hide();
	$('.error2').hide()
  	$('input.txt_put').css({});
	$('input.txt_put').blur(function(){
    	$(this).css({backgroundColor:"#FFFFFF"});
  	});
  	$('input.txt_put').blur(function(){
    	$(this).css({border:"1px solid #666666"});
 	 });
});


$(function() {
$(".savings").click(function() {

	var name1 = $("input#sName").val();
	if (name1 == "") {
	$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#sName").css({backgroundColor:"#FFFFD5"});
		$("input#sName").css({border:"2px solid red"});
	}

	var name2 = $("input#sShortName").val();
	if (name2 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#sShortName").css({backgroundColor:"#FFFFD5"});
		$("input#sShortName").css({border:"2px solid red"});
	}

	var name3 = $("Textarea#sDescription").val();
	if (name3 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("Textarea#sDescription").css({backgroundColor:"#FFFFD5"});
		$("Textarea#sDescription").css({border:"2px solid red"});
	}

	var name4 = $("input#BeginDate").val();
	if (name4 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#BeginDate").css({backgroundColor:"#FFFFD5"});
		$("input#BeginDate").css({border:"2px solid red"});
	}

	var name5 = $("input#CloseDate").val();
	if (name5 == "") {	
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#CloseDate").css({backgroundColor:"#FFFFD5"});
		$("input#CloseDate").css({border:"2px solid red"});
	}



	var name6 = $("select#sGlsubcode").val();
	if (name6 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#sGlsubcode").css({backgroundColor:"#FFFFD5"});
		$("input#sGlsubcode").css({border:"2px solid red"})
	}

	var name7 = $("select#sGlsubcode1").val();
	if (name7 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#sGlsubcode1").css({backgroundColor:"#FFFFD5"});
		$("input#sGlsubcode1").css({border:"2px solid red"})
	}

	var name8 = $("select#sGlsubcode2").val();
	if (name8 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#sGlsubcode2").css({backgroundColor:"#FFFFD5"});
		$("input#sGlsubcode2").css({border:"2px solid red"})
	}

	var name9 = $("select#applicableto").val();
	if (name9 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#applicableto").css({backgroundColor:"#FFFFD5"});
		$("input#applicableto").css({border:"2px solid red"})
	}

	var name10 = $("input#sMinDeposit").val();
	if (name10 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#sMinDeposit").css({backgroundColor:"#FFFFD5"});
		$("input#sMinDeposit").css({border:"2px solid red"});
	}

	var name11 = $("input#sMinBalInterest").val();
	if (name11 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#sMinBalInterest").css({backgroundColor:"#FFFFD5"});
		$("input#sMinBalInterest").css({border:"2px solid red"});
	}

	var name12 = $("select#sTimeFrequencye").val();
	if (name12 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#sTimeFrequencye").css({backgroundColor:"#FFFFD5"});
		$("input#sTimeFrequencye").css({border:"2px solid red"})
	}

	var name13 = $("select#sAmountCalculation").val();
	if (name13 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#sAmountCalculation").css({backgroundColor:"#FFFFD5"});
		$("input#sAmountCalculation").css({border:"2px solid red"})
	}

	var name14 = $("select#sTimeFrequency").val();
	if (name14 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#sTimeFrequency").css({backgroundColor:"#FFFFD5"});
		$("input#sTimeFrequency").css({border:"2px solid red"})
	}

	var name15 = $("select#capitalaccountingcode").val();
	if (name15 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#capitalaccountingcode").css({backgroundColor:"#FFFFD5"});
		$("input#capitalaccountingcode").css({border:"2px solid red"})
	}

	var name16 = $("select#interestaccountingcode").val();
	if (name16 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#interestaccountingcode").css({backgroundColor:"#FFFFD5"});
		$("input#interestaccountingcode").css({border:"2px solid red"})
	}

	var name17 = $("select#feeaccountingcode").val();
	if (name17 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#feeaccountingcode").css({backgroundColor:"#FFFFD5"});
		$("input#feeaccountingcode").css({border:"2px solid red"})
	}

	var name18 = $("input#minfixeddepositamount").val();
	if (name18 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#minfixeddepositamount").css({backgroundColor:"#FFFFD5"});
		$("input#minfixeddepositamount").css({border:"2px solid red"});
	}

	var name19 = $("input#maxfixeddepositamount").val();
	if (name19 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#maxfixeddepositamount").css({backgroundColor:"#FFFFD5"});
		$("input#maxfixeddepositamount").css({border:"2px solid red"});
	}

	var name20 = $("input#penalinterest").val();
	if (name20 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#penalinterest").css({backgroundColor:"#FFFFD5"});
		$("input#penalinterest").css({border:"2px solid red"});
	}

	var name21 = $("select#freequencyofdeposit").val();
	if (name21 == "") {
		$('.error1').hide();
		$('.error').hide();
		$("label#name_error2").show();
		$("select#freequencyofdeposit").css({backgroundColor:"#FFFFD5"});
		$("input#freequencyofdeposit").css({border:"2px solid red"})
	}

	var name22 = $("input#Interestperiod").val();
	if (name22 == "") {
		$('.error1').hide();
		$('.error2').hide();
		$("label#name_error").show();
		$("input#Interestperiod").css({backgroundColor:"#FFFFD5"});
		$("input#Interestperiod").css({border:"2px solid red"});
	}

	var name23 = $("input#interestfrom").val();
	if (name23 == "") {
		$("label#name_error").show();
		$("input#interestfrom").css({backgroundColor:"#FFFFD5"});
		$("input#interestfrom").css({border:"2px solid red"});
	}

	var name24 = $("input#interestto").val();
	if (name24 == "") {
		$("label#name_error").show();
		$("input#interestto").css({backgroundColor:"#FFFFD5"});
		$("input#interestto").css({border:"2px solid red"});
	}

	var name25 = $("input#interestrate").val();
	if (name25 == "") {
		$("label#name_error").show();
		$("input#interestrate").css({backgroundColor:"#FFFFD5"});
		$("input#interestrate").css({border:"2px solid red"});
	}

	var name33 = $("input#currentdates").val();

	for(var i=0;i<=100;i++) {
		var name26 = $("input#memberName"+i).val();
		if (name26 == "") {
			alert('* marked  are mandatory');
			$("input#memberName"+i).css({backgroundColor:"#FFFFD5"});
			$("input#memberName"+i).css({border:"2px solid red"});
			$("input#memberName"+i).focus();
			return false;
		}

		var name27 = $("input#To"+i).val();
		if (name27 == "") {
			alert('* marked  are mandatory');
			$("input#To"+i).css({backgroundColor:"#FFFFD5"});
			$("input#To"+i).css({border:"2px solid red"});
			$("input#To"+i).focus();
			return false;
		}

		var name28 = $("input#Rate"+i).val();
		if (name28 == "") {
			alert('* marked  are mandatory');
			$("input#Rate"+i).css({backgroundColor:"#FFFFD5"});
			$("input#Rate"+i).css({border:"2px solid red"});
			$("input#Rate"+i).focus();
			return false;
		}
	}


	if(name1 =="" || name2 =="" || name3 =="" || name4 =="" || name5 =="" || name6 =="" || name7 =="" || name8 =="" || name9 =="" || name10 =="" || name11 =="" || name12 =="" || name13 =="" || name14 =="" || name15 =="" || name16 =="" || name17 =="" || name18 =="" || name19 =="" || name20 =="" || name21 =="" || name22 =="" || name23 =="" || name24 =="" || name25 =="" || name33 =="" )
	{
		alert('* marked  are mandatory');
		return false;
	}else if(name4 < name33) {
		alert('begin date must be grater than or equal to current date');	
		return false;
	} else if(name5 <= name4) {
		alert('closed date must be grater than begin date');	
		return false;
	} else if(name19.length < name18.length) {
		alert('Maximum amount must be grater than minimum amount');	
		return false;
	}
});
});


 var current =0;
    function membername() {
    var count = document.myform.memberCount.value;
    for (var i = 1; i<=count; i++) {
        var name = $("input#memberName"+i).val();
    }
    }
	var current =0;
	$(document).ready(function(){
		$('#addPerson').click(addPerson)
	});

function addFormField() {
	current++;
	var id = document.getElementById("id").value;

	$("#interestperiods").append("<tr id='row" + id + "'><td><label for='memberName" + id + "'><input type='text' size='3' name='memberName"+current+"' id='memberName" + id + "' class = 'txt_put'></td><td><label for='To" + id + "'><input type='text' size='3' name='To"+current+"' id='To" + id + "' class = 'txt_put'></td><td><label for='Rate" + id + "'><input type='text' size='3' name='Rate"+current+"' id='Rate" + id + "' class = 'txt_put'><a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'><img src='/Mahiti/ourbank/management/images/delete.gif'  border=0 width='16' height='16'></a></td></tr>");
	document.myform.memberCount.value = id;	
	id =( id - 1) + 2;
	document.getElementById("id").value = id;
}

function removeFormField(id) {
	$(id).remove();
}

