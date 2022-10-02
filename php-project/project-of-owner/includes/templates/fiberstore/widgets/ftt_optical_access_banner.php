<!--<script type="text/javascript">
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
.hot-event .switch-tab{top: 268px; left:50%; margin-left:-30px;}
@media(max-width:1220px){.hot-event .switch-tab{ left:50%}}
</style>-->
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
<!--    <div class="switch-nav"><a href="javascript:;" onclick="return false;" class="prev"><i class="ico i-prev"></i><span class="hide-clip">Pre</span></a><a href="<?php echo zen_href_link(FILENAME_FIBERSTORE_WITH_PARTNERS);?>" onclick="return false;" class="next"><i class="ico i-next"></i><span class="hide-clip">Next</span></a></div>-->

    <div class="event-item" style="display:block ;"> <a href="<?php echo $code;?>/support/ftth-indoor-outdoor-splitter-terminal-solution-92" class="" target="_blank">
    <img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/wdm_fiber_network_banner01.jpg" alt="FS.COM wdm_fiber_network_banner01.jpg" class="m_none">
    <img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/m_wdm_fiber_network_banner01.jpg" alt="FS.COM m_wdm_fiber_network_banner01.jpg" class="m_display" >
    </a>
    </div>
<!--    <div class="event-item" style="display:block ;"> <a href="/reversible-polarity-lc-uniboot-patch-cable.html" class=""  target="_blank"><img src="<?php echo $code;?>/includes/templates/fiberstore/images/banner/wdm_fiber_network_banner04.jpg" alt="FS.COM wdm_fiber_network_banner04" /></a>
    </div>-->
    

  


   <!-- <div class="switch-tab"> <a href="javascript:;" onclick="return false;" class="current">1</a> <a href="javascript:;" onclick="return false;">2</a> <a href="javascript:;" onclick="return false;">3</a> <a href="javascript:;" onclick="return false;">4</a> <a href="javascript:;" onclick="return false;">5</a><a href="javascript:;" onclick="return false;">6</a></div>-->
  </div>
</div>
</div>
</div>
<!--<script type="text/javascript">
        $('#inner').nav({ t: 5500, a: 1000 });
    </script>-->
