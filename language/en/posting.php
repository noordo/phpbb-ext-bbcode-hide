<?php

/**
 * Extension "[Hide] avancé" pour phpBB.
 * @author Noordo <https://github.com/noordo>
 * @copyright 2025 Noordo
 * @license GPL-2.0-only
 *
 * Adaptation de l'extension "Hide extension for phpBB"
 * d'Alfredo Ramos <alfredo.ramos@proton.me>
 * @copyright 2017 Alfredo Ramos
**/

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
       'HIDE_HELPLINE' => 'Usage: [hide]text[/hide], [hide=guests]text[/hide], [hide=inline]text[/hide] or [hide=guests-inline]text[/hide]',
       'HIDDEN_CONTENT' => 'Hidden content',
       'HIDDEN_CONTENT_VISIBLE_GUESTS' => 'Content visible to all logged-in users!',
       'HIDDEN_CONTENT_VISIBLE_POSTERS' => 'Content visible to the participants of this discussion!',
       'HIDDEN_CONTENT_EXPLAIN' => 'You must participate in this discussion to view hidden content.'
]);
