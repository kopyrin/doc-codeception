<?php
/**
 * Created by PhpStorm.
 * User: ilopX
 * Date: 20.08.2015
 * Time: 12:45
 * Name: Web demos proj
 * Project: https://github.com/ilopX/web-demos-proj
 * Demo: https://github.com/ilopX/web-demos-proj/tree/master/projects/Codeception-install
 * This file: https://github.com/ilopX/web-demos-proj/blob/master/projects/Codeception-install/run-selenium-server.php
 */

define('STDIN', fopen('php://stdin', 'r'));

$thisPath = dirname(__FILE__).'\\selenium-server\\';
$batFile = 'run-selenium-server.bat';
$seleniumURL = 'http://selenium-release.storage.googleapis.com/2.47/selenium-server-standalone-2.47.1.jar';
$chromeDriverURL = 'http://chromedriver.storage.googleapis.com/2.9/chromedriver_win32.zip';

if (!file_exists($thisPath))
    mkdir($thisPath, 0777, true);


$seleniumBase = basename($seleniumURL);
if (!file_exists($thisPath.$seleniumBase)){
    echo "Download $seleniumBase...\n";
    file_put_contents($thisPath.$seleniumBase, fopen($seleniumURL, 'r'));
}

$chromeDriverBase = basename($chromeDriverURL);
if (!file_exists($thisPath.'chromedriver.exe')) {
    echo "Download $chromeDriverBase...\n";
    file_put_contents($thisPath . $chromeDriverBase, fopen($chromeDriverURL, 'r'));

    echo "Unzip $chromeDriverBase...\n";
    $zip = new ZipArchive;
    $zip->open($thisPath.$chromeDriverBase);
    $zip->extractTo($thisPath);
    $zip->close();

    unlink($thisPath.$chromeDriverBase);
}

echo "Create $batFile\n";
file_put_contents($thisPath.$batFile, "java -jar {$thisPath}{$seleniumBase} -Dwebdriver.chrome.driver={$thisPath}chromedriver.exe");

system("java -jar {$thisPath}{$seleniumBase} -Dwebdriver.chrome.driver={$thisPath}chromedriver.exe");