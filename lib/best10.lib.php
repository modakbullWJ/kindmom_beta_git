<? 
if (!defined('_GNUBOARD_')) exit; 

/* 
izen.group.lib.php 
제작일 : 2006-12-08 

지정 기간제 히트순 최근 게시물 수정본 
http://www.sir.co.kr/bbs/tb.php/g4_tiptech/7328 

그룹 최신글 관련하여 통합하도록 하였다. 
정렬 필드값에 의해서 SQL 문을 추가하도록 하면 된다. 

izen_group('스킨', '그룹명', 정렬필드, 출력갯수, 자를 문자열, 최근 몇일간을 출력할 것인가?); 
예) echo izen_group('best10', '06', wr_hit, 10, 28, 30); 
*/ 

# 인기글 
function izen_usort1($a, $b) 
{ 
return $b['wr_hit'] - $a['wr_hit']; 
} 

# 헤드라인 
function izen_usort2($a, $b) 
{ 
return $b['wr_good'] - $a['wr_good']; 
} 

# 최신글 추출 
function izen_group($skin_dir="", $gr_id, $izen_sort, $rows=10, $subject_len=40, $listdate) 
{ 
global $g5; 

$nowYmd = date(Ymd); # 시작시간을 구합니다. 
$time = time(); 
$startYmd = date("Ymd",strtotime("-".$listdate." day", $time)); 

if ($skin_dir) 
{ 
$latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
} 
else 
{ 
$latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
} 

$list = array(); 

$sql= " select bo_table from {$g5['board_table']} "; 
$ress = sql_query($sql); 
for($i=0, $ii=0; $board=sql_fetch_array($ress); $ii++) 
{ 
$tmp_write_table = $g5['write_prefix'] . $board['bo_table']; # 게시판 테이블 전체이름 
#$sql = "select * from `$tmp_write_table` where wr_is_comment <> '1' and  date_format(wr_datetime, '%Y%m%d') between '$startYmd' and '$nowYmd' order by $sort desc limit 0, $rows "; 

# 정렬 필드에 의해서 전체적으로 정렬, 관리한다. 
if ($izen_sort == 'wr_hit') 
{ 
$sql_gr_Q = " wr_is_comment <> '1' and date_format(wr_datetime, '%Y%m%d') between '$startYmd' and '$nowYmd' order by $izen_sort desc limit 0, $rows "; 
} 
elseif ($izen_sort == 'wr_scrap') 
{ 
$sql_gr_Q = " wr_is_comment <> '1' and date_format(wr_datetime, '%Y%m%d') between '$startYmd' and '$nowYmd' and wr_scrap <> 0 order by $izen_sort desc limit 0, $rows "; 
} 
elseif ($izen_sort == 'wr_datetime') # wr_1 헤드라인 
{ 
$sql_gr_Q = " wr_is_comment <> '1' and date_format(wr_datetime, '%Y%m%d') between '$startYmd' and '$nowYmd' and wr_1 = 1 order by $izen_sort desc limit 0, $rows "; 
} 
elseif ($izen_sort == 'wr_good') # 
{ 
$sql_gr_Q = " wr_is_comment <> '1' and date_format(wr_datetime, '%Y%m%d') between '$startYmd' and '$nowYmd' and wr_good <> '0'  order by $izen_sort desc limit 0, $rows "; 
} 
elseif ($izen_sort == 'wr_id') 
{ 
$sql_gr_Q = " wr_is_comment <> '1' order by $izen_sort desc limit 0, $rows "; 
} 

$sql = " select * from `$tmp_write_table` where $sql_gr_Q "; 
$result = sql_query($sql); 

#for (; $row=sql_fetch_array($result); $i++) # *오류* 전체 게시물 가운데 날짜에 상관없이 히트순으로 지정한 갯수만큼 출력된다. 
for ($i==0; $row=sql_fetch_array($result); $i++) 
{ 
$list[$i] = get_list($row, $board, $latest_skin_path, $subject_len, $listdate); 
} 
} 

if ($izen_sort == 'wr_hit') 
{ 
usort($list, 'izen_usort1'); 
} 

elseif ($izen_sort == 'wr_good') 
{ 
usort($list, 'izen_usort2'); 
} 

$list= array_slice($list, 0, $rows); 

ob_start(); 
include "$latest_skin_path/latest.skin.php"; 
$content = ob_get_contents(); 
ob_end_clean(); 

return $content; } ?>