<?php
/**
 * Hide extension for phpBB.
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = [];
}

$lang = array_merge($lang, [
    'HIDE' => 'Cacher',
    'HIDE_HELPLINE' => 'Usage : [hide]texte[/hide] ou [hide inline=1]texte[/hide]',
    'HIDDEN_CONTENT' => 'Contenu caché',
    'HIDDEN_CONTENT_EXPLAIN' => 'Vous devez participer à cette discussion pour voir le contenu caché.'
]);

