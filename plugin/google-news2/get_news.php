<?php
/**
 * GoogleNews2 (GoogleNews2 for Gnuboard4)
 *
 * Copyright (c) 2009 Choi Jae-Young <www.miwit.com>
 *
 * 저작권 안내
 * - 저작권자는 이 프로그램을 사용하므로서 발생하는 모든 문제에 대하여 책임을 지지 않습니다.
 * - 이 프로그램을 어떠한 형태로든 재배포 및 공개하는 것을 허락하지 않습니다.
 * - 이 저작권 표시사항을 저작권자를 제외한 그 누구도 수정할 수 없습니다.
 */

include_once("_common.php");

header("Content-Type: text/html; charset=".$g4['charset']);

if (@is_file($g4['path']."/lib/mw.cache.lib.php"))
    include_once($g4['path']."/lib/mw.cache.lib.php");

if (!function_exists("unhtmlspecialchars")) {
function unhtmlspecialchars($str) // htmlspecialchars 반대
{
    $trans = get_html_translation_table();
    $trans = array_flip($trans);
    $str = strtr($str, $trans);
    return $str;
}}

function mw_get_google_rss_news($topic, $cache_time=0)
{
    global $g4;

    $is_utf8 = preg_match("/^utf/", $g4['charset']);

    $cache_file = $g4['path']."/data/mw.cache/google-news-".$topic;
    if (!$topic)
        $cache_file = $g4['path']."/data/mw.cache/google-news-po";

    if (function_exists("mw_cache_read"))
        $xml = mw_cache_read($cache_file, $cache_time);

    if (strlen($topic) > 1) {
        $q = $topic;
        if (!$is_utf8)
            $q = iconv("utf-8", "euckr", $q);
        $q = urlencode($topic);
        $fputs = "/news?pz=1&cf=all&ned=kr&hl=ko&output=rss&q=".$q;
    }
    else {
        $fputs = "/nwshp?ned=kr&output=rss&topic=".$topic;
    }

    if (!$xml) {
        $url = "https://news.google.co.kr".$fputs;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $xml = curl_exec($ch);
        curl_close($ch);

        if (function_exists("mw_cache_write"))
            mw_cache_write($cache_file, $xml);
    }

    $item = array();
    preg_match_all("/<item>(.*)<\/item>/iUs", $xml, $matchs);
    for ($i=0, $max=count($matchs[1]); $i<$max; $i++) {
	if (!$is_utf8)
	    $matchs[1][$i] = iconv("utf-8", "euckr", $matchs[1][$i]);
	preg_match("/<title>(.*)<\/title>/iUs", $matchs[1][$i], $match);
	$item[$i]['title'] = trim($match[1]);
	$item[$i]['title'] = str_replace("&apos;", "'", $item[$i]['title']);
	preg_match("/<link>(.*)<\/link>/iUs", $matchs[1][$i], $match);
	$item[$i]['link'] = trim($match[1]);
	preg_match("/img src=(.*) /iUs", $matchs[1][$i], $match);
	$item[$i]['img'] = trim($match[1]);
	$item[$i]['img'] = preg_replace("/&quot;/", "", $item[$i]['img']);
	$item[$i]['img'] = preg_replace("/\/\//", "", $item[$i]['img']);
	$item[$i]['img'] = set_http($item[$i]['img']);
    }
    return $item;
}

include_once("keyword.php");

$keyword = array_filter(array_map("trim", $keyword), 'strlen');
$keyword = array_values($keyword);
$topics = array_merge(array('', 'p', 'y', 'l', 'w', 't', 's', 'e'), $keyword);

if (!in_array($topic, $topics)) $topic = '';

$item = mw_get_google_rss_news($topic, 60);
$item_count = count($item);
$item_count = 7;

$img_flag = false;

echo "<ul>\n";

for ($i=0; $i<$item_count; $i++) {
    if (trim($item[$i]['img'])) {
        $r = $i;
        break;
    }
}

echo "<li class='image'><a href=\"{$item[$r]['link']}\" target=\"_blank\"><img src=\"".urldecode($item[$r]['img'])."\"></a></li>";

for ($i=0; $i<$item_count; $i++) {
    echo "<li><a href=\"{$item[$i]['link']}\" target=\"_blank\">{$item[$i]['title']}</a></li>\n";
}
echo "</ul>\n";
