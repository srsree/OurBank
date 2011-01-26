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
?>

<?php
class Familyinfo_Form_familyinfo extends Zend_Form {
    public function init()
    {} 

    public function __construct($id,$create_id) 
    {
        parent::__construct($id);
        parent::__construct($create_id);
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
        $father = $formfield->field('Text','father','','','','Father name',false,'','','','','',1,0);
        $mother = $formfield->field('Text','mother','','','','Mother name',false,'','','','','',1,0);
        $spouse = $formfield->field('Text','spouse','','','','Spouse name',false,'','','','','',1,0);
        $children = $formfield->field('Text','children','','','','Children',false,'','','','','',1,0);
        $other = $formfield->field('Textarea','otherinfo','','','','Other',false,'','','',3,18,1,0);
    
        $id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,$id);
        $created_by = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,$create_id);
        $created_date = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));
        $this->addElements(array($id,$father,$mother,$spouse,$children,$other,$created_by,$created_date));
    }
}
