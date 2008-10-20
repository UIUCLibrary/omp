<?php

/**
 * @file InformationBlockPlugin.inc.php
 *
 * Copyright (c) 2003-2008 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class InformationBlockPlugin
 * @ingroup plugins_blocks_information
 *
 * @brief Class for information block plugin
 */

// $Id$


import('plugins.BlockPlugin');

class InformationBlockPlugin extends BlockPlugin {
	function register($category, $path) {
		$success = parent::register($category, $path);
		if ($success) {
			$this->addLocaleData();
		}
		return $success;
	}

	/**
	 * Get the name of this plugin. The name must be unique within
	 * its category.
	 * @return String name of plugin
	 */
	function getName() {
		return 'InformationBlockPlugin';
	}

	/**
	 * Install default settings on press creation.
	 * @return string
	 */
	function getNewPressPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return Locale::translate('plugins.block.information.displayName');
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return Locale::translate('plugins.block.information.description');
	}

	/**
	 * Get the supported contexts (e.g. BLOCK_CONTEXT_...) for this block.
	 * @return array
	 */
	function getSupportedContexts() {
		return array(BLOCK_CONTEXT_LEFT_SIDEBAR, BLOCK_CONTEXT_RIGHT_SIDEBAR);
	}

	/**
	 * Get the HTML contents for this block.
	 * @param $templateMgr object
	 * @return $string
	 */
	function getContents(&$templateMgr) {
		$press =& Request::getPress();
		if (!$press) return '';

		$templateMgr->assign('forReaders', $press->getLocalizedSetting('readerInformation'));
		$templateMgr->assign('forAuthors', $press->getLocalizedSetting('authorInformation'));
		$templateMgr->assign('forLibrarians', $press->getLocalizedSetting('librarianInformation'));
		return parent::getContents($templateMgr);
	}
}

?>
