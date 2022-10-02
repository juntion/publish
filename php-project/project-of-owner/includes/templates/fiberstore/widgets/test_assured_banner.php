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
.cn_transceiver_photo{ height:574px; position:relative;}
.cn_transceiver_photo .switch-tab{ top:540px; left:570px;}
.cn_transceiver_photo .switch-nav{ top:260px;}
.cn_transceiver_photo .switch-nav .next{left: 1160px;}

@media (max-width: 1220px){
.system{ height:70px;}
.cn_transceiver_photo{ height:459px;}
.cn_transceiver_photo .switch-nav{ top:200px;}
.hot-event .event-item img{ width:100%;}
.cn_transceiver_photo .switch-nav .next{left:920px;}
.cn_transceiver_photo .switch-tab{ top:429px; left:480px;}
	}
	
@media (max-width:959px){
.cn_transceiver_photo{ height:inherit; position:relative;}
.hot-event .event-item{ position: inherit;}
.cn_transceiver_photo .switch-tab{ top:initial; left:50%; margin-left:-30px;bottom: 15px;}
.cn_transceiver_photo .switch-nav{top: 50%; margin-top: -36px; width: 100%;}
.cn_transceiver_photo .switch-nav .next{right: 0;left: initial;}


}
	
	
</style>
<div id="inner_1">
  <div class="hot-event cn_transceiver_photo">
<div class="switch-nav"><a href="javascript:;" onclick="return false;" class="prev"><i class="ico i-prev"></i><span class="hide-clip">Pre</span></a><a href="<?php echo zen_href_link(FILENAME_FIBERSTORE_WITH_PARTNERS);?>" onclick="return false;" class="next"><i class="ico i-next"></i><span class="hide-clip">Next</span></a></div>

      <div class="event-item"  style="display: block;">
      <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/test_photo.jpg" alt="Fiberstore test_photo.jpg" >
    </div>


     <div class="event-item"  style="display: none;">
	   <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/test_photo01.jpg" alt="Fiberstore test_photo02.jpg" >
    </div>

     <div class="event-item" style="display: none;">
      <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/test_photo02.jpg" alt="Fiberstore test_photo03.jpg" >
    </div>



    <div class="switch-tab"> <a href="javascript:;" onclick="return false;" class="current">1</a> <a href="javascript:;" onclick="return false;">2</a> <a href="javascript:;" onclick="return false;">3</a> </div>
  </div>
</div>
<script type="text/javascript">
        $('#inner_1').nav({ t: 4500, a: 1000 });
    </script>
