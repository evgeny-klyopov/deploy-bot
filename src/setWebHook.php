<?php
/**
 * User: ス
 * Date: 27.01.2019
 * Time: 22:37
 */

require __DIR__ . '/../vendor/autoload.php';



try {
    (new \Alva\DeployBot\App(include('setting.example.php')))->setWebHook();
} catch (\Exception $e) {
    echo $e->getMessage();
}