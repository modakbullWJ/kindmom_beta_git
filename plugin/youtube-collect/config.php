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

set_time_limit(0);
ini_set('memory_limit', -1);
header('Content-Encoding: none');

if (!$is_admin)
    die("접근 권한이 없습니다.");

if (!$bo_table)
    die("bo_table 이 없습니다.");

include_once($board_skin_path."/mw.proc/mw.g5.adapter.extend.php");

header("Content-Type: text/html; charset=$g4[charset]");
$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $gmnow);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

$lib_file = "_lib.php";
if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
    $lib_file = "_lib5.php";
}

if (!$sfl)
    $sfl = "rs_name";

include_once($board_skin_path."/mw.lib/mw.skin.basic.lib.php");

$sql = "create table if not exists $mw_youtube_collect[config_table] ( ";
$sql.= " bo_table varchar(20) not null ";
$sql.= ",cf_license varchar(255) not null ";
$sql.= ",cf_api_key varchar(255) not null ";
$sql.= ",cf_time int not null ";
$sql.= ",cf_bot varchar(1) not null ";
$sql.= ",cf_ban text not null ";
$sql.= ",cf_del_day int not null ";
$sql.= " ) $default_charset ";
sql_query($sql);

sql_query("alter table $mw_youtube_collect[config_table] add cf_ban text not null", false);
sql_query("alter table $mw_youtube_collect[config_table] add cf_del_day int not null", false);
sql_query("alter table $mw_youtube_collect[config_table] add cf_stime time not null default '00:00:00'", false);
sql_query("alter table $mw_youtube_collect[config_table] add cf_etime time not null default '23:59:59'", false);
sql_query("alter table $mw_youtube_collect[config_table] add cf_syndi varchar(1) not null default ''", false);
sql_query("alter table $mw_youtube_collect[config_table] add cf_api_key varchar(255) not null default '' after cf_license", false);

$sql = "create table if not exists $mw_youtube_collect[youtube_list_table] ( ";
$sql.= " yb_id int unsigned not null auto_increment ";
$sql.= ",bo_table varchar(20) not null ";
$sql.= ",yb_type varchar(1) not null default 'k' ";
$sql.= ",yb_channel varchar(50) not null ";
$sql.= ",yb_limit int not null ";
$sql.= ",yb_key varchar(255) not null ";
$sql.= ",yb_ban varchar(255) not null ";
$sql.= ",yb_rex text not null ";
$sql.= ",yb_rex_subject varchar(1) not null ";
$sql.= ",yb_rex_content varchar(1) not null ";
$sql.= ",yb_rex_ex varchar(1) not null ";
$sql.= ",mb_id varchar(255) not null ";
$sql.= ",ca_name varchar(255) not null ";
$sql.= ",yb_use varchar(1) not null ";
$sql.= ",yb_content varchar(1) not null ";
$sql.= ",yb_last datetime not null ";
$sql.= ",yb_id_bloger varchar(1) not null ";
$sql.= ",yb_time_now varchar(1) not null ";
$sql.= ",yb_datetime datetime not null ";
$sql.= ",primary key (yb_id)";
$sql.= ",index (bo_table)";
$sql.= " ) $default_charset ";
sql_query($sql);

sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_type varchar(1) not null default 'k' after bo_table", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_channel varchar(50) not null after bo_table", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_rex text not null after yb_ban", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_rex_ex varchar(1) not null after yb_rex", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_rex_content varchar(1) not null after yb_rex", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_rex_subject varchar(1) not null after yb_rex", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_limit int not null after yb_channel", false);
sql_query("alter table $mw_youtube_collect[youtube_list_table] add yb_content varchar(1) not null after yb_use", false);

$sql = "create table if not exists $mw_youtube_collect[youtube_log_table] ( ";
$sql.= " lo_id int unsigned not null auto_increment ";
$sql.= ",bo_table varchar(20) not null ";
$sql.= ",lo_url varchar(255) not null ";
$sql.= ",lo_subject varchar(255) not null ";
$sql.= ",lo_name varchar(255) not null ";
$sql.= ",lo_datetime datetime not null ";
$sql.= ",primary key (lo_id)";
$sql.= ",index (bo_table)";
$sql.= " ) ";
sql_query($sql);

if ($work== 'edit' || $work== 'reg')
{
    include_once($lib_file);
    if (!preg_match("/utf/i", $g4[charset])) {
        if ($ca_name) $ca_name = mw_youtube_euckr($ca_name);
        if ($yb_channel) $yb_channel = mw_youtube_euckr($yb_channel);
        if ($yb_key) $yb_key = mw_youtube_euckr($yb_key);
        if ($yb_ban) $yb_ban = mw_youtube_euckr($yb_ban);
        if ($yb_rex) $yb_rex = mw_youtube_euckr($yb_rex);
    }

    $ca_name = trim($ca_name);
    if ($ca_name == '&nbsp;') $ca_name = '';
    $mb_id = trim($mb_id);
    $yb_time_now = trim($yb_time_now);
    $yb_content = trim($yb_content);
}

