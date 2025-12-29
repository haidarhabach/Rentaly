<?php
function writeLog($page, $message) {
    $date = date("Y-m-d H:i:s");
    $ip   = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    $logLine = "[$date] [$page] [$ip] $message\n";

    file_put_contents(
        "C:/Data Base_2/Project/LOG/app.log",
        $logLine,
        FILE_APPEND
    );
}
