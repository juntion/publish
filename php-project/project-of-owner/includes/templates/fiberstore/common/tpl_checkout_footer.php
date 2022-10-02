<?php
/**
 * checkout footer
 */
?>
<div class="footer">
<div style="border-bottom:1px solid #e5e5e5; border-top:1px solid #C6C6C6;"></div>
	<div class="footer_01" >
	<div class="footer_08" style=" border-top:none;">
       <?php  require($template->get_template_dir('tpl_footer_keyword_tags.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.'tpl_footer_keyword_tags.php');?>
	   </div>
            </div>
</div>



<?php 
// if (FILENAME_PRODUCT_INFO == $_GET['main_page'] && isset($_GET['products_id']) && $_GET['products_id']) {
?>


<!-- BEGIN: Google Trusted Stores -->
<script type="text/javascript">
var gts = gts || [];

gts.push(["id", "229574"]);
gts.push(["badge_position", "BOTTOM_RIGHT"]);
gts.push(["locale", "en_US"]);
gts.push(["google_base_offer_id", "<?php echo (isset($_GET['products_id']) && $_GET['products_id']) ? $_GET['products_id'] : '';?>"]);
gts.push(["google_base_subaccount_id", "9038559"]);
gts.push(["google_base_country", "US"]);
gts.push(["google_base_language", "en"]);

(function() {
var gts = document.createElement("script");
gts.type = "text/javascript";
gts.async = true;
gts.src = "https://www.googlecommerce.com/trustedstores/gtmp_compiled.js";
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(gts, s);
})();
</script>
<!-- END: Google Trusted Stores -->

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-18196894-49']);
_gaq.push(['_addOrganic', 'sogou', 'query']);
_gaq.push(['_addOrganic', 'youdao', 'q']);
_gaq.push(['_addOrganic', 'soso', 'w']);
_gaq.push(['_addOrganic', 'sina', 'q']);
 _gaq.push(['_trackPageview']);
 

(function() {
      var upfront = document.createElement('SCRIPT'); upfront.type = "text/javascript"; upfront.async = true;
      upfront.src = document.location.protocol + "//upfront.thefind.com/scripts/main/utils-init-ajaxlib/upfront-badgeinit.js";
      upfront.text = "thefind.upfront.init('tf_upfront_badge', '612d3fde52498698122c05e2051efa13')";
      document.getElementsByTagName('HEAD')[0].appendChild(upfront);
    })();
</script>

<?php if(!german_warehouse('country_code', $_SESSION['countries_iso_code']) || (!isset($_COOKIE['fs_google_analytics']) || $_COOKIE['fs_google_analytics'] != 'no')){ ?>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PBGKN3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PBGKN3');</script>
<!-- End Google Tag Manager -->
<?php }?>