<?php


/**
 * Definicja głównych zmiennych głobalnych;
 * SITE_PATH - adres strony,
 * APP_PATH - ścieżka do głównego folderu aplikacji,
 * APP_ASSETS - ścieżka do plików dodatkowych (css, js, image)  
 */

define("SITE_PATH",'http://localhost/radziszewska/');
define("APP_PATH",str_replace("\\", "/", dirname(__FILE__)) . "/");
define("APP_ASSETS",SITE_PATH. 'app/assets');

require_once APP_PATH. 'core/core.php';
$wm_cms  = new WM_CMS();





