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
