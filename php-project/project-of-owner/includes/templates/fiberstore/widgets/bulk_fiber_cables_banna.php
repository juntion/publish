<script type="text/javascript">
; (function ($) {
    $.fn.extend({
        "nav": function (con) {
            var $this = $(this), $nav = $this.find('.switch-tab'), t = (con && con.t) || 4500, a = (con && con.a) || 1000, i = 0, autoChange = function () {
                $nav.find('a:eq(' + (i + 1 === 2 ? 0 : i + 1) + ')').addClass('current').siblings().removeClass('current');
                $this.find('.event-item:eq(' + i + ')').css('display', 'none').end().find('.event-item:eq(' + (i + 1 === 2 ? 0 : i + 1) + ')').css({
                    display: 'block',
                    opacity: 0.1
                }).animate({
                    opacity: 1
                }, a, function () {
                    i = i + 1 === 2 ? 0 : i + 1;
                }).siblings('.event-item').css({
                    display: 'none',
                    opacity: 0
                });
            }, st = setInterval(autoChange, t);
            $this.hover(function () {
                clearInterval(st);
                return false;
            }, function () {
                st = setInterval(autoChange, t);
                return false;
            }).find('.switch-nav>a').bind('click', function () {
                var current = $nav.find('.current').index();
                i = $(this).attr('class') === 'prev' ? current - 2 : current;
                autoChange();
                return false;
            }).end().find('.switch-tab>a').bind('click', function () {
                i = $(this).index() - 1;
                autoChange();
                return false;
            });
            return $this;
        }
    });
}(jQuery));
	</script>
<style type="text/css">
.menu_02{ display:none;}
.content{ padding:0;}

@media(max-width:1220px){}
</style>
<?php 
$language_code = fs_get_data_from_db_fields('code','languages','languages_id='.$_SESSION['languages_id'],'');
if($_SESSION['languages_id'] !=1){
	$code = '/'.$language_code; 
}else{
	$code ='';
}
?>
<div class="classified_banenr">
	<div class="classified_banenr_con">
		<div id="inner">
			<div class="hot-event">
				<?php 
				$dwdm_banner = fs_get_data_from_db_fields_array(array('pc_path','mobile_path','alt','url'),'fs_banner_manage_new','groups=4 and category_id='.(int)$_GET['cPath'].' and language_id='.$_SESSION['languages_id'],'order by sort');
				foreach($dwdm_banner as $k=>$v){
				if($v[0] !=''){
				?>
				<div class="event-item" <?php if($k==0){echo 'style="display:block"';}else{echo 'style="display:none"';}?> >
					<a href="<?php echo $code.$v[3]?>" class=""  target="_blank">
						<!--pc-->
						<img src="<?php echo $code.$v[0]?>" alt="<?php echo $v[2]?>"  class="m_none" />
						<!--mobile-->
						<img src="<?php echo $code.$v[1]?>" alt="<?php echo $v[2]?>"  class="m_display"/>
					</a>
				</div>
				<?php }} ?>
				
				<div class="switch-tab">
					<?php
					foreach($dwdm_banner as $k=>$v){
					if($v[0] !=''){
					?>
					<a href="javascript:;" onclick="return false;" <?php if($k==0)echo 'class="current"';?> ><?php echo $k+1;?></a>
					<?php }} ?>
				</div>
		  </div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#inner').nav({ t: 5500, a: 1000 });
</script>