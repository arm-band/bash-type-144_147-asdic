<?php

date_default_timezone_set('Asia/Tokyo');
mb_language('ja');
mb_internal_encoding('UTF-8');

/**
 * outputErrMsg エラーメッセージ表示
 *
 * @param string $str
 *
 * @return string
 */
function outputErrMsg($code, $someStr)
{
    $msg = '';
    $errMsgObj = [
        // 1x: 設定ファイル系
        11 => '設定ファイル (config.json) が存在しません。',
        12 => 'パラメータ文字列の長さが空です。',
        // 2x: 出力系
        21 => '出力先ディレクトリ ########## にアクセスできませんでした。',
        // 3x: 出力系
        31 => 'IPアドレス ########## の値が不正です。',
        // 9x: その他、処理中エラー
        99 => '##########',
    ];
    $msg = $errMsgObj[$code];
    if(mb_strlen($someStr, 'UTF-8') > 0) {
        $msg = str_replace('##########', $someStr, $msg);
    }

    return $msg;
}
/**
 * checkFilePath ファイル・ディレクトリ存在チェック
 *
 * @param string $path
 *
 * @return bool
 */
function checkFilePath($path)
{
    return file_exists($path);
}
/**
 * checkIpAddress IPアドレス形式チェック
 *
 * @param string $ip
 *
 * @return bool
 */
function checkIpAddress($ip)
{
    return preg_match(
        '/^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])\.){3}(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])$/',
        $ip
    );
}

/**
 * sonaring pingを打つ
 *
 * @param string $host
 * @param string $filepath
 *
 * @return int|bool
 */
function sonaring($host, $filepath)
{
    $cmd = 'ping -i 3 ' . escapeshellarg($host) . ' | xargs -I_ date +\'%c _\' | tee ' . escapeshellarg($filepath);
        $r = exec(
            $cmd,
            $res,
            $rval
        );
}

/* main process */
if (checkFilePath(__DIR__ . DIRECTORY_SEPARATOR . 'config.php')) {
    // 設定ファイル読み込み
    $CONFIG = require_once(__DIR__  . DIRECTORY_SEPARATOR . 'config.php');

    // 出力先ディレクトリ
    if(mb_strlen($CONFIG['resultOutput']['path'], 'UTF-8') === 0) {
        $msg = outputErrMsg(12, '');
        exit($msg);
    }
    // ファイル名
    if(mb_strlen($CONFIG['resultOutput']['baseFilename'], 'UTF-8') === 0) {
        $msg = outputErrMsg(12, '');
        exit($msg);
    }
    $host = $CONFIG['address'];
    // アドレス
    if(mb_strlen($host, 'UTF-8') === 0) {
        $msg = outputErrMsg(12, '');
        exit($msg);
    }
    else if(checkIpAddress($host) === false) {
        $msg = outputErrMsg(31, $host);
        exit($msg);
    }
    $dirPath = __DIR__ . DIRECTORY_SEPARATOR . $CONFIG['resultOutput']['path'];
    $dateStr = date('Ymd');
    $filePath = $dirPath . DIRECTORY_SEPARATOR . $CONFIG['resultOutput']['baseFilename'] . '-' . $dateStr . '.log';
    if(!checkFilePath($dirPath)) {
        $msg = outputErrMsg(21, $dirPath);
        exit($msg);
    }
    sonaring($host, $filePath);
}
else {
    $msg = outputErrMsg(11, '');
    exit($msg);
}
