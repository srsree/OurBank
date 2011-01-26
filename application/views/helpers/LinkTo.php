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
class Zend_View_Helper_LinkTo
{
	protected static $baseUrl = null;
	public function linkTo($path)
	{
		if (self::$baseUrl === null) {
			$request = Zend_Controller_Front::getInstance()->getRequest();
			$root = '/' . trim($request->getBaseUrl(), '/');
			if ($root == '/') {
				$root = '';
			}
			self::$baseUrl = $root . '/';
		}
		return self::$baseUrl . ltrim($path, '/');
	}
}