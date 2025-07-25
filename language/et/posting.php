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
	'HIDE' => 'Peida',
        'HIDE_HELPLINE' => '[hide]Tekst[/hide], [hide=guests]Tekst[/hide], [hide=inline]Tekst[/hide] või [hide=guests-inline]Tekst[/hide]',
        'HIDDEN_CONTENT' => 'Peidetud sisu',
        'HIDDEN_CONTENT_VISIBLE_GUESTS' => 'Sisu nähtav kõigile sisse logitud kasutajatele!',
        'HIDDEN_CONTENT_VISIBLE_POSTERS' => 'Sisu nähtav selle arutelu osalejatele!',
        'HIDDEN_CONTENT_EXPLAIN' => 'Sisu sisselogitud kasutajatele.'
]);
