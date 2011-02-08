<?php 
class Management_Form_Fee extends Zend_Dojo_Form
{
    public $_selectOptions;
    public function init()
    {
        $this->_selectOptions=array(
                '1' => 'red',
                '2' => 'blue',
                '3' => 'gray'
            );

        $this->setMethod('post');
        $this->setAttribs(array(
                'name' => 'masterform'
            ));
        $this->setDecorators(array(
                'FormElements',
                array(
                    'TabContainer',
                     array(
                        'id' => 'tabContainer',
                        'style' => 'width:660px; height:500px',
                        'dijitParams' => array(
                            'tabPosition' => 'top',
                        )
                    ),
                    'DijitForm'
                )
            )); 

        $textForm= new Zend_Dojo_Form_SubForm();
        $textForm->setAttribs(array(
                'name'=> 'textboxtab',
                'legend' => 'Text Elements',
                'dijitParams' => array(
                    'title' => 'Text Elements',
                )
        ));
        $textForm->addElement(
                'TextBox',
                'textbox',
                array(
                    'value' => 'some text',
                    'label' => 'TextBox',
                    'trim' => true,
                    'propercase' => true,
                )
            );
        $textForm->addElement(
                'DateTextBox',
                'datebox',
                array(
                    'value' => '2008-07-05',
'label' => 'DateTexBox',
                    'required' => true,
                )
            );
        $textForm->addElement(
                'TimeTextBox',
                'timebox',
                array(
                    'label' => 'TimeTexBox',
                    'required' => true,
                )
            );
        $textForm->addElement(
                'CurrencyTextBox',
                'currencybox',
                array(
                    'label' => 'CurrencyTexBox',
                    'required' => true,
                    'currency'=>'USD',
                    'invalidMessage' => 'Invalid amount',
                    'symbol' => 'USD',
                    'type' => 'currency',
                )
            );
        $textForm->addElement(
                'NumberTextBox',
                'numberbox',
                array(
                    'label' => 'NumberTexBox',
                    'required' => true,
                    'invalidMessage'=>'Invalid elevation.',
                    'constraints' => array(
                        'min' => -2000,
                        'max'=> 2000,
                        'places' => 0,
                    )
                )
            );
        $textForm->addElement(
                'ValidationTextBox',
                'validationbox',
                array(
                    'label' => 'ValidationTexBox',
                    'required' => true,
                    'regExp' => '[\w]+',
                    'invalidMessage' => 'invalid non-space text.',
                )
            );
        $textForm->addElement(
                'Textarea',
                'textarea',
                array(
                    'label' => 'TextArea',
                    'required' => true,
                    'style' => 'width:200px',
                )
            );

        $toggleForm= new Zend_Dojo_Form_SubForm();
        $toggleForm->setAttribs(array(
                    'name' => 'toggletab',
                    'legend' => 'Toggle Elements',
                ));
        $toggleForm->addElement(
                'NumberSpinner',
                'ns',
                array(
                    'value' => '7',
                    'label' => 'NumberSpinner',
                    'smallDelta' => 5,
                    'largeDelta' => 25,
                    'defaultTimeout' => 1000,
                    'timeoutChangeRate' => 100,
                    'min' => 9,
                    'max' => 1550,
                    'places' => 0,
                    'maxlength' => 20,
                )
            );
        $toggleForm->addElement(
            'Button',
            'dijitButton',
            array(
                'label' => 'Button',
            )
        );
        $toggleForm->addElement(
            'CheckBox',
            'checkbox',
            array(
                'label' => 'CheckBox',
                'checkedValue' => 'foo',
                'uncheckedValue' => 'bar',
                'checked' => true,
            )
        );
        $selectForm= new Zend_Dojo_Form_SubForm();
        $selectForm->setAttribs(array(
                    'name' => 'selecttab',
                    'legend' => 'Select Elements',
                ));
        $selectForm->addElement(
            'ComboBox',
            'comboboxselect',
            array(
                'label' => 'ComboBox(select)',
                'value' => 'blue',
                'autocomplete'=>false,
                'multiOptions' => $this->_selectOptions,
            )
        );
        $selectForm->addElement(
            'FilteringSelect',
            'filterselect',
            array(
                'label' => 'FilteringSelect(select)',
                'value' => 'blue',
                'autocomplete'=>false,
                'multiOptions' => $this->_selectOptions,
            )
        );

        $this->addSubForm($textForm,'textForm')
                ->addSubForm($toggleForm,'toggleForm')
                ->addSubForm($selectForm,'selectForm');
    }
}
