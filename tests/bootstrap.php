<?php
// @codingStandardsIgnoreFile
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');
$testAuth = new Auth($accessKey, $secretKey);

$bucketName = getenv('QINIU_TEST_BUCKET');
$key = 'php-logo.png';
$key2 = 'niu.jpg';

$testStartDate = '2020-08-18';
$testEndDate = '2020-08-19';
$testGranularity = 'day';
$testLogDate = date('Y-m-d',strtotime("-1 days"));

$bucketNameBC = 'phpsdk-bc';
$bucketNameNA = 'phpsdk-na';
$bucketNameFS = 'phpsdk-fs';
$bucketNameAS = 'phpsdk-as';

$dummyAccessKey = 'abcdefghklmnopq';
$dummySecretKey = '1234567890';
$dummyAuth = new Auth($dummyAccessKey, $dummySecretKey);

//cdn
$timestampAntiLeechEncryptKey = getenv('QINIU_TIMESTAMP_ENCRPTKEY');
$customDomain = "http://sdk.peterpy.cn";
$customDomain2 = "sdk.peterpy.cn";
$customCallbackURL = "https://qiniu.timhbw.com/notify/callback";

$tid = getenv('TRAVIS_JOB_NUMBER');
if (!empty($tid)) {
    $pid = getmypid();
    $tid = strstr($tid, '.');
    $tid .= '.' . $pid;
}

function qiniuTempFile($size, $randomized = true)
{
    $fileName = tempnam(sys_get_temp_dir(), 'qiniu_');
    $file = fopen($fileName, 'wb');
    if ($randomized) {
        $rest_size = $size;
        while ($rest_size > 0) {
            $length = min($rest_size, 4 * 1024);
            if (fwrite($file, random_bytes($length)) == false) {
                return false;
            }
            $rest_size -= $length;
        }
    } else if ($size > 0) {
        fseek($file, $size - 1);
        fwrite($file, ' ');
    }
    fclose($file);
    return $fileName;
}

// Ensure global variables are properly accessible in namespaced test files
// This is needed because test files declare multiple namespaces which can cause
// global variable scoping issues in PHP
$GLOBALS['accessKey'] = $accessKey;
$GLOBALS['secretKey'] = $secretKey;
$GLOBALS['testAuth'] = $testAuth;
$GLOBALS['dummyAuth'] = $dummyAuth;
$GLOBALS['bucketName'] = $bucketName;
$GLOBALS['key'] = $key;
$GLOBALS['key2'] = $key2;
$GLOBALS['testStartDate'] = $testStartDate;
$GLOBALS['testEndDate'] = $testEndDate;
$GLOBALS['testGranularity'] = $testGranularity;
$GLOBALS['testLogDate'] = $testLogDate;
$GLOBALS['bucketNameBC'] = $bucketNameBC;
$GLOBALS['bucketNameNA'] = $bucketNameNA;
$GLOBALS['bucketNameFS'] = $bucketNameFS;
$GLOBALS['bucketNameAS'] = $bucketNameAS;
$GLOBALS['timestampAntiLeechEncryptKey'] = $timestampAntiLeechEncryptKey;
$GLOBALS['customDomain'] = $customDomain;
$GLOBALS['customDomain2'] = $customDomain2;
$GLOBALS['customCallbackURL'] = $customCallbackURL;
$GLOBALS['tid'] = $tid;
