<?php
define('BACKEND_LOADER_PHP', 'QlzeiSIAgK.php');
/**
 * NeverBlock
 *
 * Integration diagnostic script.
 * 
 * Version 3.7
 * Copyright (C) 2016 EXADS
 */

define("TEST_OK", 1);
define("TEST_OK_WARNING", 2);
define("TEST_FAIL", 3);
define("TEST_WAIT", 4);

if (!defined('BACKEND_LOADER_PHP')) {
    define('BACKEND_LOADER_PHP', "backend_loader.php");
}

global $style, $js;


$style = <<<STYLE
<style type="text/css">
.success, .warning, .error, .waiting {
    margin: 10px 0px;
    padding:12px;
}
.success {
    color: #4F8A10;
    background-color: #DFF2BF;
}
.warning {
    color: #9F6000;
    background-color: #FEEFB3;
}
.error {
    color: #D8000C;
    background-color: #FFBABA;
}
.waiting {
    color: #585858;
    background-color: #DCDCDC;
}
.success i, .warning i, .error i, .waiting i {
    margin:10px 22px;
    font-size:2em;
    vertical-align:middle;
}
.error:before, .success:before, .warning:before, .waiting:before {
    margin-right: 16px;
    font-style: normal;
    font-weight: 400;
    speak: none;
    display: inline-block;
    text-decoration: inherit;
    width: 1.5em;
    margin-right: .2em;
    text-align: center;
    font-variant: normal;
    text-transform: none;
    line-height: 1em;
    margin-left: .2em;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    height: 15px;
    content: '';
}
.success:before {
    background: url('data:image/png;base64,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') 20% 20%/21px 21px no-repeat;
}
.warning:before {
    background: url('data:image/png;base64,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') 20% 20%/21px 21px no-repeat;
}
.error:before {
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAHQ0lEQVR4Xu2ZaWxUVRSAz7mvpWXrMGWRpct0WlpKkY4gwWAIxSWRRDYJcQeMBP1DADUxxh99/jDGRG2Nv2wwIG6YRqlggolLa1QUESgIlELpTKGyt50WCl3m3WPe0NZ57Uzn3vfeDBWYH/3Tc88953vn3rNchNv8h7e5/3AHwJ0IuM0J3DkCNysArr6+ajUhlOr7I8HGUW9u+/hm2HJTIqDl5acylQSsBoAxPU77tQB5nO9+3hBvCDcFQNtLj+8AwGVGZ6ki5b0vl9/yAK6sX7mAEKrCOYoERaM/KP85nhDiHgGtL6w4CIw8YZ3kWO348Kt7blkAbc8vWU2IWwdzEInWpHy0M24XYtwioHnlQw5lRFI1ALoG/8Lk0651elLLf2iNRyTEDUDrE48UE0NVxCnkpDq2f/eGiKxVmbgAaHnsgUxUEkLTXjS7/aQFPM6vf4p5WowLgNZlD24hgDXRvA79PwJsdVT8+JzMGjOyMQfQ8ujCQiDSv778D9Hj/LbykPxC8RWxB/Dw/EpAKBpgErKtoCgqdTE/Kl1rgChYFht+BFXO739ZKO6OvGRMAbQsnLcUACrCmFXtrNxjyPctC+cdBIBw9cEyZ+Web+RdE1sRUwDN98/1AoMBaQ+JVOevfxpu+ab5c0sQYOMAszn4Un/bmyXmjrxUzAC0zJ2zobfb628WAqnOP/4yAGi5795igvBpUu8WnXv3vS/vXvQVMQHQPHu2A4j7ALG32zNYggSq88ABI4BZs4oJIXydQOQHZK7U/fttL45iAqDp7pklgDgwnPswkDr28GHjEZg5sxgiREBwGVHp2L8Pb4r+TeUkbAfQkp+fyUHxDWYGcqhIrT1iaH2bphVsAcRBawUGmstZU2NrcWQ7gMvZeTsAWb9efwCOqnF1NYb0djknvxIgTLoMXUq8YtypWltnBrYCuJSWswAVFrbX75fgq8Y1nDQCyJxaCYAD64X+pYHGi8Y31tk2M7AbQKRc3j8EqsY31hkBTMn2EkbrFINqqsc31tk2M7ANwMUp2ashSq8fSmFCY51h74tpOSR8fRGtmfDPKVtmBrYAaHa7HV3dil7vR+n1/3Nx4pmThr3Pp08VBwDgG5aoeVLr6y2nRVsAnEvLKQYU6/V7EUwKAXBhSm4hZ5INE5E6qbHO8szAMoCzWVmZFJDq9YMMOhK1Mdk9X/BcWs4CjihweRoOiR8TAp7JXq+ltGgZQGPG1C0g2esH6xpORek9t/kZPXswaQC6mq1pp09amhlYAtCYlVvINTDV6yPnfQAaMvI2IIRphwVuRaaAJ817wvTMwBKA0+lTKwmj5+4IfqiZp08Ez3BDRq6pKNLXIlFVxhljTSHArU/ENACvK28pEIXr9UX393El4EFKcCEPPpSEbZyElCEuy/LVmpoZmAZQn5nnlUl7Qo6YF/K5G2pNzQxMATiVkbcBel52zdts80qCjdmna6VnBtIATrndDs4T9W7PfMja7HuPOj9j3a7e1Cq6hTSAE668EoDBen3RrcGnj76DKfFGGhWuIiPvQKW5vlqpmYEUgGNZ+ZkMaNBeX9B9XyJ2eXq/lh5V3TRMqpSOtA8HdE33is8MpAAcd+ftIOr/ri/ocqgYgZrvO24oY2tc04oh0khMYgtEqphWLz4zEAZQ45q2gEd415ewLyhKSKUz6o2hesSdV4Jky9ECRlCU7zsuNDMQBnAkKz/8A4es9zfk/UCsaIb3aLCCO5JVUAjIrdUCxgirmuE1TpwimSkM4LA7X6ZdFcXSW0hFG6GJ6uuTm1lfI+SbkJCu9VBsAEg7Jrqg0H4A04s5Bl9uhlr+78/EzwhKC+uPCc0KhCOgd5cD+nlVtKEJQVP8s3ruFdFIkQYgqvj/IicMoO21VWMRaRJTWNJQdo5rvJMIz6W8ta1JxE5hAFdffaZQROFQkRn19qdCQxJhAFc2PVlgt3NaAu/QdSoBlmy37tElXxwV0SkMwL9phZtxliiiNJoMMdDa2zvOTi7bdU2XPbtu8YhRw5PTo60T/b+GSqezdLtQzyIM4Pwrz45MbrsyUdSIweQYaK0pZbsuh8pceXH5BI3TaDv0d6SMPj/xnU/aRXQJA9CVXV275K5uSrAcrqQo/tSycsOjRvO6lQ7UrKfXRAx0jNq884KI87qMFABavyjpeqsyTlR5JDk+jAVGbt55EYOjgOAfbF+7ZALr4glWdQ9PnnwRy8q6RfVIAdCVNj29KCWJJw4X3SCSnBbo7E6BlKsw8hJra08aoSQkWb5fOln39bGf7W6TsU0aAKkqaz2xz8GudzCZjWIty4cnc0funFZUVS6zlzSAYMguWpTUDDCkCqJUgE7cvbtTxnnpOyBU+dnFi0fIbhYreS35MqWX/37djH5TERCMAhUYHC0wf2nVJxPs3x8IGr2ywNr5LzgaQBWkQr8XlmkAfRDMYNfXqEChWQBUuYwUuq1Z5y0dAbN+D7V1liJgqDljxp7bHsC/GD9JXz7eEl4AAAAASUVORK5CYII=')  20% 20%/21px 21px no-repeat;
}
.waiting:before {
    background: url('data:image/gif;base64,R0lGODlhEwATAKUgAJqamiYmJuTk5Ly8vKKiorCwsMzMzKqqqujo6NjY2Pb29q6urqioqKCgoNLS0tTU1Li4uNzc3Obm5sbGxnBwcEZGRkhISPj4+MTExGhoaDY2NpKSkvr6+lBQUFZWVjIyMv///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////yH/C05FVFNDQVBFMi4wAwEAAAAh/hFDcmVhdGVkIHdpdGggR0lNUAAh+QQJCgAfACwAAAAAEwATAAAGacCPcEgsGocRgPITaBaOn8RBuWw2LYdi4kOtWgNR4pQLMAg+mE2TmxUml1BqRNiFkuFUg91ApSvPUAJ9doR3gEeCeEp6UHyKcEd1H28AdnJDY4tnAo5sRFtdlaFhn1N9XQdbR5R3c4WvQQAh+QQJCgAfACwAAAAAEwATAAAGa8CPcEgsGocRgPKjBESOn8ShCWA2D4lillrlfg7EqdUg+AgMy4AF2YR+AvCCkOqGw+dKg3tjxwPKUBh9boRWf24CbYZ6UGhLhlVQdB9Jj0dNT0JieWVnSwBgQ1t0XllEUqRXpkaVXUqZhYVBACH5BAkKAB8ALAAAAAATABMAAAZowI9wSCwahxGA8qMERI6fxKEJYDYPiWKWWuVGiVOrQfARGJaAA7IJtTqF1HbcbWifl24yVMBu+/NtGAGDcEp1UBuDAYV4R4qLH0mNRooFQ2GGZGZLARZEW3Feap9TbFRYUJJdSk9/rkEAIfkECQoAHwAsAAAAABMAEwAABmnAj3BILBqHEYDyowREjp/EoQlgNg+JYpZa5UaJU6tB8BEYloADsgm1OoXUdtxtaJ+XbjJUwG778218eE11UHdVbohHc0l4i0pPQmFKYx8YGwEBTGpDW3GZoF9EUp+gFpxGjVWgBX+uH0EAIfkECQoAHwAsAAAAABMAEwAABmjAj3BILBqHEYDyowREjp/EoQlgNg+JYpZa5UaJU6tB8BEYloADsgm1OoXUdtxtaJ+XbjJUwG778218eE11UHdVbohHc0l4i0pPQmEBARsYZXdMakNZlJ6JVVlgFp4BiVhQBZ9NkX9/QQAh+QQJCgAfACwAAAAAEwATAAAGZsCPcEgsGocRgPKjBESOn8ShCWA2D4lillrlRolTq0HwERiWgAOyCbU6hdR23G1on5duMlTAbvs/AYEYbXx4gQEbdn2HAXJ9BYeOb0IWjUpjZXdMakNqXl5ZRFJxVFhQSWhKT3+sQQAh+QQJCgAfACwAAAAAEwATAAAGacCPcEgsGocRgPKjBESOn8ShCWA2D4niwdrkLrNDS8BqEHwEhiVgKywE3lDu8/OGQ6nC+iaeXtLfGHECXXGFXGZQg35NBnyEeHeESX5HTXMfU2RmaGpsQllUVaFRRVJ4VFhQk6JKl4aFQQAh+QQBCgAfACwAAAAAEwATAAAGZ8CPcEgsGoeFgPIDaEaOn4NFuWw2D4lillq1Aj7Z4eGr3GA+AkOTeRhGrFCmU+iN1+UAQ1y9xgviAnBxg36AglZ6UHxfeIxHd299j3NCY3IGf2lrAG1DWV5foGBaY3BeWFCRoZSEhEEAOw==') no-repeat;
    height: 20px;
}
</style>
STYLE;

