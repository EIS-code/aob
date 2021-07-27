<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */
date_default_timezone_set('Asia/Kolkata');
define('LARAVEL_START', microtime(true));

$valid_ext = array('pdf','doc','docx','rtf','tex','txt','xls','xlsm','xlsx','rar','zip','ai','bmp','gif','ico','jpeg','jpg','png','ps','psd','svg','tif','tiff','aif','cda','mid','midi','mp3','mpa','wav','wma','wpl','3g2','3gp','avi','flv','h264','m4v','mkv','mov','mp4','mpg','mpeg','rm','swf','vob','wmv');
$video_valid_ext = array('3g2','3gp','avi','flv','h264','m4v','mkv','mov','mp4','mpg','mpeg','rm','swf','vob','wmv');
$audio_valid_ext = array('aif','cda','mid','midi','mp3','mpa','wav','wma','wpl');
$image_valid_ext = array('ai','bmp','gif','ico','jpeg','jpg','png','ps','psd','svg','tif','tiff');
$doc_valid_ext = array('pdf','doc','docx','rtf','tex','txt','xls','xlsm','xlsx','rar','zip');

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/vendor/autoload.php';
require 'define/config.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