if ($work== 'config')
{
    $sql = "select * from $mw_youtube_collect[config_table] where bo_table = '$bo_table' ";
    $row = sql_fetch($sql);
    echo "$row[cf_license]|$row[cf_time]|$row[cf_bot]|$row[cf_ban]|$row[cf_del_day]|$row[cf_api_key]";
    exit;
}
elseif ($work== 'over_del')
{
    include_once($lib_file);
    mw_youtube_auto_del($bo_table);
    mw_youtube_over_del($bo_table);
    exit;
}
else if ($work== "board_del")
{
    include_once($lib_file);
    if ($member[mb_password] != sql_password($_POST['admin_password'])) {
        die("패스워드가 다릅니다.");
    }
    mw_youtube_board_del($bo_table);
    sql_query("delete from {$mw_youtube_collect['youtube_log_table']} where bo_table = '$bo_table'");
    echo "ok";
    exit;
}
elseif ($work== 'config_update')
{
    if ($cf_stime == '00:00:00' && $cf_etime == '00:00:00') {
        $cf_etime = '23:59:59';
    }
    $sql_common = " cf_time = '$cf_time' ";
    $sql_common.= ",cf_bot = '$cf_bot' ";
    $sql_common.= ",cf_ban = '$cf_ban' ";
    $sql_common.= ",cf_del_day = '$cf_del_day' ";
    $sql_common.= ",cf_stime = '$cf_stime' ";
    $sql_common.= ",cf_etime = '$cf_etime' ";
    $sql_common.= ",cf_syndi = '$cf_syndi' ";

    $sql = "select * from $mw_youtube_collect[config_table] where bo_table = '$bo_table' ";
    $row = sql_fetch($sql);
    if (!$row) {
        sql_query("insert into $mw_youtube_collect[config_table] set $sql_common, bo_table = '$bo_table'");
    }
    else {
        sql_query("update $mw_youtube_collect[config_table] set $sql_common where bo_table = '$bo_table'");
    }

    $sql_common = " cf_license = '$cf_license' ";
    $sql_common.= ",cf_api_key = '$cf_api_key' ";

    sql_query("update $mw_youtube_collect[config_table] set $sql_common");

    exit;
}
elseif ($work== 'collect')
{
    if (!$mw_youtube_collect_config['cf_license'])
        die("라이센스 코드를 입력해주세요.");

    if (!$mw_youtube_collect_config['cf_api_key'])
        die("유투브 API Key 를 입력해주세요.");

    $c = 0;
    include_once($lib_file);

    mw_youtube_auto_del($bo_table);

    $sql = "select * from $mw_youtube_collect[youtube_list_table] where bo_table = '$bo_table'  ";
    if ($yb_id)
        $sql .= " and yb_id = '$yb_id' ";
    else
        $sql .= " and yb_use = '1' ";

    $qry = sql_query($sql);
    while ($row = sql_fetch_array($qry)) {
        $c += mw_youtube_collect($bo_table, $row);
    }

    if ($c) mw_youtube_collect_after($bo_table);

    exit;
}
elseif ($work== 'del')
{
    $sql = " delete from $mw_youtube_collect[youtube_list_table] where yb_id = '$yb_id' ";
    sql_query($sql);

    exit;
}
elseif ($work== 'use')
{
    $sql = " update $mw_youtube_collect[youtube_list_table] set ";
    $sql.= " yb_use = '$yb_use' ";
    $sql.= " where yb_id = '$yb_id' ";
    sql_query($sql);

    exit;
}
elseif ($work== 'alluse')
{
    $sql = " update $mw_youtube_collect[youtube_list_table] set ";
    $sql.= " yb_use = '$yb_use' ";
    sql_query($sql);

    exit;
}
elseif ($work== 'edit')
{
    if (!strlen(trim($yb_id))) die ("yb_id 가 없습니다.");
    //if (!strlen(trim($yb_key))) die ("키워드를 입력해주세요.");

    /*$sql = " select * from $mw_youtube_collect[youtube_list_table] where bo_table = '$bo_table' and yb_url = '$yb_url' and yb_id <> '$yb_id' ";
    $row = sql_fetch($sql);
    if ($row)
        die ("이미 등록된 Youtube 주소입니다.");*/

    if ($mb_id) {
        $id = explode(",", $mb_id);
        $tmp = array();
        for ($i=0, $m=count($id); $i<$m; $i++) {
            $id[$i] = trim($id[$i]);
            if (!$id[$i]) continue;
            $sql = " select mb_id from $g4[member_table] where mb_id = '{$id[$i]}' ";
            $row = sql_fetch($sql);
            if (!$row)
                die ("'{$id[$i]}' 는 존재하지 않는 회원ID 입니다.");
            $tmp[] = $id[$i];
        }
        if (count($tmp))
            $mb_id = @implode(",", $tmp);
    }

    $sql = " update $mw_youtube_collect[youtube_list_table] set ";
    $sql.= "  yb_type = '$yb_type' ";
    $sql.= " ,yb_channel = '$yb_channel' ";
    $sql.= " ,yb_limit = '$yb_limit' ";
    $sql.= " ,yb_key = '$yb_key' ";
    $sql.= " ,yb_ban = '$yb_ban' ";
    $sql.= " ,yb_content = '$yb_content' ";
    $sql.= " ,yb_rex = '$yb_rex' ";
    $sql.= " ,yb_rex_subject = '$yb_rex_subject' ";
    $sql.= " ,yb_rex_content = '$yb_rex_content' ";
    $sql.= " ,yb_rex_ex = '$yb_rex_ex' ";
    $sql.= " ,ca_name = '$ca_name' ";
    $sql.= " ,mb_id = '$mb_id' ";
    $sql.= " ,yb_id_bloger = '$yb_id_bloger' ";
    $sql.= " ,yb_time_now = '$yb_time_now' ";
    $sql.= " where yb_id = '$yb_id' ";
    sql_query($sql);

    $sql = " update $mw_youtube_collect[youtube_list_table] set bo_table = bo_table ";
    if ($chk[yb_limit]) $sql.= " ,yb_limit = '$yb_limit' ";
    if ($chk[yb_key]) $sql.= " ,yb_key = '$yb_key' ";
    if ($chk[yb_ban]) $sql.= " ,yb_ban = '$yb_ban' ";
    if ($chk[yb_content]) $sql.= " ,yb_content = '$yb_content' ";
    if ($chk[ca_name]) $sql.= " ,ca_name = '$ca_name' ";
    if ($chk[yb_time_now]) $sql.= " ,yb_time_now = '$yb_time_now' ";
    if ($chk[mb_id]) $sql.= " ,mb_id = '$mb_id' ";
    if ($chk[yb_id_bloger]) $sql.= " ,yb_id_bloger = '$yb_id_bloger' ";
    if ($chk[yb_rex]) {
        $sql.= " ,yb_rex = '$yb_rex' ";
        $sql.= " ,yb_rex_subject = '$yb_rex_subject' ";
        $sql.= " ,yb_rex_content = '$yb_rex_content' ";
        $sql.= " ,yb_rex_ex = '$yb_rex_ex' ";
    }

    if (!$yb_select)
        $sql.= " where bo_table = '$bo_table' ";

    sql_query($sql);

    exit;
}
else if ($work== 'reg')
{
    //if (!strlen(trim($yb_key))) die ("키워드를 입력해주세요.");

    /*$sql = " select * from $mw_youtube_collect[youtube_list_table] where bo_table = '$bo_table' and yb_url = '$yb_url' ";
    $row = sql_fetch($sql);
    if ($row)
        die ("이미 등록된 Youtube 주소입니다.");*/

    if ($mb_id) {
        $id = explode(",", $mb_id);
        $tmp = array();
        for ($i=0, $m=count($id); $i<$m; $i++) {
            $id[$i] = trim($id[$i]);
            if (!$id[$i]) continue;
            $sql = " select mb_id from $g4[member_table] where mb_id = '{$id[$i]}' ";
            $row = sql_fetch($sql);
            if (!$row)
                die ("'{$id[$i]}' 는 존재하지 않는 회원ID 입니다.");
            $tmp[] = $id[$i];
        }
        if (count($tmp))
            $mb_id = @implode(",", $tmp);
    }

    $sql = " insert into $mw_youtube_collect[youtube_list_table] set ";
    $sql.= "  bo_table = '$bo_table' ";
    $sql.= " ,yb_type = '$yb_type' ";
    $sql.= " ,yb_channel = '$yb_channel' ";
    $sql.= " ,yb_limit = '$yb_limit' ";
    $sql.= " ,yb_key = '$yb_key' ";
    $sql.= " ,yb_ban = '$yb_ban' ";
    $sql.= " ,yb_content = '$yb_content' ";
    $sql.= " ,yb_rex = '$yb_rex' ";
    $sql.= " ,yb_rex_subject = '$yb_rex_subject' ";
    $sql.= " ,yb_rex_content = '$yb_rex_content' ";
    $sql.= " ,ca_name = '$ca_name' ";
    $sql.= " ,mb_id = '$mb_id' ";
    $sql.= " ,yb_id_bloger = '$yb_id_bloger' ";
    $sql.= " ,yb_use = '1' ";
    $sql.= " ,yb_datetime = '$g4[time_ymdhis]' ";
    $sql.= " ,yb_last = '$g4[time_ymdhis]' ";
    $sql.= " ,yb_time_now = '$yb_time_now' ";

    sql_query($sql);

    $sql = " update $mw_youtube_collect[youtube_list_table] set bo_table = bo_table ";
    if ($chk[yb_limit]) $sql.= " ,yb_limit = '$yb_limit' ";
    if ($chk[yb_key]) $sql.= " ,yb_key = '$yb_key' ";
    if ($chk[yb_ban]) $sql.= " ,yb_ban = '$yb_ban' ";
    if ($chk[yb_content]) $sql.= " ,yb_content = '$yb_content' ";
    if ($chk[ca_name]) $sql.= " ,ca_name = '$ca_name' ";
    if ($chk[yb_time_now]) $sql.= " ,yb_time_now = '$yb_time_now' ";
    if ($chk[mb_id]) $sql.= " ,mb_id = '$mb_id' ";
    if ($chk[yb_id_bloger]) $sql.= " ,yb_id_bloger = '$yb_id_bloger' ";
    if ($chk[yb_rex]) {
        $sql.= " ,yb_rex = '$yb_rex' ";
        $sql.= " ,yb_rex_subject = '$yb_rex_subject' ";
        $sql.= " ,yb_rex_content = '$yb_rex_content' ";
        $sql.= " ,yb_rex_ex = '$yb_rex_ex' ";
    }
    $sql.= " where bo_table = '$bo_table' ";
    sql_query($sql);

    exit;
}
else if ($work== 'list')
{
    $sql_common = " from $mw_youtube_collect[youtube_list_table] ";
    $sql_search = " where bo_table = '$bo_table' ";
    if ($sfl && $stx) 
        $sql_search .= " and {$sfl} like '%{$stx}%' ";
    $sql_order = " order by yb_id desc ";

    $sql = "select count(*) as cnt
            $sql_common
            $sql_search";
    $row = sql_fetch($sql);
    $total_count = $row[cnt];

    $rows = $config[cf_page_rows];
    $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
    if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $from_record = ($page - 1) * $rows; // 시작 열을 구함  */

    $sql = "select *
            $sql_common
            $sql_search
            $sql_order
            limit $from_record, $rows ";
    $qry = sql_query($sql);

    $list = array();
    for ($i=0; $row=sql_fetch_array($qry); $i++) {
        $list[$i] = $row;
        $list[$i][num] = $total_count - ($page - 1) * $rows - $i;
        $list[$i][yb_datetime] = date("Y-m-d", strtotime($list[$i][yb_datetime]));
    }

    $list_count = count($list);

    $write_pages = get_paging($rows, $page, $total_page, "$_SERVER[PHP_SELF]?bo_table=$bo_table{$qstr}&page=");
    ?>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="t">
    <tr>
        <td class="tt" width="50"> 번호 </td>
        <td class="tt" width=""> 채널/리스트/키워드 </td>
        <td class="tt" width="60">
            사용 <input type="checkbox" onclick="youtube_all_use(this.checked)">
        </td>
        <td class="tt" width="100"> 분류 </td>
        <td class="tt" width="100"> 회원ID </td>
        <td class="tt" width="120"> 마지막수집 </td>
        <td class="tt" width="60"> - </td>
    </tr>
    <?
    for ($i=0; $i<$list_count; $i++)
    {
        $row = $list[$i];
        $ca_name = $row[ca_name];
        if (!$ca_name) $ca_name = "&nbsp;";
        if ($row[mb_id]) {
            $id = explode(",", $row[mb_id]);
            $mb_id = $id[0];
            $mb = get_member($mb_id, "mb_id, mb_nick, mb_email, mb_homepage");
            $row[mb_name] = get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]);
            if (count($id)>1) $row[mb_name] .= " 외 ".(count($id)-1)."명";
        }
        else
            $row[mb_name] = "&nbsp;";

        if (!$row['yb_type'])
            $row['yb_type'] == 'k';

        $yb_con = '';
        $yb_key = '';
        $yb_ban = '';

        if (trim($row['yb_key']))
            $yb_key = "[수집] {$row['yb_key']}<br>\n";

        if (trim($row['yb_ban']))
            $yb_ban = "[제외] {$row['yb_ban']}<br>\n";

        if ($row['yb_type'] == 'k') {
            $yb_con = $yb_key.$yb_ban;
        }
        else if ($row['yb_type'] == 'c') {
            $href = "https://www.youtube.com/channel/".$row['yb_channel'];

            $yb_con = "[채널] ".$row['yb_channel'];
            $yb_con = "<a href='{$href}' target='_blank' style='text-decoration:underline;'>{$yb_con}</a>\n<br>";
            $yb_con.= $yb_key.$yb_ban;
        }
        else if ($row['yb_type'] == 'u') {
            $href = "https://www.youtube.com/user/".$row['yb_channel'];

            $yb_con = "[유저] ".$row['yb_channel'];
            $yb_con = "<a href='{$href}' target='_blank' style='text-decoration:underline;'>{$yb_con}</a>\n<br>";
            $yb_con.= $yb_key.$yb_ban;
        }
        else if ($row['yb_type'] == 'l') {
            $href = "https://www.youtube.com/playlist?list=".$row['yb_channel'];

            $yb_con = "[리스트] ".cut_str($row['yb_channel'], 20);
            $yb_con = "<a href='{$href}' target='_blank' style='text-decoration:underline;'>{$yb_con}</a>\n<br>";
        }

    ?>
    <tr>
        <td class="tl"> <?=$row[num]?> </td>
        <td class="tl left"><span id="yb_channel_<?=$row[yb_id]?>" value="<?=$row[yb_channel]?>"><?=$yb_con?></span></td>
        <td class="tl" id="yb_use_<?=$row[yb_id]?>" value="<?=$row[yb_use]?>">
            <input type="checkbox" name="yb_use" id="yb_use" value="1" <? if ($row[yb_use]) echo 'checked'; ?> onclick="youtube_use(<?=$row[yb_id]?>, this.checked)">
        </td>
        <td class="tl"><span id="ca_name_<?=$row[yb_id]?>" value="<?=$row[ca_name]?>"><?=$ca_name?></span></td>
        <td class="tl"><span id="mb_id_<?=$row[yb_id]?>" value="<?=$row[mb_id]?>"><?=$row[mb_name]?></span></td>
        <td class="tl"> <?=str_replace(" ", "<br/>", $row[yb_last])?> </td>
        <td class="tl">
            <span id="yb_type_<?=$row[yb_id]?>" value="<?=$row[yb_type]?>"></span>
            <span id="yb_limit_<?=$row[yb_id]?>" value="<?=$row[yb_limit]?>"></span>
            <span id="yb_content_<?=$row[yb_id]?>" value="<?=$row[yb_content]?>"></span>
            <textarea style="display:none" id="yb_key_<?=$row[yb_id]?>"><?=$row[yb_key]?></textarea>
            <textarea style="display:none" id="yb_ban_<?=$row[yb_id]?>"><?=$row[yb_ban]?></textarea>
            <textarea style="display:none" id="yb_rex_<?=$row[yb_id]?>"><?=$row[yb_rex]?></textarea>
            <span id="yb_rex_subject_<?=$row[yb_id]?>" value="<?=$row[yb_rex_subject]?>"></span>
            <span id="yb_rex_content_<?=$row[yb_id]?>" value="<?=$row[yb_rex_content]?>"></span>
            <span id="yb_rex_ex_<?=$row[yb_id]?>" value="<?=$row[yb_rex_ex]?>"></span>
            <span id="yb_time_now_<?=$row[yb_id]?>" value="<?=$row[yb_time_now]?>"></span>
            <span id="yb_id_bloger_<?=$row[yb_id]?>" value="<?=$row[yb_id_bloger]?>"></span>

            <span class="btn" onclick="youtube_collect(<?=$row[yb_id]?>)"><i class="fa fa-download"></i></span>
            <span class="btn" onclick="youtube_edit(<?=$row[yb_id]?>)"><i class="fa fa-edit"></i></span>
            <span class="btn" onclick="youtube_del(<?=$row[yb_id]?>)"><i class="fa fa-cut"></i></span>
        </td>
    </tr>
    <? }
    if (!$i) { ?>
    <tr>
        <td class="tn" colspan="10"> 데이터가 없습니다. </td>
    </tr>
    <? } ?>
    </table>

    <div style="text-align:center; padding:30px 0 50px 0;"><?=$write_pages?></div>

