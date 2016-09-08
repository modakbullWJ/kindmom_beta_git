<?
if (!defined("_GNUBOARD_")) exit;

function latest_tab_group($group="", $rows=10, $subject_len=40, $skin_dir='', $option="")
{

    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $group_latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $group_latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $group_latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $group_latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $gr_id = explode("|", $group);
    $gr = array();
    $list = array();

    for($i=0; $i<count($gr_id); $i++) {

      $gr[$i] = sql_fetch("select gr_subject from $g5[group_table] where gr_id = '$gr_id[$i]'");


      $sql = " select bo_table from $g5[board_table] where gr_id='$gr_id[$i]'";
      $result = sql_query($sql);
      $cnt = 0;

      for ($j=0; $row=sql_fetch_array($result); $j++) {

        $tmp_board_table = $g5['write_prefix'] . $row[bo_table]; //

        $sql2 = "select * from $tmp_board_table where wr_is_comment = 0 order by wr_num limit 0, $rows";
        $result2 = sql_query($sql2);

        for($k=0; $row2=sql_fetch_array($result2); $k++) {
          $ar[$i][$cnt] = $row2[wr_datetime];
          $bo = sql_fetch("select bo_table, bo_subject from $g5[board_table] where bo_table = '$row[bo_table]'");
          $list[$i][$cnt] = get_list($row2, $bo, $ltg_skin_path, $subject_len);
          $list[$i][$cnt][bo_subject] = $bo[bo_subject];
          $list[$i][$cnt][bo_table] = $bo[bo_table];
          $cnt = $cnt + 1;
        }
      }
      //array_multisort($ar[$i], SORT_DESC, $list[$i]);
      if($cnt>$rows) array_splice($list[$i], $rows);

    }


    ob_start();
    include $group_latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
