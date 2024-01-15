<?php

// Copyright 2021-2023 SnehTV, Inc.
// Licensed under MIT (https://github.com/mitthu786/TS-JioTV/blob/main/LICENSE)
// Created By: TechieSneh

error_reporting(0);
include "functions.php";

function makeHttpRequest($url, $headers)
{
    $opts = ['http' => ['method' => 'GET', 'header' => array_map(
        function ($h, $v) {
            return "$h: $v";
        },
        array_keys($headers),
        $headers
    ),]];

    $context = stream_context_create($opts);
    return file_get_contents($url, false, $context);
}

$cred = getCRED();
$jio_cred = json_decode($cred, true);
$ssoToken = $jio_cred['ssoToken'];
$crm = $jio_cred['sessionAttributes']['user']['subscriberId'];
$uniqueId = $jio_cred['sessionAttributes']['user']['unique'];

$cookies_x = @$_REQUEST["ck"];
$enc_x = str_replace(["PLUS", "EQUALS"], ["+", "="], $cookies_x);
$cookies = base64_decode(strrev($enc_x));

if (!empty($_REQUEST["key"]) && !empty($_REQUEST["ck"])) {
    $headers = [
        'Cookie' => $cookies,
        'appkey' => 'NzNiMDhlYzQyNjJm',
        'channelid' => '0',
        'crmid' => $crm,
        'deviceId' => 'e4286d7b481d69b8',
        'devicetype' => 'phone',
        'isott' => 'true',
        'languageId' => '6',
        'lbcookie' => '1',
        'os' => 'android',
        'osVersion' => '8.1.0',
        'srno' => '230203144000',
        'ssotoken' => $ssoToken,
        'subscriberId' => $crm,
        'uniqueId' => $uniqueId,
        'User-Agent' => 'plaYtv/7.0.5 (Linux;Android 8.1.0) ExoPlayerLib/2.11.7',
        'usergroup' => 'tvYR7NSNn7rymo3F',
        'versionCode' => '277'
    ];

    $cache = str_replace("/", "_", $_REQUEST["key"]);
    if (!file_exists($cache)) {
        $url = 'https://tv.media.jio.com/streams_live/' . $_REQUEST["key"];
        $haystack = makeHttpRequest($url, $headers);
    } else {
        $haystack = file_get_contents($cache);
    }

    echo $haystack;
}

if (!empty($_REQUEST["pkey"]) && !empty($_REQUEST["ck"])) {
    $headers = [
        'Cookie' => $cookies,
        'appkey' => 'NzNiMDhlYcQyNjJm',
        'channelid' => '0',
        'crmid' => $crm,
        'deviceId' => 'e4286d7b481d69b8',
        'devicetype' => 'phone',
        'isott' => 'true',
        'languageId' => '6',
        'lbcookie' => '1',
        'os' => 'android',
        'osVersion' => '8.1.0',
        'srno' => '230203144000',
        'ssotoken' => $ssoToken,
        'subscriberId' => $crm,
        'uniqueId' => $uniqueId,
        'User-Agent' => 'plaYtv/7.0.5 (Linux;Android 8.1.0) ExoPlayerLib/2.11.7',
        'usergroup' => 'tvYR7NSNn7rymo3F',
        'versionCode' => '277'
    ];

    $cache = str_replace("/", "_", $_REQUEST["pkey"]);
    if (!file_exists($cache)) {
        $url = 'https://tv.media.jio.com/fallback/bpk-tv/' . $_REQUEST["pkey"];
        $haystack = makeHttpRequest($url, $headers);
    } else {
        $haystack = file_get_contents($cache);
    }

    echo $haystack;
}

if (!empty($_REQUEST["ts"]) && !empty($_REQUEST["ck"])) {
    header("Content-Type: video/mp2t");
    header("Connection: keep-alive");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Expose-Headers: Content-Length,Content-Range");
    header("Access-Control-Allow-Headers: Range");
    header("Accept-Ranges: bytes");

    $headers = [
        'Cookie' => $cookies,
        'appkey' => 'NzNiMDhlYcQyNjJm',
        'channelid' => '0',
        'crmid' => $crm,
        'deviceId' => 'e4286d7b481d69b8',
        'devicetype' => 'phone',
        'isott' => 'true',
        'languageId' => '6',
        'lbcookie' => '1',
        'os' => 'android',
        'osVersion' => '8.1.0',
        'srno' => '230203144000',
        'ssotoken' => $ssoToken,
        'subscriberId' => $crm,
        'uniqueId' => $uniqueId,
        'User-Agent' => 'plaYtv/7.0.5 (Linux;Android 8.1.0) ExoPlayerLib/2.11.7',
        'usergroup' => 'tvYR7NSNn7rymo3F',
        'versionCode' => '277'
    ];

    $url = 'https://jiotvmblive.cdn.jio.com/' . $_REQUEST["ts"];
    $haystack = makeHttpRequest($url, $headers);
    echo $haystack;
}
