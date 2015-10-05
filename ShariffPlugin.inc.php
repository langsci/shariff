<?php

/**
 * @file StaticPagesPlugin.inc.php
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.shariff
 * @class ShariffPlugin
 * Shariff plugin main class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

define('SHARIFF_POSITION_FOOTER', 'allfooter');
define('SHARIFF_POSITION_BOOKSHARETAB', 'booksharetab');
define('SHARIFF_POSITION_BLOCK', 'block');

define('SHARIFF_THEME_STANDARD', 'standard');
define('SHARIFF_THEME_GREY', 'grey');
define('SHARIFF_THEME_WHITE', 'white');

define('SHARIFF_ORIENTATION_V', 'vertical');
define('SHARIFF_ORIENTATION_H', 'horizontal');

class ShariffPlugin extends GenericPlugin {

	/**
	 * @copydoc PKPPlugin::getDisplayName()
	 */
	function getDisplayName() {
		return __('plugins.generic.shariff.displayName');
	}

	/**
	 * @copydoc PKPPlugin::getDescription()
	 */
	function getDescription() {
		return __('plugins.generic.shariff.description');
	}

	/**
	 * @copydoc PKPPlugin::register()
	 */
	function register($category, $path) {
		if (parent::register($category, $path)) {
			if ($this->getEnabled()) {
				$request = $this->getRequest();
				$press = $request->getPress();
				$pressId = $press->getId();

				if ($this->getSetting($pressId, 'selectedServices')) {
					if ($this->getSetting($pressId, 'position') == SHARIFF_POSITION_BLOCK) {
						// Register shariff block plugin
						HookRegistry::register('PluginRegistry::loadCategory', array($this, 'callbackLoadCategory'));
					} elseif ($this->getSetting($pressId, 'position') == SHARIFF_POSITION_BOOKSHARETAB) {
						/* Register for the hook in the share tab on the book view page */
						HookRegistry::register('Templates::Catalog::Book::BookInfo::Sharing',array(&$this, 'addShariffButtons'));
					} else {
						/* Register for the hook in footer */
						HookRegistry::register ('Templates::Common::Footer::PageFooter', array(&$this, 'addShariffButtons'));
					}
					// Hook for article view -- add css in the article header template
					HookRegistry::register ('TemplateManager::display', array($this, 'handleTemplateDisplay'));
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * @see PluginRegistry::loadCategory()
	 */
	function callbackLoadCategory($hookName, $args) {
		$plugin = null;
		$category = $args[0];
		if ($category ==  'blocks') {
			$this->import('ShariffBlockPlugin');
			$plugin = new ShariffBlockPlugin($this->getName());
		}
		if ($plugin) {
			$seq = $plugin->getSeq();
			$plugins =& $args[1];
			if (!isset($plugins[$seq])) $plugins[$seq] = array();
			$plugins[$seq][$this->getPluginPath()] = $plugin;
		}
		return false;
	}

	/**
	 * Handle article view header template display.
	 */
	function handleTemplateDisplay($hookName, $params) {
		$smarty =& $params[0];
		$template =& $params[1];
		HookRegistry::register ('TemplateManager::include', array($this, 'addCss'));
		return false;
	}

	/**
	 * Add Shariff CSS to the header.
	 */
	function addCss($hookName, $args) {
		$smarty =& $args[0];
		$params =& $args[1];

		$request = $this->getRequest();
		$press = $request->getPress();
		$pressId = $press->getId();

		$position = $this->getSetting($pressId, 'position');
		$baseUrl = $request->getBaseUrl();
		if ($params['smarty_include_tpl_file'] == 'core:common/headerHead.tpl') {
			$stylesheets = $smarty->get_template_vars('stylesheets');
			$shariffCSS = array(
				$baseUrl . '/' . $this->getPluginPath() . '/shariff.complete.css',
				$baseUrl . '/' . $this->getPluginPath() . '/shariff.omp.css'
			);
			array_unshift($stylesheets, $shariffCSS);
			$smarty->assign('stylesheets', $stylesheets);
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
		$pressId = $press->getId();

		// get the selected settings
		// services
		$selectedServices = $this->getSetting($pressId, 'selectedServices');
		$preparedServices = array_map(create_function('$arrayElement', 'return \'&quot;\'.$arrayElement.\'&quot;\';'), $selectedServices);
		$dataServicesString = implode(",", $preparedServices);
		// theme
		$selectedTheme = $this->getSetting($pressId, 'selectedTheme');
		// orientation
		$selectedOrientation = $this->getSetting($pressId, 'selectedOrientation');
		// backend URL
		$backendUrl = $this->getSetting($pressId, 'backendUrl');

		$locale = AppLocale::getLocale();
		$iso1Lang = AppLocale::getIso1FromLocale($locale);
		$requestedUrl = $request->getCompleteUrl();
		$baseUrl = $request->getBaseUrl();

		$output .= '
		<br /><br />
		<div class="shariff" data-lang="'. $iso1Lang.'"
		data-services="['.$dataServicesString.']"
		data-backend-url="'.$backendUrl.'"
		data-theme="'.$selectedTheme.'"
		data-orientation="' .$selectedOrientation.'"
		data-url="'. $requestedUrl .'">
		</div>
		<script src="'. $baseUrl .'/'. $this->getPluginPath().'/shariff.complete.js"></script>';

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
	 * @copydoc Plugin::getContextSpecificPluginSettingsFile()
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * @copydoc PKPPlugin::getTemplatePath
	 */
	function getTemplatePath() {
		return parent::getTemplatePath() . 'templates/';
	}

}

?>
