<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$thumb_width=206;
$thumb_height=132;

$cat_row = sql_fetch(" SELECT bo_category_list FROM $g5[board_table] WHERE bo_table = '$bo_table' ");
$ca_name_arr = explode("|", $cat_row[bo_category_list]); // 구분자가 , 로 되어 있음

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/css/prettyPhoto.css">', 0);
?>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/popups.js"></script>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/jquery.quicksand.js"></script>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/quicksand.js"></script>
</head>

<body >

<div class="wrapper"> 

	<!-- CONTENT BEGIN -->
	<div id="content" class="block_portfolio_4c">
		<div class="inner">

		    <div class="separator_14"></div>
		    <?php if($cat_row) { 			
			echo "<div class='block_filter fl'>";
				echo "<div class='filter_text'></div>";
				echo "<ul>";
					echo "<li><a href='javascript:void(0)' class='active' title='all'>전체</a></li>\n";
					for ($i=0; $i<count($ca_name_arr); $i++)  { 
					echo "<li><a href='javascript:void(0)' title=\"{$ca_name_arr[$i]}\">$ca_name_arr[$i]</a></li>\n";
					} 
				echo "</ul>";
			echo "</div>";
			} 
			?>
						
			<div class="separator_26"></div>
			<div class="block_four_columns">
				<ul class="block_filtered_items">
					<!-- portfolio item --> 
					<?php 
						for ($i=0; $i<count($list); $i++) {  
						/* 원본 이미지를 뽑아보자  - JooSung - 20150528 추가 */
						$list[$i][file] =get_file($bo_table, $list[$i][wr_id]);
						$file = $list[$i][file][0][path].'/'. $list[$i][file][0][file];
						/* 원본 이미지를 뽑아보자  - JooSung - 20150528 추가 */
						$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height);
						if($thumb['src']) {
						$img = '<img src="'.$thumb['src'].'" width="'.$thumb_width.'" height="'.$thumb_height.'" title="'.$list[$i][subject].'" />';
						} else {
						$img = '<img src="'.$latest_skin_url.'/img/noimage.png" width="'.$thumb_width.'" height="'.$thumb_height.'" title="이미지 없음" />';
						}

						$content = cut_str(strip_tags($list[$i][wr_content]), 76);
					?>		
										
					<li class="column_3 filtering_item <?php echo $list[$i][wr_link1]?"video":""?>" title="<?php echo $list[$i][ca_name]?>">
						<div class="pic_wrapper"> 
							<span class="block_general_pic"> 
							    <? if ($list[$i][wr_link1]) { ?>
								<a href="<?php echo $list[$i][wr_link1]?>" rel="prettyPhoto[gallery]" title="<?php echo $list[$i][subject]?>" class="hover_1">
								<? } else { ?>
								<a href="<?php echo $file?>" rel="prettyPhoto[gallery]" title="<?php echo $list[$i][subject]?>" class="hover_1">
								<? } ?>
									<img width="<?php echo $thumb_width?>" height="<?php echo $thumb_height?>" src="<?php echo $thumb['src']?>" class="r_conner_pic wp-post-image" title="<?php echo $list[$i][subject]?>" />
									<span class="block_hover">&nbsp;</span> 
								</a>							
								<a href="<?php echo $list[$i][href]?>" class="post_link"><span>Full Post</span></a> 
							</span> 
						</div>
						<h3><a href="<?php echo $list[$i][href]?>"><?php echo $list[$i][subject]?></a></h3>
						<p class="description"><?php echo $content?> 
						<a href="<?php echo $list[$i][href]?>" class="arr_d"><img src="<?php echo $latest_skin_url?>/images/arrow_1.gif" alt="" /></a></p>
					</li>

			        <? } ?>
				<!-- portfolio item --> 						
				</ul>
			</div>			
			<div class="separator_16"></div>			
		</div>
	</div>
	<!-- CONTENT END --> 

	<div class="separator_6"></div>
	

</div>

