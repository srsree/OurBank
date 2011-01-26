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

function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp=false;	
        try {
            xmlhttp=new XMLHttpRequest();
        }
        catch(e) {	
            try {
              xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
       catch(e){
            try{
             xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
       catch(e1) {
            xmlhttp=false;
            }
        }
    }
        return xmlhttp;
    }

    
function getMember(branch_id,path,group_id) {	
       var strURL = path+"/groupdefault/index/getmembers?branch_id="+branch_id+"&group_id="+group_id;  
        var req = getXMLHTTP();
         if (req) {
            req.onreadystatechange = function() {
            if (req.readyState == 4) {   // only if "OK"
            if (req.status == 200) {	
    
                document.getElementById('membersdiv').innerHTML=req.responseText;							
            } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
                }	
            req.open("GET", strURL, true);
            req.send(null);
        }
    }
