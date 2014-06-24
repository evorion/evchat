<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Evorion.' . $_EXTKEY,
	'Evchatfe',
	array(
		'Conversation'	=> 'show, list, new, create, edit, update, delete',
		'Message'		=> 'create, list',
		'Event'			=> 'list'
	),
	// non-cacheable actions
	array(
		'Conversation'	=> 'show, list, new, create, edit, update, delete',
		'Message'		=> 'create, list',
		'Event'			=> 'list'
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder