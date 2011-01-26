
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
    $('input.textfield').css({backgroundColor:"#FFFFFF"});
    $('input.textfield').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
    });
    $('input.textfield').blur(function(){
    $(this).css({border:"1px solid #686A6F"});
    });
    });

    $(function() {
    $(".groups").click(function() {

    var name1 = $("select#office_id").val();
        if (name1 == "") {
        $("label#name_error2").show();
        $("select#office_id").css({backgroundColor:"#FFFFD5"});
        }

    var name2 = $("select#subOffice").val();
    if (name2 == "") {
    $("label#name_error1").show();
    $("select#subOffice").css({backgroundColor:"#FFFFD5"});
    }

    var name3 = $("input#groupname").val();
    if (name3 == "") {
    $("label#name_error").show();
    $("input#groupname").css({backgroundColor:"#FFFFD5"});
    $("input#groupname").css({border:"2px solid red"});
    }

    var name4 = $("input#groupaddress_line1").val();
    if (name4 == "") {
    $("label#name_error").show();
    $("input#groupaddress_line1").css({backgroundColor:"#FFFFD5"});
    $("input#groupaddress_line1").css({border:"2px solid red"});
    }

    var name5 = $("input#groupaddress_line2").val();
    if (name5 == "") {
    $("label#name_error").show();
    $("input#groupaddress_line2").css({backgroundColor:"#FFFFD5"});
    $("input#groupaddress_line2").css({border:"2px solid red"});
    }

    var name6 = $("input#groupaddress_line3").val();
    if (name6 == "") {
    $("label#name_error").show();
    $("input#groupaddress_line3").css({backgroundColor:"#FFFFD5"});
    $("input#groupaddress_line3").css({border:"2px solid red"});
    }

    var name7 = $("input#groupaddress_location").val();
    if (name7 == "") {
    $("label#name_error").show();
    $("input#groupaddress_location").css({backgroundColor:"#FFFFD5"});
    $("input#groupaddress_location").css({border:"2px solid red"});
    }

    var name8 = $("input#officePincode").val();
    if (name8 == "") {
    $("label#name_error").show();
    $("input#officePincode").css({backgroundColor:"#FFFFD5"});
    $("input#officePincode").css({border:"2px solid red"});
    }

    var name9 = $("input#officeCity").val();
    if (name9 == "") {
    $("label#name_error").show();
    $("input#officeCity").css({backgroundColor:"#FFFFD5"});
    $("input#officeCity").css({border:"2px solid red"});
    }

    var name10 = $("input#officePhone").val();
    if (name10 == "") {
    $("label#name_error").show();
    $("input#officePhone").css({backgroundColor:"#FFFFD5"});
    $("input#officePhone").css({border:"2px solid red"});
    }

    var name11 = $("select#gender_id").val();
    if (name11 == "") {
    $("label#name_error1").show();
    $("select#gender_id").css({backgroundColor:"#FFFFD5"});
    }
    var name12 = $("input#membercity").val();
    if (name12 == "") {
    $("label#name_error").show();
    $("input#membercity").css({backgroundColor:"#FFFFD5"});
    $("input#membercity").css({border:"2px solid red"});
    }

    if(name1 =="" || name2 =="" || name3 =="" || name4 =="" || name5 =="" || name6 =="" || name7 =="" || 
       name8 =="" || name9 =="" || name10 =="" || name11 =="" || name12 =="") {
//         alert('* marked  are mandatory');
        return false;
    }
    });
});
