
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

function extractPageName(hrefString)
{
	var arr = hrefString;
	//document.write(arr.substr(42,5));

	return  (arr.length>2) ? hrefString : arr[arr.length-2].toLowerCase() + arr[arr.length-1].toLowerCase();               
}

function setActiveMenu(arr, crtPage)
{
crtPage=(crtPage.substr(42,12));
//document.write(crtPage);
	for (var i=0; i<arr.length; i++)
	{
//document.write(extractPageName(arr[i].href));

		if(extractPageName(arr[i].href.substr(42,12)) == crtPage)
		{
			if (arr[i].parentNode.tagName != "DIV")
			{
				arr[i].className = "current";
				arr[i].parentNode.className = "current";
			}
		}
	}
}

function setPage(module)
{
	hrefString = document.location.href ? document.location.href : document.location;
//document.write(module);
	if (document.getElementById("nav")!=null)
		setActiveMenu(document.getElementById("nav").getElementsByTagName("a"), extractPageName(hrefString));
}
