<?php 
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	$action = $_GET['ajax_request_action'];
	switch($action){
		case 'article_update':
			$page = $_POST['page'];
			//$catery_id = get_article_one_id();
			$limit =($page-1)*15;
			$articles_query = "select a.doc_article_id,a.doc_article_image,ad.doc_article_title,ad.doc_article_intro from 
				" .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
				left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id) where a.article_type=2 and a.doc_article_status = 1 
				and ad.language_id = ".(int)$_SESSION['languages_id']." order by doc_article_sort_order limit $limit,15";	

			$get_articles = $db->Execute($articles_query);
			$article_array = array();
			if ($get_articles->RecordCount()){
				while (!$get_articles->EOF){
					$article_array[] = array(
						'id' => $get_articles->fields['doc_article_id'],
						'title' => $get_articles->fields['doc_article_title'],
						'intro' => $get_articles->fields['doc_article_intro'],
						'image' => stripslashes($get_articles->fields['doc_article_image']),
					);
					$get_articles->MoveNext();
				}
			}
			$html = '';
			if($article_array){
				foreach($article_array as $article){
					$aid = $article['id'];
					$artilce_title = $article['title'];
					$artilce_intro = $article['intro'];
					$artilce_intro = substr($artilce_intro,0,100).'...';
					$image= $article['image'];
					
					$html .= '<li><a target="_blank" href="'.zen_href_link("products_detail","&s_id=".$aid).'">
							<div  class="product_index_con01_pic">
								<img width="285px" height="165px" src="'.HTTPS_IMAGE_SERVER.'images/'.$image.'" alt="'.$artilce_title.'">
								<div class="white_shadow"></div>
							</div>
							<span><b>'.$artilce_title.'</b>
							<p>'.$artilce_intro.'</p> 
							<em target="_blank" title="'.$artilce_title.'" href="'.zen_href_link('products_detail','&s_id='.$aid).'">'.FS_LEARN_MORE.'</em> 
							</span> </a></li>';
				}
			}
			echo $html;
			exit;
		break;
	}
}
?>