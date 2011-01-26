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
    $('.mainmoduleClass').click(function(){
            ModuleId=$(this).val();
            subModchkName='submodule_'+ModuleId;
            curVal=$(this).attr('checked'); //Make it as enable
            subModObj=$('input[name='+subModchkName+']') //object for submodule 
            subModObj.attr('checked',curVal);
            subModObj.each(function(i) {
            actId=$(this).val();
                actchkNameadd='add_'+ModuleId+'_'+actId; 
                actchkNameedit='edit_'+ModuleId+'_'+actId; 
                actchkNameview='view_'+ModuleId+'_'+actId; 
                actchkNamedelete='delete_'+ModuleId+'_'+actId;
                $('input[name='+actchkNameadd+']').attr('checked',curVal);
                $('input[name='+actchkNameedit+']').attr('checked',curVal);
                $('input[name='+actchkNameview+']').attr('checked',curVal);
                $('input[name='+actchkNamedelete+']').attr('checked',curVal);
            });
    });

    $('.submoduleClass').click(function(){
        Submoduleid=$(this).val();
        clickedName=$(this).attr('name');
        ModuleId=clickedName.split('_')[1];
        curVal=$(this).attr('checked');
                actchkNameadd='add_'+ModuleId+'_'+Submoduleid; 
                actchkNameedit='edit_'+ModuleId+'_'+Submoduleid; 
                actchkNameview='view_'+ModuleId+'_'+Submoduleid; 
                actchkNamedelete='delete_'+ModuleId+'_'+Submoduleid;
                $('input[name='+actchkNameadd+']').attr('checked',curVal);
                $('input[name='+actchkNameedit+']').attr('checked',curVal);
                $('input[name='+actchkNameview+']').attr('checked',curVal);
                $('input[name='+actchkNamedelete+']').attr('checked',curVal);
                subModObj=$('input[name='+clickedName+']')
                    mcurVal=false;
                    subModObj.each(function(i) {
                    if($(this).attr('checked')){
                        mcurVal=true;
                                }
                    });
                    moduleChkName = 'mainModule_'+ModuleId; 
                    Mainmoduleobj = $('input[name='+moduleChkName+']').attr('checked',mcurVal);;
    });

    $('.activityClass').click(function(){

       clickedName=$(this).attr('name');
// alert(clickedName);

//                 modId='#submodule_'+clickedName.split('_')[1];
// 
//  

    if ( $("#clickedName").( ":checked" ) )
    {
      alert('clicked'); //$("#modId").attr ( "checked" , true );
    }
    else
    {
     alert('no');
    }



// alert(modId);







// mvalue = clickedName.split('_')['1'];
// svalue = clickedName.split('_')['2'];
// // alert(mvalue);
// // alert(svalue);
//        	var activity;
//        SubModId='submodule_'+clickedName.split('_')[2];
// alert(SubModId);
//        ModId='mainModule_'+clickedName.split('_')[1];
// 
// //          actObj=$('input[name='+clickedName+']');
//             curVal=false;
//             for(i=0;i<4;i++){
//                 switch(i)
//                 {
//                    case 0:
//                         activity = 'add_'+mvalue+'_'+svalue;
//                         break;
//                    case 1:
//                         activity = 'edit_'+mvalue+'_'+svalue;
//                         break;
//                    case 2:
//                         activity = 'view_'+mvalue+'_'+svalue;
//                         break;
//                    case 3:
//                         activity = 'delete_'+mvalue+'_'+svalue;
//                         break;
//                 }
// // alert(activity);
//                 if($('input[name='+activity+']').attr('checked')){
//                     curVal = true;
//                 }
//           }
// 
// $('input[id='+SubModId+']').attr('checked',curVal))
 

//                   actObj.each(function(i) {
//                     if($(this).attr('checked')){
//                        curVal=true;
//                               }
//                    });
// alert(curVal);
//          $(SubModId).attr('checked',curVal);
//          subObj=$(SubModId).attr('name');
//               // alert(subObj);
//              submodtObj=$('input[name='+subObj+']');
//             scurVal=false;
//                   submodtObj.each(function(i) {
//                     if($(this).attr('checked')){
//                        scurVal=true;
//                               }
//                    });
//  
//           $(ModId).attr('checked',scurVal);

    });



});