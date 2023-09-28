<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', boolval($_ENV['YII_DEBUG']));
defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);

session_save_path (__DIR__ . '/../tmp' );

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
