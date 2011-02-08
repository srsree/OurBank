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
class Familymembers_Form_Familymembers extends Zend_Form
{
    public function __construct($id,$subId) 
    {
        parent::__construct($id,$subId); 
        $formfield = new App_Form_Field ();

        $cropId = new Zend_Form_Element_Select('crop_id[]');
        $cropId->setAttrib('class', 'txt_put');
        $cropId->setAttrib('id','crop_id[]');
   
       // $cropId = $formfield->field('Select','crop_id[]','','','','',true,'','','','','',0,0);
        $acre = $formfield->field('Text','acre[]','','','','',true,'','','','','',0,0);
        $acre->setAttrib('size',8);
        $quantity = $formfield->field('Text','quantity[]','','','','',true,'','','','','',0,0);
        $quantity->setAttrib('size',12);
        $marketed = $formfield->field('Text','marketed[]','','','','',true,'','','','','',0,0);
        $marketed->setAttrib('size',12);
        $price = $formfield->field('Text','price[]','','','','',true,'','','','','',0,0);
        //hidden feilds
        $id = $formfield->field('Hidden','id[]','','','','',false,'','','','','',0,$id);
        $subId = $formfield->field('Hidden','submodule_id[]','','','','',false,'','','','','',0,$subId);
        $createdBy = $formfield->field('Hidden','created_by[]','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date[]','','','','',false,'','','','','',0,date("y/m/d H:i:s"));
        $crpid = $formfield->field('Hidden','crpid[]','','','','','','','','','','',0,0);
        $this->addElements(array($id,$cropId,$acre,$quantity,$marketed,$price,$subId,$createdBy,$createdDate,$crpid));
    }
}


