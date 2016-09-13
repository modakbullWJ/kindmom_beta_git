<div id="main_prd_category">

      <section class="sct_wrap">
          <header class="prd_title_hit">
              <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1">히트 상품</a></h2>
              <div class="line">

              </div>

              <p class="sct_wrap_hdesc"> </p>
          </header>
          <?php
          $list = new item_list();
          $list->set_type(1);
          $list->set_view('it_img', true);
          $list->set_view('it_id', false);
          $list->set_view('it_name', true);
          $list->set_view('it_basic', false);
          $list->set_view('it_cust_price', true);
          $list->set_view('it_price', true);
          $list->set_view('it_icon', false);
          $list->set_view('sns', true);
          echo $list->run();
          ?>
      </section>

</div>


<script>
$( document ).ready(function() {
  $( ".prd_title_hit" ).hover(
function() {

  $( '.line' ).addClass( "hover" );
}, function() {
  $( '.line' ).removeClass( "hover" );
}
);
});
</script>