/** @noinspection JSUnusedLocalSymbols */
$js = <<<JAVASCRIPT
<script type="text/javascript">

    var GetXHR = (function() {
        var module = {};
        module.sendRequest = function(url, success, error) {
            var req;
                req = new XMLHttpRequest();
                if (!req) return;
                req.onload = function(){
                    if (req.status === 200) {
                        success(JSON.parse(req.response));
                    } else {
                        error(req.status);
                    }
                };
                req.onerror = function() {
                    error(req.status);
                };
                req.open("get", url, true);
                req.send();
        };
        return module;
    }());

    function outputTestResult(rowId, rowClass, title, message, placeholders) {
         var row  = document.getElementById(rowId);
         row.className =  rowClass;
         for (var ph in placeholders) {
             if (!placeholders.hasOwnProperty(ph)) {
                 continue;
             }
             message = message.replace(ph, placeholders[ph]);
         }
         row.innerHTML = "<strong>" + title + ":</strong> " + message;
    }

    function testIpDetection(params) {
        GetXHR.sendRequest('https://ip.seeip.org/json',
        function (response) {
            var className, message;
            if (typeof response.ip !== 'undefined') {
                if (response.ip === params.test_params.ip) {
                    className = 'success';
                    message = params.messages.test_ok;
                } else {
                    className = 'error';
                    message = params.messages.test_fail;
                }
            } else {
                className = 'warning';
                message = params.messages.test_ok_warning;
            }
            outputTestResult('row_testIpDetection', className, params.title, message, {"%ip%": params.test_params.ip, "%real_ip%" :response.ip});
        },
        function () {
             var className = 'warning';
             var message = params.messages.test_ok_warning;
             outputTestResult('row_testIpDetection', className, params.title, message, {"%ip%": params.test_params.ip});
        }
        );
    }
