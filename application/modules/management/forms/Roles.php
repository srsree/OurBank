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
class Management_Form_Roles extends Zend_Form
    {
        public function __construct()
        {
            Zend_Dojo::enableForm($this);

            $grantname = new Zend_Form_Element_Text('grantname');
            $grantname->setRequired(true)
                      ->addValidators(array(
                      array('NotEmpty')));
	    $grantname->addValidator('StringLength', false, array(6, 15));





           $id = new Zend_Form_Element_Hidden('id'.$i);

            $activity_id = new Zend_Form_Element_MultiCheckbox('activity_id');
	    $activity_id->setAttrib('id', 'activity_id');

            $subactivity_id = new Zend_Form_Element_MultiCheckbox('subactivity_id');
	    $subactivity_id->setAttrib('id', 'subactivity_id');

            $grant_id = new Zend_Form_Element_Hidden('grant_id');

            $submit = new Zend_Form_Element_Submit('Submit');
            $submit->setAttrib('class', 'roles');
            $submit->setLabel('Submit');
            $this->addElements(array($submit,$grantname,$grant_id,$id,$activity_id,$subactivity_id));
        }
    }