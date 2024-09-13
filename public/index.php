<?php session_start();

/**
 * @brief Sabo framework entrypoint
 * @author yahaya https://github.com/yahvya
 */

# --------------------------------------------------------------------
# define consts
# --------------------------------------------------------------------

/**
 * @const app root path
 * @attention without / at the end
 */

use SaboCore\Application\Application\Application;

const APP_ROOT = __DIR__ . "/..";

# --------------------------------------------------------------------
# load autoloader
# --------------------------------------------------------------------

require_once APP_ROOT . "/sabo-core/vendor/autoload.php";
require_once APP_ROOT . "/vendor/autoload.php";

# --------------------------------------------------------------------
# launch app
# --------------------------------------------------------------------

(new Application)->launchWeb();