<?
    exit;
} // if ($work== 'list') 

$g4[title] = "Youtube 수집관리";
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="<?php echo $g4['charset']?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $g4['title']?></title>
<style>
body, table, div, span, ul { font-size:12px; }
</style>
<script>
var g4_path      = "<?=$g4['path']?>";
var g4_bbs       = "<?=$g4['bbs']?>";
var g4_bbs_img   = "<?=$g4['bbs_img']?>";
var g4_url       = "<?=$g4['url']?>";
var g4_is_member = "<?=$is_member?>";
var g4_is_admin  = "<?=$is_admin?>";
var g4_bo_table  = "<?=isset($bo_table)?$bo_table:'';?>";
var g4_sca       = "<?=isset($sca)?$sca:'';?>";
var g4_charset   = "<?=$g4['charset']?>";
var g4_cookie_domain = "<?=$g4['cookie_domain']?>";
var g4_is_gecko  = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
var g4_is_ie     = navigator.userAgent.toLowerCase().indexOf("msie") != -1;
<? if ($is_admin) { echo "var g4_admin = '{$g4['admin']}';"; } ?>
</script>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link href="//code.jquery.com/ui/1.11.2/themes/humanity/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<?php if (is_file($g4['path']."/js/sideview.js")) { ?>
<script src="<?php echo $g4['path']?>/js/sideview.js"></script>
<?php } else { ?>
<script src="./common.js"></script>
<?php } ?>

