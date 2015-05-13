<?php

/**
 * @file StaticPagesPlugin.inc.php
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.staticPages
 * @class ShariffPlugin
 * Static pages plugin main class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class ShariffPlugin extends GenericPlugin {

	/**
	 * Get the plugin's display (human-readable) name.
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.shariff.displayName');
	}

	/**
	 * Get the plugin's display (human-readable) description.
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.shariff.description');
	}

	/**
	 * Register the plugin, attaching to hooks as necessary.
	 * @param $category string
	 * @param $path string
	 * @return boolean
	 */
	function register($category, $path) {

		if (parent::register($category, $path)) {
			if ($this->getEnabled()) {
				/* call hook in footer */
				HookRegistry::register ('Templates::Common::Footer::PageFooter', array(&$this, 'addShariffButtons'));
			}
			return true;
		}
		return false;
	}
	


	/**
	 * Hook callback: Handle requests.
	 * @param $hookName string The name of the hook being invoked
	 * @param $args array The parameters to the invoked hook
	 */
	function addShariffButtons($hookName, $args) {
		$template =& $args[1];
		$output =& $args[2];
		
		$request = $this->getRequest();
		$press = $request->getPress();
		
		// get all selected data services from settings
		$dataServicesArray = array();
				
		if($press->getSetting('facebook')){ 
			array_push($dataServicesArray, "&quot;facebook&quot;"); 
		}
		if($press->getSetting('twitter')){ 
			array_push($dataServicesArray, "&quot;twitter&quot;"); 
		}
		if($press->getSetting('googleplus')){ 
			array_push($dataServicesArray, "&quot;googleplus&quot;"); 
		}
		if($press->getSetting('mail')){ 
			array_push($dataServicesArray, "&quot;mail&quot;"); 
		}
		if($press->getSetting('info')){ 
			array_push($dataServicesArray, "&quot;info&quot;"); 
		}
		
		$dataServicesString = implode(",", $dataServicesArray);
		
		// get the selected language and theme from settings
		$selectedLanguage = $press->getSetting('selectedLanguage');
		$selectedTheme = $press->getSetting('selectedTheme');
		$backendUrl = $press->getSetting('backend');
	
		$output .= '
		<link rel="stylesheet" href="'. Request::getBaseUrl() .'/'. $this->getPluginPath().'/shariff.min.css" type="text/css" />
		<div class="shariff" data-lang="'. $selectedLanguage.'"
		data-services="['.$dataServicesString.']"  
		data-backend-url="'.$backendUrl.'" 
		data-theme="'.$selectedTheme.'" 
		data-url="'. Request::getBaseUrl() .'">
		</div> 
		<script src="'. Request::getBaseUrl() .'/'. $this->getPluginPath().'/shariff.complete.js"></script>';
		
		return false;
	}
	
	/**
	 * @copydoc PKPPlugin::getManagementVerbs()
	 */
	function getManagementVerbs() {
		$verbs = parent::getManagementVerbs();
		if ($this->getEnabled()) {
			$verbs[] = array('settings', __('plugins.generic.shariff.settings'));
		}
		return $verbs;
	}

	/**
	 * Define management link actions for the settings verb.
	 * @param $request PKPRequest
	 * @param $verb string
	 * @return LinkAction
	 */ 
	function getManagementVerbLinkAction($request, $verb) {
		$router = $request->getRouter();

		list($verbName, $verbLocalized) = $verb;

		if ($verbName === 'settings') {
			import('lib.pkp.classes.linkAction.request.AjaxLegacyPluginModal');
			$actionRequest = new AjaxLegacyPluginModal(
				$router->url($request, null, null, 'plugin', null, array('verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic')),
				$this->getDisplayName()
			);
			return new LinkAction($verbName, $actionRequest, $verbLocalized, null);
		}

		return null;
	}

	/**
	 * @copydoc PKPPlugin::manage()
	 */
	function manage($verb, $args, &$message, &$messageParams, &$pluginModalContent = null) {
		$request = $this->getRequest();
		$press = $request->getPress();
		$templateMgr = TemplateManager::getManager($request);

		switch ($verb) {

			case 'settings':
					$this->import('ShariffSettingsForm');
					$form = new ShariffSettingsForm($this, $press);
					if ($request->getUserVar('save')) {
						$form->readInputData();
						if ($form->validate()) {
							$form->execute();
							$message = NOTIFICATION_TYPE_SUCCESS;
							$messageParams = array('contents' => __('plugins.generic.shariff.form.saved'));
							return false;
						} else {
							$pluginModalContent = $form->fetch($request);
						}
					} else {
						$form->initData();
						$pluginModalContent = $form->fetch($request);
					}

				return true;


			default:
				// let the parent handle it.
				return parent::manage($verb, $args, $message, $messageParams);
		}
	}


	/**
	 * Get the name of the settings file to be installed on new press
	 * creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the filename of the ADODB schema for this plugin.
	 * @return string Full path and filename to schema descriptor.
	 *//*
	function getInstallSchemaFile() {
		return $this->getPluginPath() . '/schema.xml';
	}*/

	/**
	 * @copydoc PKPPlugin::getTemplatePath
	 */
	function getTemplatePath() {
		return parent::getTemplatePath() . 'templates/';
	}
	
	/**
	 * Get the name and the path of the css file.
	 * @return string
	 */
	function getStyleSheet(){
		return $this->getPluginPath() . '/css/shariff.min.css';
	}

	/**
	 * Get the JavaScript URL for this plugin.
	 *//*
	function getJavaScriptURL($request) {
		return $request->getBaseUrl() . '/' . $this->getPluginPath() . '/js';
	}*/
}

?>
