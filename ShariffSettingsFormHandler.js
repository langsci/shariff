/**
 * @file ShariffSettingsFormHandler.js
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.shariff
 * @class ShariffSettingsFormHandler
 *
 * @brief Shariff settings page form handler.
 */
(function($) {

	/** @type {Object} */
	$.pkp.plugins.generic.shariff =
		$.pkp.plugins.generic.shariff || { };


	/**
	 * @constructor
	 *
	 * @extends $.pkp.controllers.form.AjaxFormHandler
	 *
	 * @param {jQueryObject} $formElement A wrapped HTML element that
	 *  represents the approved proof form interface element.
	 * @param {Object} options Tabbed modal options.
	 */
	$.pkp.plugins.generic.shariff.ShariffSettingsFormHandler =
			function($formElement, options) {
		this.parent($formElement, options);
		$( 'table tbody' ).sortable();

	};
	$.pkp.classes.Helper.inherits(
			$.pkp.plugins.generic.shariff.ShariffSettingsFormHandler,
			$.pkp.controllers.form.AjaxFormHandler
	);


	$.pkp.plugins.generic.shariff.ShariffSettingsFormHandler.prototype.submitForm =
			function(validator, formElement) {
		this.parent('submitForm', validator, formElement);

		// Cause the sidebar to reload, reflecting any changes.
		$('body').trigger('updateSidebar');
	};
/** @param {jQuery} $ jQuery closure. */
}(jQuery));