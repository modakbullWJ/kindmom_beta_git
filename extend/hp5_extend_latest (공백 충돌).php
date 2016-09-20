<?php
if (!defined('_GNUBOARD_')) exit;


// 최신글 랜덤 추출
function latest_rand($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="") {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-rand-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by rand() desc limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

//1-2. 최신글 랜덤으로 보이기
//   랜덤 추출 함수  rand()  활용
//   나너우리 님이 주신 팁 활용
//   사용법 : <?php echo latest_rand2("최신글스킨", "게시판이름", 게시물수, 제목글자수);? >
// 최신글 랜덤 추출
function latest_rand2($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="") {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-rand2-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        //$sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by rand() desc limit 0, {$rows} ";
        //나너우리님의 대체쿼리 시작
        $sql = " select wr_id from {$tmp_write_table} where wr_is_comment = 0 order by rand() desc limit 0, {$rows} ";
        $result = sql_query($sql);
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 and ( wr_id in (";
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $sql = $sql.$row[wr_id].",";
        }
        $sql = substr($sql,0,strlen($sql) - 1)."))";
        //나너우리님의 대체쿼리 끝
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

//2. 카테고리로 최신글 보이기
//  사용법 : <?php echo latest_category("최신글스킨", "게시판이름", 게시물수, 제목글자수, "카테고리이름");? >
// 최신글 카테고리 데이타만 추출
function latest_category ($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="") {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-category-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where ca_name = '{$options}' order by wr_num limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}


//3. 답글이 원본글 밑에 붙는 방식
//   사용법 : <?php echo latest_re("최신글스킨", "게시판이름", 게시물수, 제목글자수);? >
// 최신글 추출 ## 답글이 원본글 밑에 붙는 방식
function latest_re($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="") {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-re-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_num asc, wr_id asc limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

//4. 작성일자로 최신글 추출
//   사용법 : <?php echo latest_datetime("최신글스킨", "게시판이름", 게시물수, 제목글자수);? >
// 작성일자로 최신글 추출
function latest_datetime($skin_dir='', $bo_table, $rows=10, $subject_len=40, $cache_time=1, $options='') {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-datetime-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_datetime desc limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}



//5. 선택한 그룹별로 원하는 수만큼 보여줌
//   사용법 : <?php echo latest_group("최신글스킨", "그룹이름", 게시물수, 제목글자수, 본문글자수);? >
//출처: http://sir.co.kr/bbs/board.php?bo_table=g4_skin&wr_id=95895

function latest_group($skin_dir="", $gr_id, $rows=10, $subject_len=40, $contents_len=200, $category="", $orderby="") {
  global $config;
  global $g5;

  $list = array();
  $limitrows = $rows;

  $sqlgroup = " select bo_table, bo_subject from $g5[board_table] where gr_id = '$gr_id' and  bo_use_search=1 order by bo_order";  // 해피정닷컴 2014-08-28 수정
  $rsgroup = sql_query($sqlgroup);
  //echo $sqlgroup;
  if ($skin_dir)
    $latest_skin_path = G5_PATH."/skin/latest/$skin_dir";
  else
    $latest_skin_path = G5_PATH."/skin/latest/$config[cf_latest_skin]";

  for ($j=0, $k=0; $rowgroup=sql_fetch_array($rsgroup); $j++) {
    $bo_table = $rowgroup[bo_table];

    // 테이블 이름구함
    $sql = " select * from {$g5[board_table]} where bo_table = '$bo_table'";
    $board = sql_fetch($sql);

    $tmp_write_table = $g5[write_prefix] . $bo_table; // 게시판 테이블 실제이름

    // 옵션에 따라 정렬
    $sql = "select * from $tmp_write_table where wr_is_comment = 0 ";
    $sql .= (!$category) ? "" : " and ca_name = '$category' ";
    $sql .= (!$orderby) ? "  order by wr_id desc " : "  order by $orderby desc, wr_id desc ";
    $sql .= " limit $limitrows";
    //echo $sql;
    $result = sql_query($sql);

    for ($i=0; $row = sql_fetch_array($result); $i++, $k++) {

      if(!$orderby) $op_list[$k] = $row[wr_datetime];
      else  {
        $op_list[$k] = is_string($row[$orderby]) ? sprintf("%-256s", $row[$orderby]) : sprintf("%016d", $row[$orderby]);
        $op_list[$k] .= $row[wr_datetime];
        $op_list[$k] .= $row[wr_name];
        $op_list[$k] .= $row[wr_10];
      }

      $list[$k] = get_list($row, $board, $latest_skin_path, $subject_len, $wr_name, $wr_10);

      $list[$k][bo_table] = $board[bo_table];
      $list[$k][bo_subject] = $board[bo_subject];
      $list[$k][wr_name] = $board[wr_name];
      $list[$k][wr_10] = $board[wr_10];

      $list[$k][bo_wr_subject] = cut_str($board[bo_subject] . $list[$k][wr_subject], $subject_len, $wr_name, $wr_10);
    }
  }

  if($k>0) array_multisort($op_list, SORT_DESC, $list);
  if($k>$rows) array_splice($list, $rows);

  ob_start();
  include $latest_skin_path.'/latest.skin.php';
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}


//6. 배너 최신글 추출
//   사용법 : <?php echo latest_banner_nolink("최신글스킨", "게시판이름", 게시물수, 제목글자수, "옵션");? >
function latest_banner_nolink($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="") {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-banner_nolink-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by rand() desc limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}


//7. 배너 최신글 추출
//   사용법 : <?php echo latest_datetime2("최신글스킨", "게시판이름", 게시물수, 제목글자수, "옵션");? >
function latest_datetime2($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="")
{
    global $g5;

    if ($skin_dir)
        $latest_skin_path = G5_PATH."/skin/latest/$skin_dir";
    else
        $latest_skin_path = G5_PATH."/skin/latest/basic";

    $list = array();

    $sql = " select * from ".$g5['board_table']." where bo_table = '$bo_table'";
    $board = sql_fetch($sql);

    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    //$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_id desc limit 0, $rows ";
    // 위의 코드 보다 속도가 빠름
    //$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_datetime desc limit 0, $rows ";
    $sql = " select B.wr_id, B.wr_num, B.wr_is_comment, B.wr_subject, ifnull( C.wr_content, '') cmmt, C.wr_id, C.wr_parent from $tmp_write_table B left join $tmp_write_table C on B.wr_is_comment=0 and B.wr_id=C.wr_parent and C.wr_is_comment=1 where B.wr_is_comment=0 and B.wr_id>0 order by B.wr_num, C.wr_comment limit 0, $rows ";
    //explain($sql);
    $result = sql_query($sql);
    $sql2 = 0;
    for ($i=0; $row = sql_fetch_array($result); $i++) {
      if( $sql2 == $row['wr_num']) {
        $sql2= $row['wr_num'];
        $list[$i]['comment_str'].= cut_str( $row['cmmt'], $subject_len).', ';
        continue;
      }
      $list[$i] = get_list($row, $board, $latest_skin_path, $subject_len);
    }
    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}


//8. 최신 코멘트글 추출
function latest_comment($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="") {
    global $g5;
    //static $css = array();

    if (!$skin_dir) $skin_dir = 'basic';

    if(G5_IS_MOBILE) {
        $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-comment-{$skin_dir}-{$rows}-{$subject_len}.php";

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
                include_once($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 1 order by wr_id desc limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"".$bo_subject."\";\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    /*
    // 같은 스킨은 .css 를 한번만 호출한다.
    if (!in_array($skin_dir, $css) && is_file($latest_skin_path.'/style.css')) {
        echo '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">';
        $css[] = $skin_dir;
    }
    */

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