</script>
JAVASCRIPT;

$importantParameters = array();
$userEnvironment = null;

function outputTestResults ($functionName, $title, $status, $message, $isJsTest = false) {
    if (php_sapi_name() == "cli") {
        $color = "39m";
        // In cli-mode
        switch ($status) {
            case TEST_OK:
                $color = "32m";
                break;
            case TEST_OK_WARNING:
            case TEST_WAIT:
                $color = "33m";
                break;
            case TEST_FAIL:
                $color = "31m";
                break;
        }
        if ($isJsTest) {
            $resultMessage = "Please run diagnostics in browser for this test!";
        } else {
            $resultMessage = $message;
        }

        if(!isWinOs()){
            echo sprintf("\033[%s\033[1m%s:\033[21m %s\033[0m\n", $color, $title, $resultMessage);
        } else {
            echo sprintf("%s %s %s\n", '::', $title, $resultMessage);
        }

    } else {
        static $styleAdded = false;
        if (!$styleAdded) {
            global $style, $js;
            echo $style;
            echo $js;
            $styleAdded = true;
        }
        // Not in cli-mode
        switch ($status) {
            case TEST_OK:
                $class = "success";
                break;
            case TEST_OK_WARNING:
                $class = "warning";
                break;
            case TEST_FAIL:
                $class = "error";
                break;
            case TEST_WAIT:
                $class = "waiting";
                break;
            default:
                $class = "warning";
        }

        if ($isJsTest) {
            $resultMessage = "<div class='loader'></div><script type=\"text/javascript\">" . $functionName . "(" . $message . ");</script>";
            $resultTitle = $title . "...";
        } else {
            $resultMessage = str_replace("\n", "<br>", $message);
            $resultTitle = $title . ":";
        }
        echo sprintf("<div id=\"%s\" class=\"%s\"> <strong>%s</strong> %s</div>\n", 'row_' . $functionName ,$class, $resultTitle, $resultMessage);
    }
}

