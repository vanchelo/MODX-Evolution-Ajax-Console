<?php
if (!defined('MODX_START_TIME')) {
    define('MODX_START_TIME', microtime(1));
}

if (!defined('IN_MANAGER_MODE')) {
    die;
}

define('MODX_API_MODE', true);

require_once MODX_BASE_PATH . '/assets/modules/console/console.class.php';

$console = new Console($modx);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = isset($_POST['code']) ? (string) $_POST['code'] : '';

    // Execute and profile the code
    $console->execute($code);
    die;
}

echo $console->render();
