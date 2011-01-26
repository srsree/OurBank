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
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initSession() {
       Zend_Session::start();
       Zend_Locale::disableCache(true);
    }

    protected function _initAppAutoload() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'App',
            'basePath'  => dirname(__FILE__),));
        return $autoloader;
    }

    protected function _initLayoutHelper() {
        $this->bootstrap('frontController');
        $layout = Zend_Controller_Action_HelperBroker::addHelper(new Mod_Controller_Action_Helper_LayoutLoader());
     }

    protected function _initView() {
        $view = new Zend_View();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

    }

	public function _inittranslate() 
	{

      	$translate = new Zend_Translate(
        array(
              'adapter' => 'gettext',
              'content' => APPLICATION_PATH.'/languages/default.mo',
              'locale'  => 'en'));
  
//         $translate->addTranslation(
//         array(
//               'content' => APPLICATION_PATH.'/languages/hindi.mo',
//               'locale'  => 'hi_IN'));

		$sessionName = new Zend_Session_Namespace('ourbank');
      	$translate->setLocale($sessionName->__get('language'));

 	 	Zend_Registry::set('Zend_Translate', $translate);
	}

}