<link rel="stylesheet" href="style.css" type="text/css"/>

<?
//==============================================================================
// jquery date picker
//------------------------------------------------------------------------------
// 참고) ie 에서는 년, 월 select box 를 두번씩 클릭해야 하는 오류가 있습니다.
//------------------------------------------------------------------------------
// jquery-ui.css 의 테마를 변경해서 사용할 수 있습니다.
// base, black-tie, blitzer, cupertino, dark-hive, dot-luv, eggplant, excite-bike, flick, hot-sneaks, humanity, le-frog, mint-choc, overcast, pepper-grinder, redmond, smoothness, south-street, start, sunny, swanky-purse, trontastic, ui-darkness, ui-lightness, vader
// 아래 css 는 date picker 의 화면을 맞추는 코드입니다.
?>
<style type="text/css">
<!--
.ui-datepicker { font:12px dotum; }
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 70px;}
.ui-datepicker-trigger { margin:0 0 -5px 2px; }
-->
</style>
<script type="text/javascript">
/* Korean initialisation for the jQuery calendar extension. */
/* Written by DaeKwon Kang (ncrash.dk@gmail.com). */
jQuery(function($){
        $.datepicker.regional['ko'] = {
                closeText: '닫기',
                prevText: '이전달',
                nextText: '다음달',
                currentText: '오늘',
                monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
                '7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
                monthNamesShort: ['1월','2월','3월','4월','5월','6월',
                '7월','8월','9월','10월','11월','12월'],
                dayNames: ['일','월','화','수','목','금','토'],
                dayNamesShort: ['일','월','화','수','목','금','토'],
                dayNamesMin: ['일','월','화','수','목','금','토'],
                weekHeader: 'Wk',
                dateFormat: 'yy-mm-dd',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['ko']);

    $('#yb_sdate').datepicker({
        showOn: 'button',
        buttonImage: '<?=$board_skin_path?>/img/calendar.gif',
        buttonImageOnly: true,
        buttonText: "달력",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: 'c-99:c+99'
    }); 


    $('#yb_edate').datepicker({
        showOn: 'button',
        buttonImage: '<?=$board_skin_path?>/img/calendar.gif',
        buttonImageOnly: true,
        buttonText: "달력",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: 'c-99:c+99'
    }); 
});
</script>
<?
//==============================================================================
?>


