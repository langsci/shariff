<?php

/**
 * @file plugins/generic/shariff/ShariffSettingsForm.inc.php
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ShariffSettingsForm
 * @ingroup plugins_generic_Shariff
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

		// Validation checks for this form
		$this->addCheck(new FormValidatorPost($this));
	}
	
	
	/**
	 * Fetch the form.
	 * @see Form::fetch()
	 * @param $request PKPRequest
	 */
	function fetch($request) {
		$press = $this->getPress();
		$plugin = $this->getPlugin();

		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $plugin->getName());
		$templateMgr->assign('pluginBaseUrl', $request->getBaseUrl() . '/' . $plugin->getPluginPath());

		foreach ($this->_data as $key => $value) {
			$templateMgr->assign($key, $value);
		}

		return $templateMgr->fetch($plugin->getTemplatePath() . 'settings.tpl');
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
	 * @param Press
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
	 * @param ShariffPlugin $plugin
	 */
	function setPlugin($plugin) {
		$this->_plugin = $plugin;
	}

	//
	// Overridden template methods
	//
	/**
	 * Initialize form data from the plugin.
	 */
	function initData() {
		$press = $this->getPress();
		$plugin = $this->getPlugin();
		
	/*	foreach($this->_getFormFields() as $fieldName => $fieldType) {
			$this->setData($fieldName, $plugin->getSetting($press, $fieldName));
		}
	
	*/
	
		if (isset($plugin)) {
			
			// array of available languages
			$languages = array(
				"en" => "plugins.generic.shariff.form.language.en",
				"de" => "plugins.generic.shariff.form.language.de",
			//	"es" => "plugins.generic.shariff.form.language.es"
			);
			
			// array of available themes
			$themes = array(
				"standard" => "plugins.generic.shariff.form.theme.standard",
				"grey" => "plugins.generic.shariff.form.theme.grey",
				"white" => "plugins.generic.shariff.form.theme.white"
			);
			
			// variables for the template
			$this->_data = array(
				'languages' => $languages,
				'selectedLanguage' =>  $press->getSetting('selectedLanguage'),
				'themes' => $themes,
				'selectedTheme' =>  $press->getSetting('selectedTheme'),
				'facebook' => $press->getSetting('facebook'),
				'twitter' => $press->getSetting('twitter'),
				'googleplus' => $press->getSetting('googleplus'),
				'mail' => $press->getSetting('mail'),
				'info' => $press->getSetting('info'),
				'backend' => $press->getSetting('backend'),
				
			);
		}
		
	}


	/**
	 * Assign form data to user-submitted data.
	 * @see Form::readInputData()
	 */
	function readInputData() {
		
	//	$this->readUserVars(array_keys($this->_getFormFields()));
		
		$this->readUserVars(array(
			'selectedLanguage',
			'selectedTheme',
			'facebook',
			'twitter',
			'googleplus',
			'mail',
			'info',
			'backend'
		));
	
	}

	/**
	 * Save the plugin's data.
	 * @see Form::execute()
	 */
	function execute() {
		$press = $this->getPress();
		$plugin = $this->getPlugin();
		
	/*	foreach($this->_getFormFields() as $fieldName => $fieldType) {
			$plugin->updateSetting($press, $fieldName, $this->getData($fieldName), $fieldType);
		}
	*/

		$press->updateSetting('selectedLanguage', $this->getData('selectedLanguage'), 'string');
		$press->updateSetting('selectedTheme', $this->getData('selectedTheme'), 'string');
		$press->updateSetting('facebook', $this->getData('facebook'), 'bool');
		$press->updateSetting('twitter', $this->getData('twitter'), 'bool');
		$press->updateSetting('googleplus', $this->getData('googleplus'), 'bool');
		$press->updateSetting('mail', $this->getData('mail'), 'bool');
		$press->updateSetting('info', $this->getData('info'), 'bool');
		$press->updateSetting('backend', $this->getData('backend'), 'string');
	
	}
	
	//
	// Private helper methods
	//
	function _getFormFields() {
		return array(
			'selectedLanguage' => 'string',
			'selectedTheme' => 'string',
			'facebook' => 'bool',
			'twitter' => 'bool',
			'googleplus' => 'bool',
			'mail' => 'bool',
			'info' => 'bool',
			'backend' => 'string',
		);
	}
	
	
	
}
?>
