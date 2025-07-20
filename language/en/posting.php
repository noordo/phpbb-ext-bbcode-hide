<?php

/**
 * Hide extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@proton.me>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @ignore
 */
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'HIDE' => 'Hide',
	'HIDE_HELPLINE' => 'Usage: [hide]text[/hide] or [hide inline=1]text[/hide]',
	'HIDDEN_CONTENT' => 'Hidden content',
       'HIDDEN_CONTENT_EXPLAIN' => 'You must participate in this discussion to view hidden content.'
]);