<div class="f">
    <div class="fp">
        <a href="./config.php?bo_table=<?=$bo_table?>"><?=$g4[title]?></a>
    </div>
    <div class="fb">
        <form name="fsearch" method="get" action="<?php echo $_SERVER['PHP_SELF']?>" style="float:left;">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table?>">
        <div style="float:left;">
            <select name="sfl">
                <option value="yb_channel">채널/유저/리스트</option>
                <option value="yb_key">수집키워드</option>
                <option value="yb_ban">제외키워드</option>
                <option value="ca_name">분류</option>
                <option value="mb_id">회원ID</option>
            </select>
            <input type="text" name="stx" class="ed" size="10" value="<?php echo $stx?>">
        </div>
        <button type="submit" class="b"><i class="fa fa-search"></i> 검색</button>&nbsp;
        </form>
        <script> $("select[name=sfl]").val("<?php echo $sfl?>"); </script>

        <button class="b" onclick="youtube_config()"><i class="fa fa-gear"></i> 설정</button>
        <span id="load"><button class="b" onclick="youtube_collect()"/><i class="fa fa-download"></i> 수집</button></span>
        <span id="load"><button class="b" onclick="youtube_log()"/><i class="fa fa-history"></i> 로그</button></span>
        <span id="load2"><button class="b" onclick="youtube_board_del()"/><i class="fa fa-remove"></i> 전체삭제</button></span>
        <button class="b" onclick="youtube_copy()"/><i class="fa fa-copy"></i> 복사</button>
        <button class="b" onclick="youtube_regist()"><i class="fa fa-plus"></i> 등록</button>
    </div>
</div>

<div id="list"></div>

<style type="text/css">
.dialog fieldset { padding:10px; border:0; }
.dialog div { margin:0 0 7px 0; }
.dialog div label { float:left; width:120px; }
.dialog div.i { margin:5px 0 0 125px; line-height:15px; }
</style>

