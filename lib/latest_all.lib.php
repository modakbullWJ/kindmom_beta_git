<?php
if (!defined('_GNUBOARD_')) exit;

// 최신글 추출
// $cache_time 캐시 갱신?�간
function latest_all($skin_dir='', $gr_id, $rows=10, $subject_len=40, $cache_time=1, $options='')
{
    global $g5;

    if (!$skin_dir) $skin_dir = 'basic';

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
        }
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-all-{$gr_id}-{$skin_dir}-{$rows}-{$subject_len}.php";

        if(!file_exists($cache_file)) {
            $cache_fwrite = true;
        } else {
            if($cache_time > 0) {
                $filetime = filemtime($cache_file);
                if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
                    @unlink($cache_file);
                    $cache_fwrite = true;
                }
            }

            if(!$cache_fwrite)
                include($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id and b.bo_use_search = 1 ";
$sql_order = " order by a.bn_id desc ";
$list = array();
$sql = " select a.*, b.bo_subject, b.bo_mobile_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit 0,10 ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    	$tmp_write_table = $g5['write_prefix'].$row['bo_table'];
        $row2 = sql_fetch("select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");
        $list[$i] = $row2;

        $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);

		$list[$i]['gr_id'] = $row['gr_id'];
		$list[$i]['bo_table'] = $row['bo_table'];
		$list[$i]['name'] = $name;
		$list[$i]['comment'] = $comment;
		$list[$i]['href'] = './bbs/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row2['wr_id'].$comment_link;

		$list[$i]['gr_subject'] = $row['gr_subject'];
		$list[$i]['bo_subject'] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
		$list[$i]['subject'] = $row2['wr_subject'];
		$list[$i]['wr_id'] = $row2['wr_id'];
		$list[$i]['wr_content'] = $row2['wr_content'];
		$sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);


		$list[$i]['icon_reply'] = '';
    	if ($row2['reply'])
        $list[$i]['icon_reply'] = '<img src="'.$skin_url.'/img/icon_reply.gif" style="margin-left:'.$row['reply'].'px;" alt="�亯��">';

    	$list[$i]['icon_link'] = '';
    	if ($row2['wr_link1'] || $row2['wr_link2'])
        $list[$i]['icon_link'] = '<img src="'.$skin_url.'/img/icon_link.gif" alt="���ø�ũ">';

    	// �з��� ��ũ
		$list[$i]['ca_name_href'] = G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&amp;sca='.urlencode($row2['ca_name']);

		$row2['href'] = G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&amp;wr_id='.$row2['wr_id'].$qstr;
		$list[$i]['comment_href'] = $row['href'];

		$list[$i]['icon_new'] = '';
		if ($board['bo_new'] && $row2['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
		$list[$i]['icon_new'] = '<img src="'.$skin_url.'/img/icon_new.gif" alt="����">';

		$list[$i]['icon_hot'] = '';
		if ($board['bo_hot'] && $row2['wr_hit'] >= $board['bo_hot'])
		$list[$i]['icon_hot'] = '<img src="'.$skin_url.'/img/icon_hot.gif" alt="�α���">';

		$list[$i]['icon_secret'] = '';
		if (strstr($row2['wr_option'], 'secret'))
		$list[$i]['icon_secret'] = '<img src="'.$skin_url.'/img/icon_secret.gif" alt="���б�">';

}
        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$gr_subject='".$gr_subject."';\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
