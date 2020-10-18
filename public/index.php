<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// セッション設定
session_start();

// コンスタントの定義
define('ROOT_DIR', '..' . DIRECTORY_SEPARATOR);
define('PUBIC_DIR', '.' . DIRECTORY_SEPARATOR);
define('VENDOR_DIR', ROOT_DIR . 'vendor' . DIRECTORY_SEPARATOR);

// autoload.php ロード
require_once(VENDOR_DIR . 'autoload.php');

// 環境変数を使うため、dotenvライブラリーロード
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load('../.env');

// XSS攻撃防止のための関数
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// ビューに渡すデータの配列
$data = [];

// リクエストURIをクエリとパスに区分
$requestURI = explode('?', $_SERVER['REQUEST_URI']);
$query = isset($requestURI[1]) ? $requestURI[1] : '';
$path = $requestURI[0];

// パスが / で終わった場合、 index.php を追加
if ($path[-1] === '/') {
    $path .= 'index.php';
}

// パスに .php が省略されている場合、 .php を追加
if (!strpos($path, '.php')) {
    $path .= '.php';
}

// パスの特定
$controllerPath = ROOT_DIR . 'controllers' . $path;
$viewPath = ROOT_DIR . 'views' . $path;
$errorPath = PUBIC_DIR . 'error.php';

// コントローラが存在している場合
if (file_exists($controllerPath)) {
    include($controllerPath);
    $controllerPathList = explode('/', $controllerPath);

    $className = '';
    $classPath = 'App\\Controllers\\';
    for ($i = 2; $i < count($controllerPathList); $i++) {
        $ucFirst = ucfirst($controllerPathList[$i]);
        $className .= $ucFirst;

        if ($i !== count($controllerPathList) - 1) {
            $classPath .= $ucFirst . '\\';
        }
    }
    $className = $classPath . str_replace('.php', 'Controller', $className);    
    if (class_exists($className)) {
        $obj = new $className;
        if (isset($obj->viewPath) && $obj->viewPath !== '') {
            $viewPath = ROOT_DIR . 'views' . $obj->viewPath;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // GETの際に　csrf_token を発行し、セッションに保存すること
            $toke_byte = openssl_random_pseudo_bytes(16);
            $csrf_token = bin2hex($toke_byte);
            $_SESSION['csrf_token'] = $csrf_token;
            $obj->get();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRFエラーが発生した場合
            if (!(isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token'])) {
                $_SESSION['error'] = 'HTTP/1.0 403 Invalid CSRF Token';
                include($errorPath);
                die();
            }

            $obj->post();
        }
        $data = $obj->data;
    }
}

// ビューは存在している場合
if (file_exists($viewPath)) {
    include($viewPath);
    exit();
}

// コントローラもビューもない場合
$_SESSION['error'] = 'HTTP/1.0 404 Not Found';
include($errorPath);
die();