<div id="dialog-form" class="dialog" title="Youtube 검색 키워드추가" style="display:none;">
    <p class="validateTips">Youtube 정보를 입력해주세요.</p>
 
    <form id="fwrite">
    <input type="hidden" name="bo_table" value="<?=$bo_table?>"/>
    <input type="hidden" name="yb_id" id="yb_id" value=""/>
    <fieldset>
        <div>
            <label for="yb_type"> 수집방법</label>
            <select name="yb_type" id="yb_type" required itemname="수집방법">
                <option value="">선택해주세요.</option>
                <option value="k">키워드</option>
                <option value="c">채널 (Channel)</option>
                <option value="u">유저 (User)</option>
                <option value="l">리스트 (Playlist)</option>
            </select>
            <div class="i">리스트 수집시 키워드 수집은 작동되지 않습니다.</div>
        </div>
        <div>
            <label for="yb_channel"> 채널/유저/리스트</label>
            <input type="text" name="yb_channel" id="yb_channel" size="20" value="" class="text ui-widget-content ui-corner-all" />
            <div class="i">Youtube 채널명(유저) 또는 리스트ID를 입력해주세요.</div>
        </div>
        <? $title_msg = "체크하면 이 게시판에 등록된 모든 데이터에 적용됩니다."; ?>
        <div>
            <label for="yb_limit"><input type="checkbox" id="chk_yb_limit" name="chk[yb_limit]" value="1" title="<?=$title_msg?>"> 갯수제한</label>
            <input type="text" size="5" name="yb_limit" id="yb_limit"> 건
            <div class="i">수집할때마다 갯수를 제한합니다.</div>
        </div>
        <div>
            <label for="yb_key"><input type="checkbox" id="chk_yb_key" name="chk[yb_key]" value="1" title="<?=$title_msg?>"> 키워드 수집</label>
            <textarea name="yb_key" id="yb_key" cols="30" rows="5"></textarea>
            <div class="i">키워드로 Youtube 를 검색해 수집합니다.<br/>
             키워드는 , (컴마) 로 구분해주세요.</div>
        </div>
        <div>
            <label for="yb_ban"><input type="checkbox" id="chk_yb_ban" name="chk[yb_ban]" value="1" title="<?=$title_msg?>"> 키워드 제외</label>
            <textarea name="yb_ban" id="yb_ban" cols="30" rows="5"></textarea>
            <div class="i">Youtube 검색시 해당 키워드의 컨텐츠는 제외합니다.<br/>
             키워드는 , (컴마) 로 구분해주세요.</div>
        </div>
        <div>
            <label for="ca_name"><input type="checkbox" id="chk_ca_name" name="chk[ca_name]" value="1" title="<?=$title_msg?>">분류명</label>
            <input type="text" name="ca_name" id="ca_name" size="20" value="" class="text ui-widget-content ui-corner-all" />
            <div class="i">수집시 이 분류명으로 등록 됩니다.</div>
        </div>
        <div>
            <label for="mb_id"><input type="checkbox" id="chk_mb_id" name="chk[mb_id]" value="1" title="<?=$title_msg?>"> 등록자 회원ID</label>
            <input type="text" name="mb_id" id="mb_id" size="20" value="" class="text ui-widget-content ui-corner-all" />
            <div class="i">수집시 이 회원ID 로 등록합니다.<br/>
                여러명을 입력할경우 ,(컴마)로 구분해주세요.<br/>
                비워두면 관리자 아이디로 등록됩니다.<br/>
                <input type="checkbox" name="yb_id_bloger" id="yb_id_bloger" value="1"/> 등록자 이름으로 게시
            </div>
        </div>
        <div>
            <label for="yb_time_now"><input type="checkbox" id="chk_yb_time_now" name="chk[yb_time_now]" value="1" title="<?=$title_msg?>"> 수집시간입력</label>
            <input type="checkbox" name="yb_time_now" id="yb_time_now" value="1" /> 사용
            <div class="i">게시물 등록시간을 수집 당시 시간으로 설정합니다.</div>
        </div>
        <div>
            <label for="yb_content"><input type="checkbox" id="chk_yb_content" name="chk[yb_content]" value="1" title="<?=$title_msg?>"> 내용수집안함</label>
            <input type="checkbox" name="yb_content" id="yb_content" value="1" /> 사용
            <div class="i">내용은 수집하지 않습니다.</div>
        </div>
        <div>
            <label for="yb_rex"><input type="checkbox" id="chk_yb_rex" name="chk[yb_rex]" value="1" title="<?=$title_msg?>"> 치환</label>
            <textarea name="yb_rex" id="yb_rex" cols="30" rows="5"></textarea>
            <div class="i">
                <input type="checkbox" name="yb_rex_subject" id="yb_rex_subject" value="1">제목
                <input type="checkbox" name="yb_rex_content" id="yb_rex_content" value="1">본문
                <input type="checkbox" name="yb_rex_ex" id="yb_rex_ex" value="1">정규식사용
            </div>
            <div class="i">치환규칙을 입력해주세요. 예)<br/>
                블랙박스-&gt;블박<br/>
                검정색-&gt;빨간색<br/>
            </div>
        </div>

        <div>
            <label for="yb_select">선택옵션</label>
            <select name="yb_select">
                <option value="">선택 현재게시판 모든RSS적용</option>
                <option value="1">선택 모든게시판 모든RSS적용</option>
            </select>
        </div>


    </fieldset>
    </form>
</div>

