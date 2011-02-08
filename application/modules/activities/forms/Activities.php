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
class Activities_Form_Activities extends Zend_Form
{
    public function __construct($id,$subId) 
    {
        parent::__construct($id,$subId); 
        $formfield = new App_Form_Field ();

        $acre = $formfield->field('Text','acre[]','','','','',true,'','','','','',0,0);
        $acre->setAttrib('size',8);

        $id = $formfield->field('Hidden','id[]','','','','',false,'','','','','',0,$id);
        $subId = $formfield->field('Hidden','submodule_id[]','','','','',false,'','','','','',0,$subId);
        $createdBy = $formfield->field('Hidden','created_by[]','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date[]','','','','',false,'','','','','',0,date("y/m/d H:i:s"));

        $this->addElements(array($id,$acre,$subId,$createdBy,$createdDate));
    }
}


