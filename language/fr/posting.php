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
    'HIDDEN_CONTENT_VISIBLE_GUESTS' => 'Contenu visible par tous les connectés !',
    'HIDDEN_CONTENT_VISIBLE_POSTERS' => 'Contenu visible par les participants à cette discussion !',    
    'HIDDEN_CONTENT_EXPLAIN' => "Vous devez participer à cette discussion pour voir le contenu caché. Il suffit d'écrire : 'Je suis curieux !' ou 'Merci !'. :-)"
]);

