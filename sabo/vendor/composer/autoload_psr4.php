<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Twig\\' => array($vendorDir . '/twig/twig/src'),
    'Symfony\\Polyfill\\Mbstring\\' => array($vendorDir . '/symfony/polyfill-mbstring'),
    'Symfony\\Polyfill\\Ctype\\' => array($vendorDir . '/symfony/polyfill-ctype'),
    'Sabo\\Utils\\String\\' => array($baseDir . '/utils/string'),
    'Sabo\\Sabo\\' => array($baseDir . '/sabo'),
    'Sabo\\Model\\System\\QueryBuilder\\' => array($baseDir . '/model/system/query-builder'),
    'Sabo\\Model\\System\\Postgre\\' => array($baseDir . '/model/system/postgre'),
    'Sabo\\Model\\System\\Mysql\\' => array($baseDir . '/model/system/mysql'),
    'Sabo\\Model\\System\\Interface\\' => array($baseDir . '/model/system/interface'),
    'Sabo\\Model\\Model\\' => array($baseDir . '/model/model'),
    'Sabo\\Model\\Exception\\' => array($baseDir . '/model/exception'),
    'Sabo\\Model\\Cond\\' => array($baseDir . '/model/cond'),
    'Sabo\\Model\\Attribute\\' => array($baseDir . '/model/attribute'),
    'Sabo\\Middleware\\Middleware\\' => array($baseDir . '/middleware/middleware'),
    'Sabo\\Middleware\\Exception\\' => array($baseDir . '/middleware/exception'),
    'Sabo\\Mailer\\' => array($baseDir . '/mailer'),
    'Sabo\\Helper\\' => array($baseDir . '/helper'),
    'Sabo\\Exception\\' => array($baseDir . '/exception'),
    'Sabo\\DefaultPage\\' => array($baseDir . '/default-page'),
    'Sabo\\Controller\\TwigExtension\\' => array($baseDir . '/controller/twig-extension'),
    'Sabo\\Controller\\Controller\\' => array($baseDir . '/controller/controller'),
    'Sabo\\Config\\' => array($baseDir . '/config'),
    'Sabo\\Cli\\' => array($baseDir . '/cli'),
    'PHPMailer\\PHPMailer\\' => array($vendorDir . '/phpmailer/phpmailer/src'),
);