<div id="dialog-config" class="dialog" title="Youtube 환경설정" style="display:none;">
 
    <form id="fconfig">
    <input type="hidden" name="bo_table" value="<?=$bo_table?>"/>
    <fieldset>
        <div>
            <label for="cf_license">라이센스</label>
            <input type="text" name="cf_license" id="cf_license" size="20" value="<?=$mw_youtube_collect_config[cf_license]?>" class="text ui-widget-content ui-corner-all" />
            <div class="i">제품 라이센스코드를 입력해주세요.</div>
        </div>
        <div>
            <label for="cf_api_key">API Key</label>
            <input type="text" name="cf_api_key" id="cf_api_key" size="20" value="<?=$mw_youtube_collect_config[cf_api_key]?>" class="text ui-widget-content ui-corner-all" />
            <div class="i">유투브 API Key 를 입력해주세요.</div>
        </div>
        <div>
            <label for="cf_time">수집주기</label>
            <input type="text" name="cf_time" id="cf_time" size="3" value="<?=$mw_youtube_collect_config[cf_time]?>" class="text ui-widget-content ui-corner-all" />분
            <div class="i">데이터를 주기적으로 수집할 시간을 입력해주세요.</div>
        </div>
        <div>
            <label for="cf_ban">차단 키워드/채널</label>
            <textarea name="cf_ban" id="cf_ban" cols="30" rows="5"></textarea>
            <div class="i">차단할 채널 또는 키워드를 입력해주세요.<br/>여러 채널을 입력할경우 ,(컴마)로 구분해주세요.</div>
        </div>
        <div>
            <label for="cf_time">자동 삭제</label>
            <input type="text" name="cf_del_day" id="cf_del_day" size="3" value="<?=$mw_youtube_collect_config[cf_del_day]?>" class="text ui-widget-content ui-corner-all" />일
            <div class="i">설정일이 지난 게시물은 자동으로 삭제합니다.</div>
        </div>
        <div>
            <label for="cf_time">수집시간</label>
            <input type="text" name="cf_stime" id="cf_stime" size="10" value="<?=$mw_youtube_collect_config[cf_stime]?>"
                class="text ui-widget-content ui-corner-all" /> ~
            <input type="text" name="cf_etime" id="cf_etime" size="10" value="<?=$mw_youtube_collect_config[cf_etime]?>"
                class="text ui-widget-content ui-corner-all" />
            <div class="i">설정시간에만 수집기가 작동합니다.</div>
        </div>
        <div>
            <label for="cf_bot">네이버 신디케이션</label>
            <input type="checkbox" name="cf_syndi" id="cf_syndi" size="20" value="1" <? if ($mw_youtube_collect_config[cf_syndi]) echo 'checked'; ?> class="text ui-widget-content ui-corner-all" />사용 
            <div class="i">
            네이버 신디케이션 플러그인 설치 필수!
            [<a href="http://www.miwit.com/b/mw_tip-3891" target="_blank">다운받기</a>]
            </div>
        </div>
        <!--
        <div>
            <label for="cf_bot">검색엔진 접근 수집</label>
            <input type="checkbox" name="cf_bot" id="cf_bot" size="20" value="1" <? if ($mw_youtube_collect_config[cf_bot]) echo 'checked'; ?> class="text ui-widget-content ui-corner-all" />
            <div class="i">
            검색엔진 수집기가 접근할 때만 데이터를 자동수집합니다. <br/>
            사용자 접근시 수집하지 않기 때문에 <br/>
            데이터 수집으로 인한 로딩지연 현상이 없어집니다.</div>
        </div>
        -->
    </fieldset>
    </form>
</div>

<div id="dialog-pass" class="dialog" title="게시판 전체글 삭제" style="display:none;">
    <div id="fpass-loading" style="display:none;">
        삭제중입니다. 잠시만 기다려주세요..<img src="img/loading.gif" align="absmiddle"></div>
    <form id="fpass">
    <input type="hidden" name="bo_table" value="<?=$bo_table?>"/>
    <input type="hidden" name="work" value="board_del"/>
    <div>정말 게시물을 전부 삭제하시겠습니까?</div>
    <div>관리자 비밀번호를 입력해주세요.</div>
    <div>&nbsp;</div>
    <fieldset>
        <div>
            <label for="admin_password">비밀번호</label>
            <input type="password" name="admin_password" id="admin_password" size="20" value="" class="text ui-widget-content ui-corner-all" />
        </div>
    </fieldset>
    </form>
</div>

<script type="text/javascript">
if (g4_is_ie) {
    dialog_form_height = 800;
    dialog_config_height = 570;
} else {
    dialog_form_height = 500;
    dialog_config_height = 450;
}

$(document).ready(function() {
    $("#fpass").bind("submit", function () {
        return false;
    });
    $("#admin_password").bind("keypress", function (event) {
        if (event.which == 13) {
            youtube_board_del_run();
        }
    });
});

function youtube_all_use(checked)
{
    $('input[name=yb_use]').prop('checked', checked);

    if (checked) checked = '1'; else checked = '';
    $.post("<?php echo $_SERVER['PHP_SELF']?>?bo_table=<?=$bo_table?>&work=alluse", { 'yb_use':checked });
}

function youtube_use(yb_id, checked)
{
    if (checked) checked = '1'; else checked = '';
    $.post("<?=$_SERVER[PHP_SELF]?>?bo_table=<?=$bo_table?>&work=use&yb_id="+yb_id, { 'yb_use':checked });
}

function youtube_del(yb_id)
{
    if (!confirm("한번 삭제한 자료는 복구할 방법이 없습니다. \n\n정말 삭제하시겠습니까?")) {
        return;
    }

    $.post("<?=$_SERVER[PHP_SELF]?>?bo_table=<?=$bo_table?>&work=del&yb_id="+yb_id);
    youtube_list();
}

function youtube_board_del_run()
{
    if (!confirm("정말 삭제하시겠습니까?")) return;
    $("#fpass-loading").css("display", "block");
    $("#fpass").css("display", "none");
    $.post("<?=$_SERVER[PHP_SELF]?>", $("#fpass").serialize(), function (str) {
        if (str == "ok") {
            alert("이 게시판의 모든 게시물을 삭제했습니다.");
        }
        else {
            alert(str);
        }
        $("#fpass-loading").css("display", "none");
        $("#fpass").css("display", "block");
        $("#admin_password").val("");

        if (str == "ok")
            $("#dialog-pass").dialog("close");
        else
            $("#admin_password").focus();
    });
}

function youtube_board_del()
{
    $("#dialog-pass").dialog({
        autoOpen: false,
        width: 500,
        height: dialog_config_height,
        modal: true,
        resizable: true,
        buttons: {
            "삭제": function() {
                youtube_board_del_run();
            },
            "닫기 ": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
        }
    }).dialog("open");
}

