<script type="text/javascript">
; (function ($) {
    $.fn.extend({
        "nav": function (con) {
            var $this = $(this), $nav = $this.find('.switch-tab'), t = (con && con.t) || 4500, a = (con && con.a) || 1000, i = 0, autoChange = function () {
                $nav.find('a:eq(' + (i + 1 === 3 ? 0 : i + 1) + ')').addClass('current').siblings().removeClass('current');
                $this.find('.event-item:eq(' + i + ')').css('display', 'none').end().find('.event-item:eq(' + (i + 1 === 3 ? 0 : i + 1) + ')').css({
                    display: 'block',
                    opacity: 0.3
                }).animate({
                    opacity: 1
                }, a, function () {
                    i = i + 1 === 3 ? 0 : i + 1;
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
.idx_oem{ position: relative;}
.idx_oem{ width:340px; height:200px;}
.idx_oem .event-item{ position: inherit;}
.idx_oem:hover .switch-nav{ top:80px; display:none;}
.idx_oem .switch-tab{bottom: -10px;margin-left: -20px;}
</style>

<div id="inner_1">
	<div class="hot-event idx_oem">
		<div class="switch-nav"><a href="javascript:;" onclick="return false;" class="prev"><i class="ico i-prev"></i><span class="hide-clip">Pre</span></a><a href="<?php echo zen_href_link(FILENAME_FIBERSTORE_WITH_PARTNERS);?>" onclick="return false;" class="next"><i class="ico i-next"></i><span class="hide-clip">Next</span></a></div>
     
		<?php
		$oem_banner = fs_get_data_from_db_fields_array(array('pc_path','alt','url'),'fs_banner_manage_new','groups=2 and language_id='.$_SESSION['languages_id'],'order by sort');
		foreach ($oem_banner as $k=>$v){
		$url = !empty($v[2]) ? $v[2] : 'javascript:void(0)';
		?>
		<div class="event-item"  <?php if($k==0){echo 'style="display: block"';}else{echo 'style="display: none"';}?> > 
			<img src="<?php echo $v[0];?>" alt="<?php echo $v[1];?>" width="304" height="190">
		</div>
		<?php } ?>
		
		<div class="switch-tab"> 
			<a href="javascript:;" onclick="return false;" class="current">1</a> 
			<a href="javascript:;" onclick="return false;">2</a> 
			<a href="javascript:;" onclick="return false;">3</a> 
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#inner_1').nav({ t: 4500, a: 1000 });
</script>