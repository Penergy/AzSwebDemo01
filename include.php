<?php 
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
// session_start();
define("ROOT",dirname(__FILE__));
set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.ROOT."/src/server".PATH_SEPARATOR.ROOT."/config".PATH_SEPARATOR.get_include_path());
require_once 'mysql.func.php';
require_once "configs.php";
// require_once 'SwooleServer.php';
// require_once 'astack.func.php';
// require_once 'istack.func.php';
// require_once 'string.func.php';
// require_once 'page.func.php';
// require_once 'admin.inc.php';
// require_once 'cate.inc.php';
// require_once 'pro.inc.php';
// require_once 'album.inc.php';
// require_once 'upload.func.php';
// require_once 'user.inc.php';
// require_once 'galaxy.func.php';
$appsetting = getenv("MYSQLCONNSTR_test");
connectForAzure($appsetting);