function youtube_config()
{
    $.get("<?=$_SERVER[PHP_SELF]?>?bo_table=<?=$bo_table?>&work=config", function (ret) {
        config = ret.split("|");

        $("#cf_license").val(config[0]);
        $("#cf_time").val(config[1]);
        $("#cf_bot").prop("checked", config[2]);
        $("#cf_ban").val(config[3]);
        $("#cf_del_day").val(config[4]);
        $("#cf_api_key").val(config[5]);
    });

    $("#dialog-config").dialog({
        autoOpen: false,
        width: 500,
        height: dialog_config_height,
        modal: true,
        resizable: true,
        buttons: {
            "저장": function() {
                tmp = $(this);
                $.post("<?=$_SERVER[PHP_SELF]?>?work=config_update", $("#fconfig").serialize(), function (ret) {
                    if (ret) {
                        alert(ret);
                        return;
                    } else {
                        tmp.dialog("close");
                    }
                });
            },
            "닫기 ": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
        }
    }).dialog("open");
}


function youtube_edit(yb_id)
{
    youtube_reset();

    $("#yb_id").val(yb_id);
    $("#yb_type").val($("#yb_type_"+yb_id).attr("value"));
    $("#yb_channel").val($("#yb_channel_"+yb_id).attr("value"));
    $("#yb_limit").val($("#yb_limit_"+yb_id).attr("value"));
    $("#yb_key").val($("#yb_key_"+yb_id).val());
    $("#yb_ban").val($("#yb_ban_"+yb_id).val());
    $("#yb_rex").val($("#yb_rex_"+yb_id).val());
    $("#yb_rex_subject").prop("checked", $("#yb_rex_subject_"+yb_id).attr("value"));
    $("#yb_rex_content").prop("checked", $("#yb_rex_content_"+yb_id).attr("value"));
    $("#yb_rex_ex").prop("checked", $("#yb_rex_ex_"+yb_id).attr("value"));
    $("#ca_name").val($("#ca_name_"+yb_id).attr("value"));
    $("#mb_id").val($("#mb_id_"+yb_id).attr("value"));
    $("#yb_id_bloger").prop("checked", $("#yb_id_bloger_"+yb_id).attr("value"));
    $("#yb_time_now").prop("checked", $("#yb_time_now_"+yb_id).attr("value"));
    $("#yb_content").prop("checked", $("#yb_content_"+yb_id).attr("value"));

    $("#dialog-form").dialog({
        autoOpen: false,
        width: 500,
        height: dialog_form_height,
        modal: true,
        resizable: true,
        buttons: {
            "수정": function() {
                tmp = $(this);
                $.post("<?=$_SERVER[PHP_SELF]?>?work=edit", $("#fwrite").serialize(), function (ret) {
                    if (ret) {
                        alert(ret);
                        return;
                    } else {
                        youtube_list(<?=$page?>);
                        tmp.dialog("close");
                    }
                });
            },
            "닫기 ": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
        }
    }).dialog("open");
}

function youtube_reset()
{
    $("#chk_yb_time_now").prop("checked", false);
    $("#chk_yb_content").prop("checked", false);
    $("#chk_yb_ca_name").prop("checked", false);
    $("#chk_yb_mb_id").prop("checked", false);
    $("#chk_yb_key").prop("checked", false);
    $("#chk_yb_ban").prop("checked", false);
    $("#chk_ca_name").prop("checked", false);
    $("#chk_yb_rex").prop("checked", false);
}

function youtube_regist()
{
    youtube_reset();

    $("#yb_id").val("");
    $("#yb_type").val("");
    $("#yb_channel").val("");
    $("#yb_limit").val("");
    $("#yb_key").val("");
    $("#yb_ban").val("");
    $("#yb_rex").val("");
    $("#yb_rex_subject").prop("checked", false);
    $("#yb_rex_content").prop("checked", false);
    $("#yb_rex_ex").prop("checked", false);
    $("#ca_name").val("");
    $("#mb_id").val("");
    $("#yb_id_bloger").prop("checked", false);
    $("#yb_time_now").prop("checked", false);
    $("#yb_content").prop("checked", false);

    $("#dialog-form").dialog({
        autoOpen: false,
        width: 500,
        height: dialog_form_height,
        modal: true,
        resizable: true,
        buttons: {
            "등록": function() {
                tmp = $(this);
                $.post("<?=$_SERVER[PHP_SELF]?>?work=reg", $("#fwrite").serialize(), function (ret) {
                    if (ret) {
                        alert(ret);
                        return;
                    } else {
                        alert("등록되었습니다.");
                        youtube_list();
                        tmp.dialog("close");
                    }
                });
            },
            "닫기 ": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
        }
    }).dialog("open");
}

function youtube_list(page) {
    if (page == undefined) page = '';
    $("#list").load("<?=$_SERVER[PHP_SELF]?>?bo_table=<?=$bo_table?>&work=list&sfl=<?php echo $sfl?>&stx=<?php echo $stx?>&page="+page, function () {
        <?php if (defined("G5_PATH")) { ?>
        $.getScript("common.js")
        <?php } ?>
    });
}

function youtube_collect(yb_id) {
    if (!confirm("데이터량에 따라 수집시간이 오래 걸릴수도 있습니다.\n\n지금 시작하시겠습니까?")) return;
    if (!yb_id || yb_id == 'undefined') yb_id = 0;
    tmp = $("#load").html();
    $("#load").html("<img src='img/loading.gif' align='absmiddle'>");
    $.get("<?=$_SERVER[PHP_SELF]?>?bo_table=<?=$bo_table?>&work=collect&yb_id="+yb_id, function (ret) {
        if (ret)
            alert(ret);
        else
            alert("수집을 완료했습니다.");

        $("#load").html(tmp);
    });
    youtube_list(<?=$page?>);
}

function youtube_log() {
    window.open("log.php?bo_table=<?=$bo_table?>", "log", "width=800,height=600,scrollbars=1");
}

function youtube_copy() {
    window.open("copy.php?bo_table=<?=$bo_table?>", "copy",  "left=50, top=50, width=500, height=550, scrollbars=1");
}

$(document).ready(function () {
    youtube_list(<?=$page?>);
});
</script>

</body>
</html>

