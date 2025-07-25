<?php
// Si on est exécuté dans un contexte phpBB complet
$phpbbBootstrap = __DIR__ . '/../../../../tests/bootstrap.php';
if (file_exists($phpbbBootstrap)) {
    require $phpbbBootstrap;
    return;
}

// Sinon, fallback minimal pour exécuter des tests basiques
require __DIR__ . '/../vendor/autoload.php';
define('IN_PHPBB', true);
