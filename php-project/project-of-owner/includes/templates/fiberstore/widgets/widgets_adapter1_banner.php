<script type="text/javascript">
; (function ($) {
    $.fn.extend({
        "nav": function (con) {
            var $this = $(this), $nav = $this.find('.switch-tab'), t = (con && con.t) || 4500, a = (con && con.a) || 1000, i = 0, autoChange = function () {
                $nav.find('a:eq(' + (i + 1 === 4 ? 0 : i + 1) + ')').addClass('current').siblings().removeClass('current');
                $this.find('.event-item:eq(' + i + ')').css('display', 'none').end().find('.event-item:eq(' + (i + 1 === 4 ? 0 : i + 1) + ')').css({
                    display: 'block',
                    opacity: 0.3
                }).animate({
                    opacity: 1
                }, a, function () {
                    i = i + 1 === 4 ? 0 : i + 1;
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
                i = $(this).attr('class') === 'prev' ? current -2 : current;
                i = i === -2 ? 2 : i;
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
.adapter_banner:hover .switch-nav{ top:208px; }
.adapter_banner .switch-nav .next{ left:214px;}
.adapter_banner .switch-nav a{ padding:5px 0;}
</style>
<div id="inner_1">
  <div class="hot-event adapter_banner">
    <div class="switch-nav"><a href="javascript:;" onclick="return false;" class="prev"><i class="ico i-prev"></i><span class="hide-clip">Pre</span></a><a href="<?php echo zen_href_link(FILENAME_FIBERSTORE_WITH_PARTNERS);?>" onclick="return false;" class="next"><i class="ico i-next"></i><span class="hide-clip">Next</span></a></div>

      <div class="event-item"  style="display: block;">
      <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/adapter_pic01.jpg" alt="Fiberstore adapter_pic01.jpg" width="240" height="466">
    </div>


     <div class="event-item"  style="display: none;">
	   <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/adapter_pic03.jpg" alt="Fiberstore adapter_pic03.jpg" width="240" height="466">
    </div>

     <div class="event-item" style="display: none;">
      <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/adapter_pic02.jpg" alt="Fiberstore adapter_pic02.jpg" width="240" height="466">
    </div>
     <div class="event-item" style="display: none;">
      <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/adapter_pic04.jpg" alt="Fiberstore adapter_pic04.jpg" width="240" height="466">
    </div>

  <div class="switch-tab" style="display: none"> <a href="javascript:;" onclick="return false;" class="current">1</a> <a href="javascript:;" onclick="return false;">2</a> <a href="javascript:;" onclick="return false;">3</a> <a href="javascript:;" onclick="return false;">4</a>  </div>
  </div>
</div>
<script type="text/javascript">
        $('#inner_1').nav({ t: 4500, a: 1000 });
    </script>
