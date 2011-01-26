
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
$(document).ready(function() {
$('input[name=categoryname]').autotab({ target: 'categoryname', maxlength: 50, format: 'alpha' });
$('input[name=productname]').autotab({ target: 'productname', maxlength: 30 });
$('input[name=productshortname]').autotab({ target: 'productshortname', maxlength: 3 });
$('input[name=product_description]').autotab({ target: 'product_description', maxlength: 200});
});

$(function() {
$('.error').hide();
$('.error1').hide();
$('.error2').hide()
$('input.textfield').css({backgroundColor:"#FFFFFF"});

$('input.textfield').blur(function(){
$(this).css({backgroundColor:"#FFFFFF"});
});
$('input.textfield').blur(function(){
$(this).css({border:"1px solid #686A6F"});
});

});
$(function() {
$(".savings").click(function() {

var name1 = $("select#savings_description").val();
if (name1 == "") {
$('.error1').hide();
$('.error').hide();
$("label#name_error2").show();
$("select#savings_description").css({backgroundColor:"#FFFFD5"});
$("input#savings_description").css({border:"2px solid red"})
}

 
 
var name2 = $("input#membercode").val();
if (name2 == "") {
$('.error1').hide();
$('.error2').hide();

$("label#name_error").show();
$("input#membercode").css({backgroundColor:"#FFFFD5"});
$("input#membercode").css({border:"2px solid red"});
}

var name3 = $("input#loanSanctionDate").val();
if (name3 == "") {
$('.error1').hide();
$('.error2').hide();
$("label#name_error").show();
$("input#loanSanctionDate").css({backgroundColor:"#FFFFD5"});
$("input#loanSanctionDate").css({border:"2px solid red"});
      			
}

var name4 = $("input#beginDate").val();
if (name4 == "") {
$('.error1').hide();
$('.error2').hide();
$("label#name_error").show();
$("input#beginDate").css({backgroundColor:"#FFFFD5"});
$("input#beginDate").css({border:"2px solid red"});
      			
}

var name5 = $("input#amount").val();
if (name5 == "") {
$('.error1').hide();
$('.error2').hide();
$("label#name_error").show();
$("input#amount").css({backgroundColor:"#FFFFD5"});
$("input#amount").css({border:"2px solid red"});
      			
}
var name6 = $("input#loanInterest").val();
if (name6 == "") {
$('.error1').hide();
$('.error2').hide();
$("label#name_error").show();
$("input#loanInterest").css({backgroundColor:"#FFFFD5"});
$("input#loanInterest").css({border:"2px solid red"});
      			
}

var name7 = $("input#loanInstallements").val();
if (name7 == "") {
$('.error1').hide();
$('.error2').hide();
$("label#name_error").show();
$("input#loanInstallements").css({backgroundColor:"#FFFFD5"});
$("input#loanInstallements").css({border:"2px solid red"});
      			
}

	

if( name1 =="" || name2 =="" || name3 =="" || name4 =="" || name5 =="" || name6 =="" || name7 =="" )
{
alert('* marked  are mandatory');
return false;
}
});
});
