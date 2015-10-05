<?php

/**
 * @file ShariffSettingsForm.inc.php
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.shariff
 * @class ShariffSettingsForm
 *
 * @brief Form for adding/editing the settings for the Shariff plugin
 */

import('lib.pkp.classes.form.Form');

class ShariffSettingsForm extends Form {
	/** @var Press The press associated with the plugin being edited */
	var $_press;

	/** @var Plugin The plugin being edited */
	var $_plugin;

	/**
	 * Constructor.
	 * @param $plugin Plugin
	 * @param $press Press
	 */
	function ShariffSettingsForm($plugin, $press) {
		parent::Form($plugin->getTemplatePath() . 'settings.tpl');
		$this->setPress($press);
		$this->setPlugin($plugin);

		$this->setData('pluginJavaScriptPath', $plugin->getPluginPath());

		// Validation checks for this form
		$this->addCheck(new FormValidator($this, 'selectedServices', 'required', 'plugins.generic.shariff.form.selectedServicesRequired'));
		$this->addCheck(new FormValidator($this, 'position', 'required', 'plugins.generic.shariff.form.positionRequired'));
		$this->addCheck(new FormValidatorPost($this));
	}

	//
	// Getters and Setters
	//
	/**
	 * Get the Press.
	 * @return Press
	 */
	function getPress() {
		return $this->_press;
	}

	/**
	 * Set the Press.
	 * @param $press Press
	 */
	function setPress($press) {
		$this->_press = $press;
	}

	/**
	 * Get the plugin.
	 * @return ShariffPlugin
	 */
	function getPlugin() {
		return $this->_plugin;
	}

	/**
	 * Set the plugin.
	 * @param $plugin ShariffPlugin
	 */
	function setPlugin($plugin) {
		$this->_plugin = $plugin;
	}

	//
	// Overridden template methods
	//
	/**
	 * Fetch the form.
	 * @see Form::fetch()
	 * @param $request PKPRequest
	 */
	function fetch($request) {
		$press = $this->getPress();
		$plugin = $this->getPlugin();

		// array of available themes
		$themes = array(
			SHARIFF_THEME_STANDARD => "plugins.generic.shariff.form.theme.standard",
			SHARIFF_THEME_GREY => "plugins.generic.shariff.form.theme.grey",
			SHARIFF_THEME_WHITE => "plugins.generic.shariff.form.theme.white"
		);
		// array of possible orientations
		$orientations = array(
			SHARIFF_ORIENTATION_H => "plugins.generic.shariff.form.orientation.horizontal",
			SHARIFF_ORIENTATION_V => "plugins.generic.shariff.form.orientation.vertical"
		);
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('pluginName', $plugin->getName());
		$templateMgr->assign('themes', $themes);
		$templateMgr->assign('orientations', $orientations);
		$templateMgr->assign('js1', 'lib/pkp/js/lib/jquery/plugins/jquery.tablednd.js');
		$templateMgr->assign('js2', 'lib/pkp/js/functions/tablednd.js');
		return parent::fetch($request);
	}

	/**
	 * Initialize form data from the plugin.
	 */
	function initData() {
		$press = $this->getPress();
		$plugin = $this->getPlugin();
		foreach($this->_getFormFields() as $fieldName => $fieldType) {
			if ($fieldName == 'services') {
				$services = $plugin->getSetting($press->getId(), $fieldName);
				if (empty($services)) {
					$services = array(
						array("addthis" => "plugins.generic.shariff.form.service.addthis"),
						array("facebook" => "plugins.generic.shariff.form.service.facebook"),
						array("googleplus" => "plugins.generic.shariff.form.service.googleplus"),
						array("info" => "plugins.generic.shariff.form.service.info"),
						array("linkedin" => "plugins.generic.shariff.form.service.linkedin"),
						array("mail" => "plugins.generic.shariff.form.service.mail"),
						array("piterest" => "plugins.generic.shariff.form.service.pinterest"),
						array("twitter" => "plugins.generic.shariff.form.service.twitter"),
						array("whatsapp" => "plugins.generic.shariff.form.service.whatsapp"),
						array("xing" => "plugins.generic.shariff.form.service.xing")
					);
				}
				$this->setData($fieldName, $services);
			} else {
				$this->setData($fieldName, $plugin->getSetting($press->getId(), $fieldName));
			}
		}
	}

	/**
	 * Assign form data to user-submitted data.
	 * @see Form::readInputData()
	 */
	function readInputData() {
		$this->readUserVars(array_keys($this->_getFormFields()));
	}

	/**
	 * Save the plugin's data.
	 * @see Form::execute()
	 */
	function execute() {
		$press = $this->getPress();
		$plugin = $this->getPlugin();
		foreach($this->_getFormFields() as $fieldName => $fieldType) {
			$plugin->updateSetting($press->getId(), $fieldName, $this->getData($fieldName), $fieldType);
		}
	}

	//
	// Private helper methods
	//
	/**
	 * Get all form fields and their types
	 * @return array
	 */
	function _getFormFields() {
		return array(
			'services' => 'object',
			'selectedServices' => 'object',
			'selectedTheme' => 'string',
			'selectedOrientation' => 'string',
			'backendUrl' => 'string',
			'position' => 'string'
		);
	}

}
?>
