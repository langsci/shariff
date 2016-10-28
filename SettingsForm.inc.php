<?php

/**
 * @file plugins/generic/webFeed/SettingsForm.inc.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SettingsForm
 * @ingroup plugins_generic_webFeed
 *
 * @brief Form for managers to modify web feeds plugin settings
 */

import('lib.pkp.classes.form.Form');

class SettingsForm extends Form {

	/** @var int Associated context ID */
	private $_contextId;

	/** @var WebFeedPlugin Web feed plugin */
	private $_plugin;

	/**
	 * Constructor
	 * @param $plugin WebFeedPlugin Web feed plugin
	 * @param $contextId int Context ID
	 */
	function SettingsForm($plugin, $contextId) {
		
		$this->_contextId = $contextId;
		$this->_plugin = $plugin;

		parent::Form($plugin->getTemplatePath() . 'settingsForm.tpl');
		$this->addCheck(new FormValidatorPost($this));
	}

	/**
	 * Initialize form data.
	 */
	function initData() {
		$contextId = $this->_contextId;
		$plugin = $this->_plugin;

		langsci_debug($plugin);
			
		$this->setData('selectedLanguage', $plugin->getSetting($contextId, 'selectedLanguage'));
		$this->setData('selectedTheme', $plugin->getSetting($contextId, 'selectedTheme'));
		$this->setData('facebook', $plugin->getSetting($contextId, 'facebook'));
		$this->setData('twitter', $plugin->getSetting($contextId, 'twitter'));
		$this->setData('googleplus', $plugin->getSetting($contextId, 'googleplus'));
		$this->setData('info', $plugin->getSetting($contextId, 'info'));
		$this->setData('backend', $plugin->getSetting($contextId, 'backend'));
		
		/*	
		$languages = array(
			"en" => "plugins.generic.shariff.form.language.en",
			"de" => "plugins.generic.shariff.form.language.de"
		);
		
		$this->setData('selectedLanguage', $languages);
		
		// array of available languages
		
		$languages = array(
			"en" => "plugins.generic.shariff.form.language.en",
			"de" => "plugins.generic.shariff.form.language.de"
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
			'selectedLanguage' =>  $contextId->getSetting('selectedLanguage'),
			'themes' => $themes,
			'selectedTheme' =>  $contextId->getSetting('selectedTheme'),
			'facebook' => $contextId->getSetting('facebook'),
			'twitter' => $contextId->getSetting('twitter'),
			'googleplus' => $contextId->getSetting('googleplus'),
			'mail' => $contextId->getSetting('mail'),
			'info' => $contextId->getSetting('info'),
			'backend' => $contextId->getSetting('backend'),
			
		);
		
		*/
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		
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
	 * Fetch the form.
	 * @copydoc Form::fetch()
	 */
	function fetch($request) {
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->_plugin->getName());
		return parent::fetch($request);
	}

	/**
	 * Save settings. 
	 */
	function execute() {
		$plugin = $this->_plugin;
		$contextId = $this->_contextId;

		$plugin->updateSetting($contextId, 'selectedLanguage', $this->getData('selectedLanguage'));
		$plugin->updateSetting($contextId, 'selectedTheme', $this->getData('selectedTheme'));
		$plugin->updateSetting($contextId, 'facebook', $this->getData('facebook'));
		$plugin->updateSetting($contextId, 'twitter', $this->getData('twitter'));
		$plugin->updateSetting($contextId, 'googleplus', $this->getData('googleplus'));
		$plugin->updateSetting($contextId, 'mail', $this->getData('mail'));
		$plugin->updateSetting($contextId, 'info', $this->getData('info'));
		$plugin->updateSetting($contextId, 'backend', $this->getData('backend'));
		
	}
}

?>
