
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
$(function() {
  $('.error').hide();
  $('.error1').hide();
 $('.error2').hide()
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });
$(document).ready(function() {
$('input#Office_Code1').autotab({ target: 'Office_Code1', maxlength: 2, format: 'alpha' });
	for(var i=2;i<10;i++)
	{
		$('input#Office_Type'+i).autotab({ target: 'Office_Type'+i,maxlength: 50, format: 'alpha' });
		$('input#Office_Code'+i).autotab({ target: 'Office_Code'+i,maxlength: 2, format: 'alpha' });
	}

});
  $(".officesubmit").click(function() {
		// validate and process form
		// first hide any error messages
 
		
	  var name = $("input#Office_Code1").val();
		if (name == "") {
			$('.error1').hide();
			$('.error2').hide();
      			$("label#name_error").show();
      			$("input#Office_Code1").focus();
      			return false;
    				}
	var name = $("input#Office_Code1").val();
		if (name.length != 2) {
				$('.error').hide();
				$('.error2').hide();
      				$("label#name_error1").show();
				$("input#Office_Code1").focus();
				 return false;
					}
for(var i=2;i<10;i++)
{
	  var name = $("input#Office_Code"+i).val();
		if (name == "") {
				$('.error1').hide();
				$('.error2').hide();
      				$("label#name_error").show();
     				 $("input#Office_Code"+i).focus();
      				return false;
    				}
	var name = $("input#Office_Code"+i).val();
		if (name.length != 2) {
				$('.error').hide();
				$('.error2').hide();
      				$("label#name_error1").show();
				$("input#Office_Code"+i).focus();
				 return false;
					}
	  var name = $("input#Office_Type"+i).val();
		if (name == "") {
			$('.error2').hide();
			$('.error1').hide();
      			$("label#name_error").show();
      			$("input#Office_Type"+i).focus();
      			return false;
    				}
	var name = $("input#Office_Type"+i).val();
		if (name.length < 3) {
			$('.error').hide();
			$('.error1').hide();
      			$("label#name_error2").show();
			$("input#Office_Type"+i).focus();
			 return false;
				}

}

	});
});
runOnLoad(function(){
  $("input#Office_Code1").select().focus();
});
