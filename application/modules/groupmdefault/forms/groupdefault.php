<?php
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

    class  Groupmdefault_Form_groupdefault extends Zend_Form {
            public function init() {
            }
    
            public function __construct($app) {
                // create instance for common form field
                $formfield = new App_Form_Field ();
                // send required parameters to get respective form fields ( first parameter is a input type)
                $office = $formfield->field('Select','office','','','mand','Office',true,'','','','','',0,'');
                $office->setAttrib('onchange','getMember(this.value,"'.$app.'")');
                $groupname = $formfield->field('Text','groupname','','','mand','Group name',true,'','','','','',1,'');
                $date = $formfield->field('Text','Created_Date','','','mand','Created date',true,'','','','','',1,'');
                $code = new Zend_Form_Element_Hidden('code');
                $submit = new Zend_Form_Element_Submit('Submit');
                $back= new Zend_Form_Element_Button('Back');
                $this->addElements(array($office,$groupname,$date,$code,$submit,$back));
            }
    }
