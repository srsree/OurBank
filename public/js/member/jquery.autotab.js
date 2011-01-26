
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
/*
 * Autotab - jQuery plugin 1.0
 * http://dev.lousyllama.com/auto-tab
 * 
 * Copyright (c) 2008 Matthew Miller
 * 
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 * 
 * Revised: 2008/05/22 01:23:25
 */

(function($) {

$.fn.autotab = function(options) {
	var defaults = {
		format: 'all',			// text, numeric, alphanumeric, all
		maxlength: 2147483647,	// Defaults to maxlength value
		uppercase: true,		// Converts a string to UPPERCASE
		lowercase: true,		// Converts a string to lowecase
		nospace: false,		// Remove spaces in the user input
		target: null,			// Where to auto tab to
		previous: null			// Backwards auto tab when all data is backspaced
	};

	$.extend(defaults, options);

	var check_element = function(name) {
		var val = null;
		var check_id = $('#' + name)[0];
		var check_name = $('input[name=' + name + ']')[0];

		if(check_id != undefined)
			val = $(check_id);
		else if(check_name != undefined)
			val = $(check_name);

		return val;
	};

	var key = function(e) {
		if(!e)
			e = window.event;

		return e.keyCode;
	};

	// Sets targets to element based on the name or ID passed
	if(typeof defaults.target == 'string')
		defaults.target = check_element(defaults.target);

	if(typeof defaults.previous == 'string')
		defaults.previous = check_element(defaults.previous);

	var maxlength = $(this).attr('maxlength');

	// Each text field has a maximum character limit of 2147483647

	// defaults.maxlength has not changed and maxlength was specified
	if(defaults.maxlength == 2147483647 && maxlength != 2147483647)
		defaults.maxlength = maxlength;
	// defaults.maxlength overrides maxlength
	else if(defaults.maxlength > 0)
		$(this).attr('maxlength', defaults.maxlength)
	// defaults.maxlength and maxlength have not been specified
	// A target cannot be used since there is no defined maxlength
	else
		defaults.target = null;

	// IE does not recognize the backspace key
	// with keypress in a blank input box
	if($.browser.msie)
	{
		this.keydown(function(e) {
			if(key(e) == 8)
			{
				var val = this.value;

				if(val.length == 0 && defaults.previous)
					defaults.previous.focus();
			}
		});
	}

	return this.keypress(function(e) {
		if(key(e) == 8)
		{
			var val = this.value;

			if(val.length == 0 && defaults.previous)
				defaults.previous.focus();
		}
	}).keyup(function(e) {
		var val = this.value;

		switch(defaults.format)
		{
			case 'text':
				var pattern = new RegExp('[0-9]+', 'g');
				var val = val.replace(pattern, '');
				break;

			case 'alphaupper':
				var pattern = new RegExp('[^a-zA-Z]+', 'g');
				var val = val.replace(pattern, '');
				if(defaults.uppercase)
				val = val.toUpperCase();
				break;

			case 'alphaupperspace':
				var pattern = new RegExp('[^a-zA-Z ]+', 'g');
				var val = val.replace(pattern, '');
				if(defaults.uppercase)
				val = val.toUpperCase();
				break;

			case 'alphalower':
				var pattern = new RegExp('[^a-zA-Z]+', 'g');
				var val = val.replace(pattern, '');
				if(defaults.lowercase)
				val = val.toLowerCase();
				break;

			case 'alpha':
				var pattern = new RegExp('[^a-zA-Z]+', 'g');
				var val = val.replace(pattern, '');
				break;
			case 'alphas':
				var pattern = new RegExp('[^a-zA-Z ]+', 'g');
				var val = val.replace(pattern, '');
				break;
			case 'number':
			case 'numeric':
				var pattern = new RegExp('[^0-9]+', 'g');
				var val = val.replace(pattern, '');
				break;
			case 'telphone':
				var pattern = new RegExp('[^0-9- +]+', 'g');
				var val = val.replace(pattern, '');
				break;
			case 'alphanumeric':
				var pattern = new RegExp('[^0-9a-zA-Z]+', 'g');
				var val = val.replace(pattern, '');
				break;

			case 'all':
			default:
				break;
		}

		if(defaults.nospace)
		{
			pattern = new RegExp('[ ]+', 'g');
			val = val.replace(pattern, '');
		}

		
		

		this.value = val;

		/**
		 * Do not auto tab when the following keys are pressed
		 * 8:	Backspace
		 * 9:	Tab
		 * 16:	Shift
		 * 17:	Ctrl
		 * 18:	Alt
		 * 19:	Pause Break
		 * 20:	Caps Lock
		 * 27:	Esc
		 * 33:	Page Up
		 * 34:	Page Down
		 * 35:	End
		 * 36:	Home
		 * 37:	Left Arrow
		 * 38:	Up Arrow
		 * 39:	Right Arrow
		 * 40:	Down Arroww
		 * 45:	Insert
		 * 46:	Delete
		 * 144:	Num Lock
		 * 145:	Scroll Lock
		 */
		var keys = [8, 9, 16, 17, 18, 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];
		var string = keys.toString();

		if(string.indexOf(key(e)) == -1 && val.length == defaults.maxlength && defaults.target)
			defaults.target.focus();
	});
};

})(jQuery);
