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
	'HIDE' => 'Ocultar',
	'HIDE_HELPLINE' => 'Uso: [hide]texto[/hide] ou [hide inline=1]texto[/hide]',
	'HIDDEN_CONTENT' => 'Conteúdo oculto',
	'HIDDEN_CONTENT_EXPLAIN' => 'Conteúdo exclusivo para usuários logados.'
]);
