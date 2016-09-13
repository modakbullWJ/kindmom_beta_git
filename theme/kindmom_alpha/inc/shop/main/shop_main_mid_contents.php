<div id="middle_contents">
	<?php if($default['de_type4_list_use']) { ?>
	<!-- 인기상품 시작 { -->
	 <section class="sct_wrap">
	    <header>
	        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4">인기상품</a>
						<div class="line">

						</div>

					</h2>

	        <p class="sct_wrap_hdesc"></p>
	    </header>
	    <?php
	    $list = new item_list();
	    $list->set_type(4);
	    $list->set_view('it_id', false);
	    $list->set_view('it_name', true);
	    $list->set_view('it_basic', true);
	    $list->set_view('it_cust_price', true);
	    $list->set_view('it_price', true);
	    $list->set_view('it_icon', true);
	    $list->set_view('sns', true);
	    echo $list->run();
	    ?>
	</section>
	<!-- } 인기상품 끝 -->
	<?php } ?>

</div>
