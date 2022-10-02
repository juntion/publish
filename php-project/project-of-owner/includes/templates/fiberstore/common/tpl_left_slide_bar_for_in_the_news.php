<?php
global $db;


$event_sql ="select date_format(news_date_published,'%Y') as Eyear from ".TABLE_NEWS_ARTICLES." group by date_format(news_date_published,'%Y') ORDER BY news_date_published desc ";
$event_result = $db->Execute($event_sql);
while (!$event_result->EOF){
	$Eyear[] = $event_result->fields['Eyear'];
	$event_result->MoveNext();
}

?>
<div class="con_left">
	<div class="solution_nav">
		<b>Fiberstore News</b>

		<dl id="nav" class="solution_nav_01">
			<dt><a class="solution_nav_ForJS" href="javascript:void(0);">News Releases</a></dt>
			<?php
			for ($i = 0,$n = sizeof($Eyear); $i < $n;$i++){
				if(isset($_GET['event'])){
					if($Eyear[$i] == $_GET['event']){
						echo '<dd class="sidebar_products" style="display:block;"><a href="'.zen_href_link(FILENAME_IN_THE_NEWS,'event='.$Eyear[$i],'NONSSL').'">'.$Eyear[$i].'</a></dd>';
					}else{
						echo '<dd style="display:block;" ><a href="'.zen_href_link(FILENAME_IN_THE_NEWS,'event='.$Eyear[$i],'NONSSL').'">'.$Eyear[$i].'</a></dd>';
					}
				}else echo '<dd style="display:block;"><a href="'.zen_href_link(FILENAME_IN_THE_NEWS,'event='.$Eyear[$i],'NONSSL').'">'.$Eyear[$i].'</a></dd>';
			}
			?>
		</dl>

	</div>

</div>
<script type="text/javascript">
$(function(){
	$(".solution_nav_01 > dt >   a").click(function(){
		if('solution_nav_ForJS' == this.className) { 
			$(this).removeClass('solution_nav_ForJS').addClass('solution_nav_js');
			$(this).parents('dl').siblings('dl').each(function(){
				if($(this).children('dt').children('a').attr('class') == 'solution_nav_js' ){
					$(this).children('dt').children('a').removeClass('solution_nav_js').addClass('solution_nav_ForJS');
					$(this).children('dd').css('display','none');
				}
				});	
			$(this).parents('dt').siblings('dd').css('display','block');
		}else{
			$(this).removeClass('solution_nav_js').addClass('solution_nav_ForJS');
			$(this).parents('dt').siblings('dd').css('display','none');
			 }
	});
	});

function narrow_by_pop(url){
	open(url);
}

</script>
