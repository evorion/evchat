<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Evorion.' . $_EXTKEY,
	'Evchatfe',
	array(
		'Conversation' => 'show, list, new, create, edit, update, delete',

	),
	// non-cacheable actions
	array(
		'Conversation' => 'create, update, delete',

	)
);
