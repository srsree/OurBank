<?php

/**
* @see ZendX_JQuery_View_Helper_UiWidget
*/
require_once "ZendX/JQuery/View/Helper/UiWidget.php";

class Management_View_Helper_ValidateText extends ZendX_JQuery_View_Helper_UiWidget
{

	public function validateText($id, $value = null, array $params = array(), array $attribs = array())
	{
		$attribs = $this->_prepareAttributes($id, $value, $attribs);
		$this->jquery->addJavascriptFile('/scripts/validation/jquery.validate.js'); // Each jquery plugin or js plugin in its own folder within the scripts folder.
		if(!isset($attribs['formId'])) {
			require_once "ZendX/JQuery/Exception.php";
			throw new ZendX_JQuery_Exception("Cannot construct validateText without the form ID");
		} //We must have the form name else it is no good!!!

	$params = ZendX_JQuery::encodeJson($params);

	$js = '	$("#' . $attribs['formId'] . '").validate();';

		$this->jquery->addOnLoad($js);

		//Get our details!!!!
		$disabled = '';
		if ($attribs['disable']) {
			// disabled
			$disabled = ' disabled="disabled"';
		}

		//get additional rules
		$rules = '';
		if(is_array($attribs['js'])){
			foreach($attribs['js'] as $rule => $rulevalue)
			{
				$rules .= ' ' . $rule . '="'. $rulevalue . '"';
			}
		}

		$type = 'text';
		if($attribs['password'])
		{
			$type = 'password';
		}

		// XHTML or HTML end tag?
		$endTag = ' />';
		if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
			$endTag= '>';
		}

					   $xhtml = '<input type="'.$type.'"'
				. ' name="' . $this->view->escape($attribs['name']) . '"'
				. ' id="' . $this->view->escape($attribs['id']) . '"'
				. ' value="' . $this->view->escape($attribs['value']) . '"'
				. $rules
				. $disabled
				. $endTag;

					  return $xhtml;
	}

}
