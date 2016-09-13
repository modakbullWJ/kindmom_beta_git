<?php
/**
 * Youtube 수집기 (Youtube Collect for Gnuboard4)
 *
 * Copyright (c) 2013 Choi Jae-Young <www.miwit.com>
 *
 * 저작권 안내
 * - 저작권자는 이 프로그램을 사용하므로서 발생하는 모든 문제에 대하여 책임을 지지 않습니다. 
 * - 이 프로그램을 어떠한 형태로든 재배포 및 공개하는 것을 허락하지 않습니다.
 * - 이 저작권 표시사항을 저작권자를 제외한 그 누구도 수정할 수 없습니다.
 */

include_once("_common.php");
include_once("_config.php");

if (!$bo_table) exit;

include_once($board_skin_path."/mw.proc/mw.g5.adapter.extend.php");
include_once($board_skin_path."/mw.lib/mw.skin.basic.lib.php");

$lib_file = "_lib.php";
if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
    $lib_file = "_lib5.php";
}
include_once($lib_file);

$c = mw_youtube_collect_auto();
echo $c;

