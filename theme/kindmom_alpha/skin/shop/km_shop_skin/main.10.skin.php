<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
echo $row['it_id'];


?>
<style>

/* ---스타일시트 리셋 --- */
 /*@import url("http://fonts.googleapis.com/earlyaccess/nanumgothic.css");
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li,
fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, figcaption, figure, footer, header, hgroup, menu, nav, section, summary,
time, mark, audio, video, input  {
    margin: 0;
    padding: 0;
    border: none;
    outline: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}

html, body, form, fieldset, p, div, h1, h2, h3, h4, h5, h6 {
    -webkit-text-size-adjust: none;
}

article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
    display: block;
}

body {

    font-family: NanumGothic, 'Nanum Gothic';
}

ol, ul {
    list-style: none;
}

blockquote, q {
    quotes: none;
}

blockquote:before, blockquote:after, q:before, q:after {
    content: '';
    content: none;
}

ins {
    text-decoration: none;
}

del {
    text-decoration: line-through;
}

table {
    border-collapse: collapse;
    border-spacing: 0;
}*/


/*--defult_layout--*/
/*body{_text-align:center;}*/


</style>

<div id="contaner">
	<ul class="items">

<!-- 상품진열 10 시작 { -->
<?php


for ($i=1; $row=sql_fetch_array($result); $i++) {
 $a=$row[it_id];



// 상품후기 개수를 얻음
$sql3 = " select count(*) as cnt from `{$g5['g5_shop_item_use_table']}` where it_id = '$a' ";
$row3 = sql_fetch($sql3);
$item_use_count = $row3['cnt'];

// 상품문의의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_qa_table']}` where it_id = '$a' ";
$row2 = sql_fetch($sql);
$item_qa_count = $row2['cnt'];









?>

<!--item_1-->
					<li class="goods">

						<div class="item_img">
<a href="<?=$this->href;?><?=$row['it_id'];?>">
<?=get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";?> </a>


</div>
						<div class ="all_info">
								<p class="item_name"><a href="<?=$this->href;?><?=$row['it_id'];?>"><?=$row['it_name'];?></a></p>
								<p class="icon_info"><?=item_icon($row)?></p>
								<p class="price">
									<span class="sale"> <?= floor(($row['it_cust_price']-$row['it_price'])/$row['it_cust_price']*100) ?>%</span>
								    <span class="org_price"><?=$row['it_cust_price'];?>원 </span>
								    <span class="sale_price"><?=$row['it_price'];?>원 </span>

								</p>

						</div>

						<!-- <div class="icon"> </div> -->
						<!-- <div class="review_box">

										<div class="review">상품후기(<?=$item_use_count?>)</div>
										<div class="qna">상품문의(<?=$item_qa_count?>)</div>


						</div> -->
					</li>
					<!--//item_1-->


			<?


}








if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 10 끝 -->

</ul>
</div>
