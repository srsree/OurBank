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
class Management_Form_Roles extends ZendX_JQuery_Form {
    public function __construct($options = null) {
        $this->addPrefixPath('My_Form_', 'My/Form/');
        parent::__construct($options);

$this->addElement(
			'validateText',
			'username',
			array(
				'label' 		=> 'Username',
				'formId'		=> 'login',
				'trim'			=> true,
				'required' 		=> true,
				'validators'  	=> array(
					array(
						'validator' 	=> 'StringLength',
						'options' 		=> array(5, 15)
					)
				),
				'class'	=>	'required',
				'js'	=> array(
					'minlength'	=> '5',
					'maxlength'	=>	'15',
					'class'	=> 'required input',
				),
			)
		);

$this->addElement(
			'validateText',
			'password',
			array(
				'label' 		=> 'Password',
				'formId'		=> 'login',
                               'password'           => true,
				'trim'			=> true,
				'required' 		=> true,
				'validators'  	=> array(
					array(
						'validator' 	=> 'StringLength',
						'options' 		=> array(5, 15)
					)
				),
				'class'	=>	'required',
				'js'	=> array(
					'minlength'	=> '5',
					'maxlength'	=>	'15',
					'class'	=> 'required input',
				),
			)
		);




        }
}
