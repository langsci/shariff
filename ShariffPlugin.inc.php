<?php

/**
 * @file plugins/generic/shariff/ShariffPlugin.inc.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ShariffPlugin
 * @ingroup plugins_block_shariff
 *
 * @brief Shariff plugin class
 */
 
import('lib.pkp.classes.plugins.GenericPlugin');

class ShariffPlugin extends GenericPlugin {
	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.shariff.displayName');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.shariff.description');
	}

	function register($category, $path) {
		if (parent::register($category, $path)) {
			if ($this->getEnabled()) {
			//	HookRegistry::register('TemplateManager::display',array($this, 'callbackAddLinks'));
			//	HookRegistry::register('PluginRegistry::loadCategory', array($this, 'callbackLoadCategory'));
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
		$baseUrl = $request->getBaseUrl();
	
		/**
		<div class="shariff" data-lang="'. $selectedLanguage.'"
		data-services="['.$dataServicesString.']"  
		data-backend-url="'.$backendUrl.'" 
		data-theme="'.$selectedTheme.'" 
		data-url="'. $baseUrl .'">
		</div> 
		*/
		
		$output .= '
		<link rel="stylesheet" href="'. $baseUrl .'/'. $this->getPluginPath().'/shariff.min.css" type="text/css" />
		<script src="'. $baseUrl .'/'. $this->getPluginPath().'/shariff.complete.js"></script>';
		
		return false;
	}

	/**
	 * Get the name of the settings file to be installed on new context
	 * creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
	//	return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * @copydoc PKPPlugin::getTemplatePath()
	 */
	function getTemplatePath($inCore = false) {
		return parent::getTemplatePath($inCore) . 'templates/';
	}

	/**
	 * Register as a block plugin, even though this is a generic plugin.
	 * This will allow the plugin to behave as a block plugin, i.e. to
	 * have layout tasks performed on it.
	 * @param $hookName string
	 * @param $args array
	 */
	function callbackLoadCategory($hookName, $args) {
		$category =& $args[0];
		$plugins =& $args[1];
		
		// langsci_debug($this->getName());
		
		switch ($category) {
			case 'blocks':
				$this->import('ShariffBlockPlugin');
				$blockPlugin = new ShariffBlockPlugin($this->getName());
				$plugins[$blockPlugin->getSeq()][$blockPlugin->getPluginPath()] = $blockPlugin;
				break;
			case 'gateways':
				$this->import('ShariffGatewayPlugin');
				$gatewayPlugin = new ShariffGatewayPlugin($this->getName());
				$plugins[$gatewayPlugin->getSeq()][$gatewayPlugin->getPluginPath()] = $gatewayPlugin;
				break;
		}
		return false;
	}

	/**
	 * Add feed links to page <head> on select/all pages.
	 */
	function callbackAddLinks($hookName, $args) {
		// Only page requests will be handled
		$request = $this->getRequest();
		if (!is_a($request->getRouter(), 'PKPPageRouter')) return false;

		$templateManager =& $args[0];
		$currentPress = $templateManager->get_template_vars('currentPress');
		$requestedPage = $request->getRequestedPage();
		$displayPage = $this->getSetting($currentPress->getId(), 'displayPage');

		if (	$displayPage == 'all' ||
			($displayPage == 'homepage' && (empty($requestedPage) || $requestedPage == 'index'))
		) {
			$templateManager->assign(
				'additionalHeadData',
				$templateManager->get_template_vars('additionalHeadData') . '
				<link rel="alternate" type="application/atom+xml" href="' . $request->url(null, 'gateway', 'plugin', array('ShariffGatewayPlugin', 'atom')) . '" />
				'
			);
		}
		
		// <link rel="alternate" type="application/rdf+xml" href="'. $request->url(null, 'gateway', 'plugin', array('ShariffGatewayPlugin', 'rss')) . '" />
		//<link rel="alternate" type="application/rss+xml" href="'. $request->url(null, 'gateway', 'plugin', array('ShariffGatewayPlugin', 'rss2')) . '" />
		return false;
	}

	/**
	 * @see Plugin::getActions()
	 */
/*	function getActions($request, $verb) {
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		return array_merge(
			$this->getEnabled()?array(
				new LinkAction(
					'settings',
					new AjaxModal(
						$router->url($request, null, null, 'manage', null, array('verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic')),
						$this->getDisplayName()
					),
					__('manager.plugins.settings'),
					null
				),
			):array(),
			parent::getActions($request, $verb)
		);
	}
	*/

 	/**
	 * @see Plugin::manage()
	 */
	function manage($args, $request) {
		switch ($request->getUserVar('verb')) {
			case 'settings':
				$context = $request->getContext();

				AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON,  LOCALE_COMPONENT_PKP_MANAGER);
				$templateMgr = TemplateManager::getManager($request);
				$templateMgr->register_function('plugin_url', array($this, 'smartyPluginUrl'));

				$this->import('SettingsForm');
				$form = new SettingsForm($this, $context->getId());

				if ($request->getUserVar('save')) {
					$form->readInputData();
					if ($form->validate()) {
						$form->execute();
						return new JSONMessage(true);
					}
				} else {
					$form->initData();
				}
				return new JSONMessage(true, $form->fetch($request));
		}
		return parent::manage($args, $request);
	}
}

?>
