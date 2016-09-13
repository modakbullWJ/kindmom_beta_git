<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$str = '';
$exists = false;

$ca_id_len = strlen($ca_id);
$len2 = $ca_id_len + 2;
$len4 = $ca_id_len + 4;

// 최하위 분류의 경우 상단에 동일한 레벨의 분류를 출력해주는 코드
if (!$exists) {
    $str = '';

    $tmp_ca_id = substr($ca_id, 0, strlen($ca_id)-2);
    $tmp_ca_id_len = strlen($tmp_ca_id);
    $len2 = $tmp_ca_id_len + 2;
    $len4 = $tmp_ca_id_len + 4;

    // 차차기 분류의 건수를 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id like '$tmp_ca_id%' and ca_use = '1' and length(ca_id) = $len4 ";
    $row = sql_fetch($sql);
    $cnt = $row['cnt'];

    $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '$tmp_ca_id%' and ca_use = '1' and length(ca_id) = $len2 order by ca_order, ca_id ";
    $result = sql_query($sql);


    while ($row=sql_fetch_array($result)) {
        $sct_ct_here = '';
        if ($ca_id == $row['ca_id']) // 활성 분류 표시
            $sct_ct_here = 'sct_ct_here';

        // 대분류 추가 WJ
        // 사이드 메뉴 커스텀 WJ
       $ca_name='';
       if($row['ca_name']=='cosmetic' || $row['ca_name'] == 'MTS앰플' || $row['ca_name'] =='기능성세럼' || $row['ca_name'] == '재생크림')
       $ca_name = '화장품';
       $ca_name_ctg ='cosmetic';
       $ca_name_link = '<a href="./list.php?ca_id=10"  id="ca_name_h2">'. $ca_name.'</a>';


        //$str .= '<li>';
        if ($cnt) {
            $ca_name_h2 = '<a href="./list.php?ca_id='.$row['ca_id'].'" class="sct_ct_parent '.$sct_ct_here.'" id="ca_name_h2">'.$ca_name.'</a>';
            $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '{$row['ca_id']}%' and ca_use = '1' and length(ca_id) = $len4 order by ca_order, ca_id ";
            $result2 = sql_query($sql2);
            $k=0;
            while ($row2=sql_fetch_array($result2)) {

                $str .= '<li><a href="./list.php?ca_id='.$row2['ca_id'].'" class="sct_ct_child">'.$row2['ca_name'].'</a><li>';
                $k++;

            }
        } else {

            $str .= '<li><a href="./list.php?ca_id='.$row['ca_id'].'" class="sct_ct_parent '.$sct_ct_here.'">'.$row['ca_name'].'</a><li>';
        }
        //$str .= '</li>';
        $exists = true;
    }
}


if ($exists) {

    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<!-- 상품분류 2 시작 { -->

<div class="side_nav">
    <h2 class="subpg_title"><?php echo $ca_name_h2;

    if($ca_name_h2 == '')
    echo $ca_name_link;

    ?> <span>Ι <?php echo $ca_name_ctg; ?></span></h2>
    <ul>
      <?php echo $str; ?>
    </ul>
</div>

<!-- <aside id="sct_ct_2" class="sct_ct">
    <h2>현재 상품 분류와 관련된 분류</h2>
    <ul>
        <?php //echo $str; ?>
    </ul>
</aside> -->
<!-- } 상품분류 2 끝 -->

<?php } ?>

<script type="text/javascript">
// $(document).ready(function(){
//   $('#abc').hover(function(){
//     $('.sct_ct_child').addClass('sct_ct_child_list');
//   }, function() {
//     $( '.sct_ct_child' ).removeClass( "sct_ct_child_list" ).remove();
//   }
//
// );
//
// })
</script>
