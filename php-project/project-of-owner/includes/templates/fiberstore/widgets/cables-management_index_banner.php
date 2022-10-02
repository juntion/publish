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
.content { padding:0; }
.menu_02 { display:none; }
@media(max-width:1220px){.hot-event .switch-tab{ left:50%}}
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

 <div class="event-item" style="display:block ;"><a href="<?php echo $code;?>/products/59576.html" target="_blank">
 <img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/d-ring-cable-management-panel.jpg" alt="FS.COM d-ring-cable-management-panel.jpg"  class="m_none"/>
 <img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/panel-banner.jpg" alt="FS.COM d-ring-cable-management-panel.jpg" class="m_display" />
 </a>
    </div>
    
 <div class="event-item" style="display: none;"> <a href="<?php echo $code;?>/bend-insensitive-fiber-cables.html" class=""  target="_blank">
 <img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/cable_banner04.jpg" alt="FS.COM cable_banner04.jpg" class="m_none"/>
<img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/m_cable_banner04.jpg" alt="FS.COM m_cable_banner04.jpg" class="m_display" />
 
 </a>
    </div>
     
    <?php /*?><div class="event-item"  style="display: none;"> <a href="<?php echo $code;?>/reversible-polarity-lc-uniboot-patch-cable.html" class=""  target="_blank">
	<img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/wdm_fiber_network_banner04.jpg" alt="FS.COM wdm_fiber_network_banner04.jpg" class="m_none"/>
	<img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/m_wdm_fiber_network_banner04.jpg" alt="FS.COM m_wdm_fiber_network_banner04.jpg" class="m_display" />
	</a> </div><?php */?>

  


    <div class="switch-tab"> <a href="javascript:;" onclick="return false;" class="current">1</a> <a href="javascript:;" onclick="return false;">2</a>  <!--<a href="javascript:;" onclick="return false;">3</a>-->
  </div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
        $('#inner').nav({ t: 5500, a: 1000 });
    </script>