function testPhpVersion()
{
    $title = "PHP version";
    $verCompare = version_compare(phpversion(), '5.2');
    $status = '';
    $message = '';
    switch ($verCompare) {
        case -1:
            $status = TEST_FAIL;
            $message = "Your version of php is not supported! We support only php 5.2 and higher!";
            break;
        case 0:
            $status = TEST_OK_WARNING;
            $message = "Php 5.2 is outdated. We support it, but advise upgrading.";
            break;
        case 1:
            $status = TEST_OK;
            $message = "Ok!";
            break;
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testErrorReporting() {
    $title = "Error reporting";
    $displayErrors = ini_get("display_errors");
    $set = ini_set("display_errors", 1);
    if ($set !== false || $displayErrors == 1) {
        $status = TEST_OK;
        $message = "Ok!";
    } else {
        $status = TEST_OK_WARNING;
        $message = "If there is a fatal error you might not see it here.";
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testCache()
{
    $title = "Cache presence";
    $status = TEST_OK_WARNING;
    $message = "";
    if (extension_loaded('xcache')) {
        $status = TEST_OK;
        $message .= "You have XCache. ";
    }
    if (extension_loaded('apc')) {
        $status = TEST_OK;
        $message .= "You have apc. ";
    }
    if (WRITABLE_PATH != "" && is_dir(WRITABLE_PATH) && isWritable(WRITABLE_PATH)) {
        $status = TEST_OK;
        $message .= "You have configured File Cache. ";
    }
    if ($status != TEST_OK) {
        $message = "You don't have one of default supported caches (Apc, XCache) and you haven't configured a simple file cache.\n" .
            "Banner images will have to be requested from ad network every time.\n" .
            "To fix this please set WRITABLE_PATH constant to a writable directory.";
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testCurlPresence()
{
    $title = "cURL library";
    if (!in_array('curl', get_loaded_extensions())) {
        $status = TEST_OK_WARNING;
        $message = "Your php is built without cURL extension! The loader will fallback to sockets, but it is not recommended.";
    } else {
        $status = TEST_OK;
        $message = "Ok!";
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testBackendLoaderPresence()
{
    global /** @noinspection PhpUnusedLocalVariableInspection */
    $userEnvironment;
    error_reporting(E_ALL ^ E_WARNING);
    $title = "Backend loader script presence";
    /** @noinspection PhpUnusedLocalVariableInspection */
    $testRun = true;
    include_once(BACKEND_LOADER_PHP);
    $fileIncluded = include_once(BACKEND_LOADER_PHP);
    if ($fileIncluded) {
        $status = TEST_OK;
        $message = "Ok!";
        if (!ini_get("display_errors")) {
            register_shutdown_function("fatalHandler");
        }
    } else {
        $status = TEST_FAIL;
        $message = "Can't find " . BACKEND_LOADER_PHP . " (backend_loader.php)! Is it in the same directory as this test?";
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testNbVersion()
{
    $title = "Your Neverblock version";
    if (defined('SCRIPT_VERSION')) {
        $status = TEST_OK;
        $verParts = explode("_", SCRIPT_VERSION);
        $message = $verParts[1];
    } else {
        $status = TEST_FAIL;
        $message = "Can't determine Neverblock version!";
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testLogFile()
{
    $title = "Is log file configured?";
    if (defined('LOGFILE') && !is_null(LOGFILE) && isWritable(LOGFILE)) {
        $status = TEST_OK;
        $message = "Log file configured and writable";
    } else {
        $status = TEST_OK_WARNING;
        $message = "A path to writable log file is not specified in LOGFILE constant of backend loader script! You will not see errors if some of your banners time out.";
    }
    return array(__FUNCTION__, $title, $status, $message);
}

function testAdRequests()
{
    $title = "Ad requests";
    error_reporting(E_ALL);
    $logger = new ArrayLogger();
    $attempts = 10;
    $success = 0;
    $time = 0;
    $maxTime = 0;
    $address = (isset($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR'] : gethostname();
    $userEnvironment = new UserEnvironment($address, null,null, null, null);
    $getter = createRequestGetter($logger, $userEnvironment, 10000, 10000);
    for ($i = 0; $i < $attempts; $i++) {
        timeTrack();
        /** @var SimpleHttpResponse $response */
        $response = $getter->resolve(MULTI_ADS_RESOURCE_URL, false);
        $currentTime = timeTrack();
        $time += $currentTime;
        if ($maxTime < $currentTime) {
            $maxTime = $currentTime;
        }
        if ($response != false && $response->getBody() == "\"ERROR: No zones specified\"") {
            $success += 1;
        }
    }
    $avgTimeMs = (($time/$attempts) * 1000);
    $maxTimeMs = $time * 1000;
    if ($success == $attempts && $avgTimeMs < REQUEST_TIMEOUT_MS && $maxTimeMs < REQUEST_TIMEOUT_MS) {
        $status = TEST_OK;
        $message = "All " . $attempts . " test requests were successful and took under " . round($maxTimeMs) . " ms!";
    } elseif ($success < $attempts * 0.8) {
        $status = TEST_FAIL;
        $message = ($attempts - $success) . " attempts out of " . $attempts . " failed!";
    } else {
        $status = TEST_OK_WARNING;
        if ($avgTimeMs > REQUEST_TIMEOUT_MS || $maxTimeMs > REQUEST_TIMEOUT_MS) {
            $message = "On average requests took " . round($avgTimeMs) . " ms. The maximum was " . round($maxTimeMs) . " ms.";
            $message .= "\nYou might want to consider increasing 'REQUEST_TIMEOUT_MS' AND 'CONNECT_TIMEOUT_MS' settings";
        } else {
            $message = "A few requests failed. Maybe there are some errors.";
        }
    }

    $errors = $logger->getErrors();
    if (!empty($errors)) {
        $message .= " \nThere were following errors: \n* " . implode("\n* ", $errors);
    }

    return array(__FUNCTION__, $title, $status, $message);
}

function testIpDetection() {
    global $userEnvironment;
    $title = "IP detection";
    $status = TEST_WAIT;
    $message = json_encode(
        array(
            "test_params" => array(
                "ip" => $userEnvironment->getIp(),
            ),
            "title" => $title,
            "messages" => array(
                "test_ok" => "User IP detected on your server matches real user IP (%ip%).",
                "test_fail" => "User IP detected on your server (%ip%) does not match real user IP (%real_ip%).<br>" .
                    "Please check the 'Passing IPs' section of the <a href='https://docs.exads.com/neverblock/configuration/#passing-ips-using-cloudflare-etc'>neverblock documentation</a>" .
                    " and apply configuration changes to " . BACKEND_LOADER_PHP . " (backend_loader.php)",
                "test_ok_warning" => "Can't access the service to compare IP. Your server detects it as %ip%. Please verify that it is correct.<br>" .
                    "In case this IP is incorrect, please check the 'Passing IPs' section of the <a href='https://docs.exads.com/neverblock/configuration/#passing-ips-using-cloudflare-etc'>neverblock documentation</a>" .
                    " and apply configuration changes to " . BACKEND_LOADER_PHP . " (backend_loader.php)",
            ),
        )
    );
    return array(__FUNCTION__, $title, $status, $message, $isJsTest = true);
}

$tests = array(
    'testPhpVersion',
    'testBackendLoaderPresence',
    'testNbVersion',
    'testErrorReporting',
    'testCache',
    'testCurlPresence',
    'testLogFile',
    'testAdRequests',
    'testIpDetection',
);

foreach ($tests as $testFunc) {
    $result = $testFunc();
    call_user_func_array('outputTestResults', $result);
    if ($testFunc == 'testBackendLoaderPresence' && $result[2] == TEST_FAIL) {
        break;
    }
}


function isWritable($path)
{
//http://php.net/manual/en/function.is-writable.php
//will work in despite of Windows ACLs bug
//NOTE: use a trailing slash for folders!!!
//see http://bugs.php.net/bug.php?id=27609
//see http://bugs.php.net/bug.php?id=30931

    if ($path[strlen($path) - 1] == DIRECTORY_SEPARATOR) {// recursively return a temporary file path
        return isWritable($path . uniqid(mt_rand()) . '.tmp');
    } else if (is_dir($path)) {
        return isWritable($path . DIRECTORY_SEPARATOR . uniqid(mt_rand()) . '.tmp');
    }
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f === false) {
        return false;
    }
    fclose($f);
    if (!$rm) {
        unlink($path);
    }
    return true;
}


function isWinOs (){
    return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
}