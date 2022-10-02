<?php
/**
 * Sitemap XML
 *
 * @package Sitemap XML
 * @copyright Copyright 2005-2009, Andrew Berezin eCommerce-Service.com
 * @copyright Portions Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @link http://www.sitemaps.org/
 * @version $Id: sitemapxml.php, v 2.1.0 30.04.2009 10:35 AndrewBerezin $
 */
////////////////////////////////////////////////////////////////////////
// Sitemap Base Class
@define('SITEMAPXML_MAX_ENTRYS', 50000);
@define('SITEMAPXML_MAX_SIZE', 10485760);
class zen_SiteMapXML {
  var $filename;
  var $savepath;
  var $sitemapindex;
  var $base_url;
  var $submitFlag_url;
  var $duplicatedLinks;
  var $checkurl;
  var $languagesCodes = array();
  var $sitemapItems = array();
  var $submitFlag = true;
  var $inline = true;
  var $ping = false;
  var $rebuild = false;
  var $genxml = true;
  var $messageSilently = true;
  var $stylesheet = '';

  var $sitemapFileItems = 0;
  var $sitemapFileSize = 0;
  var $sitemapFileItemsTotal = 0;
  var $sitemapFileSizeTotal = 0;
  var $sitemapFileName;
  var $sitemapFileNameNumber = 0;
  var $sitemapFileFooter = '</urlset>';
  var $sitemapFileHeader;
  var $sitemapFileBuffer = '';
  var $sitemapxml_max_entrys;
  var $sitemapxml_max_size;

  var $fb_maxsize = 4096;
  var $fb = '';
  var $fp = null;
  var $fn = '';

  function zen_SiteMapXML($inline=false, $ping=false, $rebuild=false, $genxml=true) {
    global $db;

    $this->filename = "sitemap_of_";
    $this->sitemapindex = "sitemap.xml";
    //$this->base_url = FS_FSCOM . DIR_WS_CATALOG;
	$this->base_url = HTTPS_SERVER . DIR_WS_CATALOG;
	if($_GET['lang']){
		$this->base_url .= trim($_GET['lang']).DIR_WS_CATALOG;
	}  
    $this->duplicatedLinks = array();
    $this->sitemapItems = array();
    $this->savepath = DIR_FS_CATALOG;

    $this->submit_url = utf8_encode(urlencode($this->base_url . $this->sitemapindex));
    $this->submitFlag = true;
    $this->messageSilently = $inline;
    $this->inline = $inline;
    $this->ping = $ping;
    $this->rebuild = $rebuild;
    $this->checkurl = false;
    $this->genxml = $genxml;
    $this->sitemapFileFooter = '</urlset>';
    $this->sitemapFileHeader = $this->_SitemapXMLHeader('urlset');
    $this->sitemapFileBuffer = '';
    $this->sitemapxml_max_entrys = SITEMAPXML_MAX_ENTRYS;
    $this->sitemapxml_max_size = SITEMAPXML_MAX_SIZE-strlen($this->sitemapFileFooter);
    global $lng;
    if (!is_object($lng)) {
      $lng = new language();
    }
    foreach ($lng->catalog_languages as $language) {
      $this->languagesCodes[$language['id']] = $language['code'];
    }
    $this->sitemapItems = array();

//    $this->message('Save path - "' . $this->savepath . '"' . '<br />');
    /*
        if (!($robots_txt = @file_get_contents($this->savepath . 'robots.txt'))) {
          $this->message('<b>File "robots.txt" not found in save path - "' . $this->savepath . 'robots.txt"</b>' . '<br />');
        } elseif (!preg_match("@Sitemap:\s*(.*)\n@i", $robots_txt . "\n", $m)) {
          $this->message('<b>Sitemap location don\'t specify in robots.txt</b>' . '<br />');
        } elseif (trim($m[1]) != $this->base_url . $this->sitemapindex) {
          $this->message('<b>Sitemap location specified in robots.txt "' . trim($m[1]) . '" another than "' . $this->base_url . $this->sitemapindex . '"</b>' . '<br />');
        }
    */
  }

  function SitemapOpen($file, $last_date) {
    if (strlen($this->sitemapFileBuffer) > 0) $this->SitemapClose();
    if (!$this->genxml) return false;
    $this->sitemapFile = $file;
    $delete= $_GET['delete'];
    $file_name = $this->_getNameFileXML($file);
    if($file_name==$delete){
      if (!unlink($file_name))
      {
        echo ("Error deleting".$file_name);
      }
      else
      {
        echo ("Deleted".$file_name);
      }
    }
    $this->sitemapFileName = $this->_getNameFileXML($file);
    if ($this->_checkFTimeSitemap($this->sitemapFileName, $last_date) == false) return false;
    if (!$this->_fileOpen($this->sitemapFileName)) return false;
    $this->_SitemapReSet();
    $this->sitemapFileBuffer .= $this->sitemapFileHeader;
    return true;
  }

  function SitemapSetMaxItems($maxItems) {
    $this->sitemapFileItemsMax = $maxItems;
    return true;
  }

  function SitemapWriteItem($loc, $lastmod='', $changefreq='',$priority,$picture_microdata="") {
    if (!$this->genxml) return false;
    if (isset($this->duplicatedLinks[$loc])) return false;
    $this->duplicatedLinks[$loc] = true;
    if ($this->checkurl && !$this->_curlExecute($loc, 'header')) return false;
    $itemRecord  = '';
    $itemRecord .= ' <url>' . "\n";
    $itemRecord .= '  <loc>' . utf8_encode($loc) . '</loc>' . "\n";
    if (isset($lastmod) && zen_not_null($lastmod)) {
      $itemRecord .= '  <lastmod>' . $this->_LastModFormat($lastmod) . '</lastmod>' . "\n";
    }
    if (isset($changefreq) && zen_not_null($changefreq)) {
      $itemRecord .= '  <changefreq>' . $changefreq . '</changefreq>' . "\n";
    }
    if ($priority) {
      $itemRecord .= '  <priority>' . $priority . '</priority>' . "\n";
    }
    if ($picture_microdata) {
      $itemRecord .=  $picture_microdata . "\n";
    }
    $itemRecord .= ' </url>' . "\n";

    if ($this->sitemapFileItems >= $this->sitemapxml_max_entrys || $this->sitemapFileSize+strlen($itemRecord) >= $this->sitemapxml_max_size) {
      $this->_SitemapCloseFile();

      $this->sitemapFileName = $this->_getNameFileXML($this->sitemapFile . substr('000' . $this->sitemapFileNameNumber, -3));
      if (!$this->_fileOpen($this->sitemapFileName)) return false;
      $this->_SitemapReSetFile();
      $this->sitemapFileBuffer .= $this->sitemapFileHeader;
    }
    $this->sitemapFileBuffer .= $itemRecord;
    $this->_fileWrite($this->sitemapFileBuffer);
    $this->sitemapFileSize += strlen($this->sitemapFileBuffer);
    $this->sitemapFileSizeTotal += strlen($this->sitemapFileBuffer);
    $this->sitemapFileItems++;
    $this->sitemapFileItemsTotal++;
    $this->sitemapFileBuffer = '';
    return true;
  }

  function SitemapClose() {
    $this->_SitemapCloseFile();
    if ($this->sitemapFileItemsTotal > 0) {
      $this->message(sprintf(TEXT_TOTAL_SITEMAP, ($this->sitemapFileNameNumber+1), $this->sitemapFileItemsTotal, $this->sitemapFileSizeTotal) . '<br />');
    }
    $this->_SitemapReSet();
  }

// generate sitemap index file
  function GenerateSitemapIndex() {
    if ($this->genxml) {
      $this->message('<h3>' . TEXT_HEAD_SITEMAP_INDEX . '</h3>');
      $content = $this->_SitemapXMLHeader('sitemapindex');
      $records_count = 0;
      $pattern = '/^' . $this->filename . '.*(\.xml\.gz'  . ')$/';
      if ($za_dir = @dir(rtrim($this->savepath, '/'))) {
        clearstatcache();
        while ($filename = $za_dir->read()) {
          if (preg_match($pattern, $filename) > 0 && $filename != $this->sitemapindex && filesize($this->savepath . $filename) > 0) {

            $file_url = HTTPS_SERVER.DIR_WS_CATALOG;
            $name_array = explode('_',$filename);
            $name = end($name_array);
            $country_code_array = explode('.',$name);
            $country_code = $country_code_array[0];
            if(in_array($country_code,$GLOBALS['fs_all_site'])){
                $file_url = HTTPS_SERVER.DIR_WS_CATALOG.$country_code.DIR_WS_CATALOG;
            }

            $this->message(TEXT_INCLUDE_FILE . $filename . ' (<a href="' . $file_url . basename($filename) . '" target="_blank">' . $file_url . basename($filename) . '</a>)' . '<span>&nbsp| <a href="sitemap_handler.php?action=one_key_generate&delete='.$filename.'">map revision</a><span><br />');
            $content .= ' <sitemap>' . "\n";
            $content .= '  <loc>' . $file_url . basename($filename) . '</loc>' . "\n";
            $content .= '  <lastmod>' . $this->_LastModFormat(filemtime($this->savepath . $filename)) . '</lastmod>' . "\n";
            $content .= ' </sitemap>' . "\n";
            $records_count++;
          }
        }
      }
        $xmlCn = array('case','categories','popular','products','feisu_pages','specials',
            'solution_article','video');
        foreach ($xmlCn as $value){
            $href = 'https://www.fs.com/cn/images/sitemapOf'.$value.'.xml.gz';
            $content .= ' <sitemap>' . "\n";
            $content .= '  <loc>'.$href.'</loc>' . "\n";
            $content .= '  <lastmod>' . $this->_LastModFormat(time()) . '</lastmod>' . "\n";
            $content .= ' </sitemap>' . "\n";
        }

        $content .= '</sitemapindex>';
      $this->_SaveFileXML($content, 'index', $records_count);
    }

    if ($this->inline) {
      $this->_outputSitemapIndex();
    }

    if ($this->ping) {
      $this->_SitemapPing();
    }

    if ($this->inline) {
      die();
    }

  }

// retrieve full cPath from category ID
  function GetFullcPath($cID) {
    global $db;
    static $parent_cache = array();
    $cats = array();
    $cats[] = $cID;
    $parent = $db->Execute("SELECT parent_id, categories_id
                            FROM " . TABLE_CATEGORIES . "
                            WHERE categories_id=" . (int)$cID);
    while(!$parent->EOF && $parent->fields['parent_id'] != 0) {
      $parent_cache[(int)$parent->fields['categories_id']] = (int)$parent->fields['parent_id'];
      $cats[] = $parent->fields['parent_id'];
      if (isset($parent_cache[(int)$parent->fields['parent_id']])) {
        $parent->fields['parent_id'] = $parent_cache[(int)$parent->fields['parent_id']];
      } else {
        $parent = $db->Execute("SELECT parent_id, categories_id
                                FROM " . TABLE_CATEGORIES . "
                                WHERE categories_id=" . (int)$parent->fields['parent_id']);
      }
    }
    $cats = array_reverse($cats);
    $cPath = implode('_', $cats);
    return $cPath;
  }

  function setCheckURL($checkurl) {
    $this->checkurl = $checkurl;
  }

  function setStylesheet($stylesheet) {
    $this->stylesheet = $stylesheet;
    $this->sitemapFileHeader = $this->_SitemapXMLHeader('urlset');
  }

  function getLanguageParameter($language_id, $lang_parm='language') {
    $code = '';
    if (isset($this->languagesCodes[$language_id])) {
      if (($this->languagesCodes[$language_id] != DEFAULT_LANGUAGE && sizeof($this->languagesCodes[$language_id]) > 1) || SITEMAPXML_USE_DEFAULT_LANGUAGE == 'true') {
        //$code = '&' . $lang_parm . '=' . $this->languagesCodes[$language_id];
      }
    }
    return $code;
  }

  function message($msg='', $type='') {
    if ($this->messageSilently != true) {
      echo $msg . "\n";
    }
  }

/////////////////////////

  function _checkFTimeSitemap($filename, $last_date=0) {
// TODO: Multifiles
//var_dump($filename);echo '<br />';
    if ($this->rebuild == true) return true;
    if ($last_date == 0) return true;
    clearstatcache();
    if ( SITEMAPXML_USE_EXISTING_FILES == 'true'
        && file_exists($this->savepath . $filename)
        && (filemtime($this->savepath . $filename) >= strtotime($last_date))
        && filesize($this->savepath . $filename) > 0) {
      $this->message('"' . $filename . '" ' . TEXT_FILE_NOT_CHANGED . '<br />');
      return false;
    }
    return true;
  }

  function _getNameFileXML($type) {
    if ($type == 'index') {
      $filename = $this->sitemapindex;
    } else {
      $compress = defined('SITEMAPXML_COMPRESS') ? SITEMAPXML_COMPRESS : 'true';
	  $filename = $this->filename . $type;
	  if($_GET['lang'])  $filename .= '_'.trim($_GET['lang']);
      $filename .= '.xml' . ($compress == 'true' ? '.gz' : '');


    }
    return $filename;
  }

// save the sitemap data to file as either .xml or .xml.gz format
  function _SaveFileXML($data, $type, $records=0, $skipped=0) {
    $ret = true;
    $filename = $this->_getNameFileXML($type);
//    $this->message('Output file: ' . $this->savepath . $filename . '<br />');
    if (substr($filename, -3) == '.gz') {
      if ($gz = gzopen($this->savepath . $filename,'wb9')) {
        gzwrite($gz, $data, strlen($data));
        gzclose($gz);
      } else {
        $ret = false;
      }
    } else {
      if ($fp = fopen($this->savepath . $filename, 'w+')) {
        fwrite($fp, $data, strlen($data));
        fclose($fp);
      } else {
        $ret = false;
      }
    }
    if (!$ret) {
      $this->message('<span style="font-weight: bold); color: red;"> ' . TEXT_FAILED_TO_OPEN . ' "' . $filename . '"!!!</span>' . '<br />');
      $this->submitFlag = false;
    } else {
      $this->message(TEXT_URL_FILE . '<a href="' . $this->base_url . $filename . '" target="_blank">' . $this->base_url . $filename . '</a>' . '<br />');
      $this->message(sprintf(TEXT_WRITTEN, $records, strlen($data), filesize($filename)) . '<br />');
    }
    return $ret;
  }

// format the LastMod field
  function _LastModFormat($date) {
    if (SITEMAPXML_LASTMOD_FORMAT == 'full') {
      $timezone = date('O', $date);
      return gmdate('Y-m-d\TH:i:s', $date) . substr($timezone, 0, 3) . ":" . substr($timezone, 3, 2);
    } else {
      return gmdate('Y-m-d', $date);
    }
  }

  function _SitemapXMLHeader($tag) {
    $header = '';
    $header .= '<?xml version="1.0" encoding="UTF-8"?'.'>' . "\n";
//    $header .= ($this->stylesheet != '' ? '<?xml-stylesheet type="text/xsl" href="gss.xsl"?'.'>' . "\n" : "");
    $header .= '<' . $tag . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n";
    $header .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"'. "\n";
    $header .= '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n";
    $header .= '        http://www.sitemaps.org/schemas/sitemap/0.9/' . ($tag == 'urlset' ? 'sitemap' : 'siteindex') . '.xsd"' . "\n";
    $header .= '        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
//    $header .= '<!-- generator="Zen-Cart SitemapXML" ' . SITEMAPXML_VERSION . ' -->' . "\n";
    return $header;
  }

  function _SitemapPing() {
    if ($this->submitFlag && SITEMAPXML_PING_URLS !== '') {
      $this->message('<h3>' . TEXT_HEAD_PING . '</h3>');
      $pingURLs = explode(";", SITEMAPXML_PING_URLS);
      foreach ($pingURLs as $pingURL) {
        $pingURLarray = explode("=>", $pingURL);
        if (!isset($pingURLarray[1])) $pingURLarray[1] = $pingURLarray[0];
        $pingURLarray[0] = trim($pingURLarray[0]);
        $pingURLarray[1] = trim($pingURLarray[1]);
        $pingFullURL = sprintf($pingURLarray[1], $this->submit_url);
        $this->message('<h4>' . TEXT_HEAD_PING . ' ' . $pingURLarray[0] . '</h4>');
        $this->message($pingFullURL);
        $this->message('<div style="background-color: #FFFFCC); border: 1px solid #000000; padding: 5px">');
        if ($info = $this->_curlExecute($pingFullURL, 'page')) {
          $this->message($this->_clearHTML($info['html_page']));
        }
        $this->message('</div>');
      }
    }
  }

  function _clearHTML($html) {
    $html = preg_replace('@<head>(.*)</'.'head>@si', '', $html);
    $html = preg_replace('@<script(.*)</'.'script>@si', '', $html);
    $html = preg_replace('@<title>(.*)</'.'title>@si', '', $html);
    $html = preg_replace('@<br\s*[/]*>|<p.*>|</p>@si', "\n", $html);
    $html = preg_replace("@\n\n+@", "\n", $html);
    $html = str_replace("&nbsp;", " ", $html);
    $html = preg_replace("@\s\s+@", " ", $html);
    $html = strip_tags($html);
    $html = trim($html);
    $html = nl2br($html);
    return $html;
  }

  function _outputSitemapIndex() {
    if ($this->submitFlag) {
      header('Last-Modified: ' . gmdate("r") . ' GMT');
      header("Content-Type: text/xml; charset=UTF-8");
      header("Content-Length: " . filesize($this->savepath . $this->sitemapindex));
      //    header("Content-disposition: inline; filename=" . $this->sitemapindex);
      echo file_get_contents($this->savepath . $this->sitemapindex);
    }
  }

  function _curlExecute($url, $read='page') {
    if (!function_exists('curl_init')) {
      $this->message(TEXT_ERROR_CURL_NOT_FOUND . '<br />', 'error');
      return false;
    }
    if (!$ch = curl_init()) {
      $this->message(TEXT_ERROR_CURL_INIT . '<br />', 'error');
      return false;
    }
    $url = str_replace('&amp;', '&', $url);
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($read == 'page') {
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_NOBODY, 0);
      @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    } else {
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_NOBODY, 1);
      @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

    if (CURL_PROXY_REQUIRED == 'True') {
      $proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
      curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
      curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
      curl_setopt($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
    }

    if (!$result = curl_exec($ch)) {
      $this->message(sprintf(TEXT_ERROR_CURL_EXEC, curl_error($ch), $url) . '<br />', 'error');
      return false;
    } else {
      $info = curl_getinfo($ch);
      curl_close($ch);
      if (empty($info['http_code'])) {
        $this->message(sprintf(TEXT_ERROR_CURL_NO_HTTPCODE, $url) . '<br />', 'error');
        return false;
      } elseif ($info['http_code'] != 200) {
//        $http_codes = @parse_ini_file('includes/http_responce_code.ini');
//        $this->message("cURL Error: Error http_code '<b>" . $info['http_code'] . " " . $http_codes[$info['http_code']] . "</b>' reading '" . $url . "'. " . '<br />', 'error');
        $this->message(sprintf(TEXT_ERROR_CURL_ERR_HTTPCODE, $info['http_code'], $url) . '<br />', 'error');
        return false;
      }
      if ($read == 'page') {
        if ($info['size_download'] == 0) {
          $this->message(sprintf(TEXT_ERROR_CURL_0_DOWNLOAD, $url) . '<br />', 'error');
          return false;
        }
        if (isset($info['download_content_length']) && $info['download_content_length'] > 0 && $info['download_content_length'] != $info['size_download']) {
          $this->message(sprintf(TEXT_ERROR_CURL_ERR_DOWNLOAD, $url, $info['size_download'], $info['download_content_length']) . '<br />', 'error');
          return false;
        }
        $info['html_page'] = $result;
      }
    }
    return $info;
  }

///////////////////////
  function _SitemapReSet() {
    $this->_SitemapReSetFile();
    $this->sitemapFileItemsTotal = 0;
    $this->sitemapFileSizeTotal = 0;
    $this->sitemapFileNameNumber = 0;
    $this->sitemapFileItemsMax = 0;
    return true;
  }

  function _SitemapReSetFile() {
    $this->sitemapFileBuffer = '';
    $this->sitemapFileItems = 0;
    $this->sitemapFileSize = 0;
    $this->sitemapFileNameNumber++;
    return true;
  }

  function _SitemapCloseFile() {
    if (!$this->_fileIsOpen()) return;
    if ($this->sitemapFileItems > 0) {
      $this->sitemapFileBuffer .= $this->sitemapFileFooter;
      $this->sitemapFileSizeTotal += strlen($this->sitemapFileBuffer);
      $this->_fileWrite($this->sitemapFileBuffer);
    }
    $this->_fileClose();
    $this->message(sprintf(TEXT_FILE_SITEMAP_INFO, $this->base_url . $this->sitemapFileName, $this->base_url . $this->sitemapFileName, $this->sitemapFileItems, $this->sitemapFileSize, filesize($this->sitemapFileName)) . '<br />');
  }

///////////////////////
  function _fileOpen($filename) {
    $this->fn = $filename;
    $this->fb = '';
    if (substr($this->fn, -3) == '.gz') {
      $this->fp = gzopen($this->savepath . $filename,'wb9');
    } else {
      $this->fp = fopen($this->savepath . $filename, 'w+');
    }
    if (!$this->fp) {
      $this->message('<span style="font-weight: bold); color: red;"> ' . TEXT_FAILED_TO_OPEN . ' "' . $filename . '"!!!</span>' . '<br />');
      $this->submitFlag = false;
    }
    return $this->fp;
  }

  function _fileIsOpen() {
    if (is_null($this->fp)) return false;
    return true;
  }

  function _fileWrite($data='') {
    $ret = true;
    if (strlen($this->fb) > $this->fb_maxsize || ($data == '' && strlen($this->fb) > 0)) {
      if (substr($this->fn, -3) == '.gz') {
        $ret = gzwrite($this->fp, $this->fb, strlen($this->fb));
      } else {
        $ret = fwrite($this->fp, $this->fb, strlen($this->fb));
      }
      $this->fb = '';
    }
    $this->fb .= $data;
    return $ret;
  }

  function _fileClose() {
    if (!$this->fp) return;
    if (strlen($this->fb) > 0) {
      $this->_fileWrite();
    }
    if (substr($this->fn, -3) == '.gz') {
      gzclose($this->fp);
    } else {
      fclose($this->fp);
    }
    $this->fp = null;
  }

  function timefmt($s) {
    $m = floor($s/60);
    $s = $s - $m*60;
    return $m . ":" . number_format($s, 4);
  }

  function searchDir($path,&$data){
    if(is_dir($path)){
      $dp=dir($path);
      while($file=$dp->read()){
        if($file!='.'&& $file!='..'){
          searchDir($path.'/'.$file,$data);
        }
      }
      $dp->close();
    }
    if(is_file($path)){
      $data[]=$path;
    }
  }

  function getDir($dir){
    $data=array();
    searchDir($dir,$data);
    return   $data;
  }

  function build_pdf_sitemap($language="")
  {
    global $db, $languages_id;
	if($_SESSION['languages_code']=='en'){
		$file= getDirPdf('file');
		$last_date = date('Y-m-d', time());
		if ($this->SitemapOpen('pdf', $last_date)) {
		  foreach ($file as $v) {
			$link = HTTPS_IMAGE_SERVER.$v;
			$this->SitemapWriteItem($link, time(), SITEMAPXML_CATEGORIES_CHANGEFREQ);
		  }
		}
		echo 'finished pdf sitemap  <br/>';
		$this->SitemapClose();
	}
  }

  function build_product_catalogs_sitemap($language=""){
    global $db, $languages_id;
    // $special_list_colums = array('id','banner_path','title','description','link');
    // $special_list_data = fs_get_data_from_db_fields_array($special_list_colums,'fs_special_list_manager','is_show=1 and list_type=2 and language_id='.$_SESSION['languages_id'],'order by sort');

    $sql = 'select R.id,A.link
    from fs_article_category_block_relation R
    left join fs_article_category_block_relation_descriptions D on D.relation_id =R.id and  D.language_id='.$_SESSION['languages_id'].'
    left join fs_articles A on R.article_id =A.id
    where R.block_id=5 and D.status=1 order by R.sort asc';
    $special_list_data = $db->getAll($sql);

    $last_date = date('Y-m-d', time());
    if ($this->SitemapOpen('product_catalogs', $last_date)) {
      foreach ($special_list_data as $k => $v) {
        // $link = "https://www.fs.com/".$v[4];
        $link = 'http://www.fs.com/catalog/'.$v['link'].'-'.$v['id'].'.html';
        $this->SitemapWriteItem($link, time(), SITEMAPXML_CATEGORIES_CHANGEFREQ);
      }
    }
    echo 'product catalogs sitemap  <br/>';
    $this->SitemapClose();
  }

  function build_support_sitemap($language=""){
    global $db, $languages_id;
    $support_categories=$db->getAll("select a.doc_categories_id,ad.doc_categories_name from support_categories as a left join support_categories_description as ad  using(doc_categories_id) where ad.language_id = 1 order by doc_sort_order asc");
    $doc_support_articles="";

//获取所有ID
    foreach ($support_categories as $k=>$v){
      $doc_support_articles_ids[]=$db->getAll("select doc_article_id from support_articles_category where doc_categories_id='".$v['doc_categories_id']."'");
    }
    $dco_support_info="";
    $data="";

//所有文章相关信息
    foreach ($doc_support_articles_ids as $k=>$v){
      foreach ($v as $key=>$value){
        $data[$k].=$value['doc_article_id'].",";
      }
      $data[$k]= substr($data[$k], 0, -1);
      $dco_support_info[$k]=$db->getAll("select a.support_articles_image,a.support_articles_id,ad.support_articles_intro,ad.support_articles_title,ad.support_articles_description from support_articles as a left join support_articles_description as ad using(support_articles_id) where support_articles_id in ($data[$k]) and a.support_articles_status = 1 and ad.language_id = 1 order by a.support_articles_sort_order");
    }
    foreach ($dco_support_info as $key => $value){
      foreach ($value as $k=>$v){
        $link[] = zen_href_link('support_detail','&supportid='.$v['support_articles_id']);
      }
    }

    // $special_list_colums = array('id','banner_path','title','description','link');
    // $special_list_data = fs_get_data_from_db_fields_array($special_list_colums,'fs_special_list_manager','is_show=1 and language_id= 1 and list_type=1 order by sort asc','');

    $sql = 'select P.id,P.link from fs_articles P LEFT join fs_article_descriptions D 
           on D.article_id = P.id WHERE D.language_id='.$_SESSION['languages_id'];
    $special_list_data = $db->Execute($sql);

    $last_date = date('Y-m-d', time());
    $site_code = '';
    if(in_array($_GET['lang'],['au','uk','sg','es','mx','fr','de','de-en','ru','jp'])){
      $site_code = $_GET['lang'].'/';
    }
    if ($this->SitemapOpen('support', $last_date)) {
      while(!$special_list_data->EOF) {
        $links = HTTPS_SERVER.'/'.$site_code.'specials/'.$special_list_data->fields['link'].'-'.$special_list_data->fields['id'].'.html';

        $this->SitemapWriteItem($links, time(), SITEMAPXML_CATEGORIES_CHANGEFREQ);
        $special_list_data->MoveNext();
      }
    }

    echo 'support sitemap  <br/>';
    $this->SitemapClose();
  }
  /**
   * @todo build fiberstore categories sitemap
   */
  function build_categories_sitemap($language=""){
    global $db,$languages_id;

    echo 'set header message of categories sitemap  <br/>';
    $this->message('<h3>' . 'Categories Sitemap' . '</h3>');

    echo 'set filename  of categories sitemap  <br/>';
    /*$last_date = $db->Execute("SELECT MAX(GREATEST(c.date_added, IFNULL(c.last_modified, 0))) AS last_date
	                           FROM " . TABLE_CATEGORIES . " c left join ".TABLE_CATEGORIES_DESCRIPTION." as cd ON(c.categories_id = cd.categories_id and cd.language_id = ".(int)$languages_id.")  
	                           WHERE c.categories_status = '1'");*/
    $last_date = 0;

    $categories = empty($language) ? 'categories' : 'categories_'.$language;

    if($language == 'es'){
      $languages_id = 2;
    }

    $categories_priority = array(6,177,178,179,180,1017,1031,1020,1022,1311,1023,1310,835,836,837,918,57,80,87,89,93,94,
        95,734,96,99,98,56,62,65,66,64,68,69,70,650,71,74,73,1113,1115,
        1215,1117,1217,1218,1220,58,110,115,116,707,702,1037,1038,1044,
        1045,1046,1048,1049,1182,1183,1184,1185,1187,1190,628,1269,1108,
        1109,1110,915,939,1111,608,578,615,209,897,763,220,261,278,306,
        1313,898,901,956,955,899,1135,975,1081,1075,384,17,1068,16,13,
        1000,1102,1004,18,33,35,34,53,55,44,23,43
    );

    if ($this->SitemapOpen($categories, $last_date)) {

      echo 'get data of categories sitemap  <br/>';

      $categories = $db->Execute("SELECT c.categories_id, GREATEST(c.date_added, IFNULL(c.last_modified, '0001-01-01 00:00:00')) AS last_date, c.sort_order AS priority, cd.language_id
			                              FROM " . TABLE_CATEGORIES . " c
			                                LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON (cd.categories_id = c.categories_id and cd.language_id = ".(int)$languages_id.")"  . "
			                              WHERE c.categories_status = '1'"  .
          (SITEMAPXML_CATEGORIES_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_CATEGORIES_ORDERBY : ''));
      $this->SitemapSetMaxItems($categories->RecordCount());
      while(!$categories->EOF) {
        $categories_name = $db->getAll("select categories_url_name from ".TABLE_CATEGORIES_DESCRIPTION." where categories_id = ".(int)$categories->fields['categories_id']."");
        if(!empty($categories_name[0]['categories_url_name'])){
          if (SKIP_SINGLE_PRODUCT_CATEGORIES=='True') {
            $products = $db->Execute("SELECT COUNT(*) AS total
			                                FROM " . TABLE_PRODUCTS . " p
			                                  LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c ON (p.products_id = p2c.products_id)
			                                WHERE p.products_status = '1'
			                                  AND p2c.categories_id = '" . (int)$categories->fields['categories_id'] . "'");
          } else {
            $products->fields['total'] = 2;
          }
          if ($products->fields['total'] != 1) {
            $link = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $categories->fields['categories_id'] , 'SSL', false);
            echo 'add link '.$categories->fields['categories_id'].' of categories sitemap  <br/>';
            if($language == 'es'){
              $link = $this->get_language_url($language,$link);
            }
            $priority = '';
            if(in_array($categories->fields['categories_id'],$categories_priority)){
              $priority = 0.9;
            }else{
              $priority = 0.8;
            }
            $this->SitemapWriteItem($link, time(), SITEMAPXML_CATEGORIES_CHANGEFREQ,$priority);
          }
        }
        $categories->MoveNext();
      }

      echo 'finished categories sitemap  <br/>';
      $this->SitemapClose();
    }

    echo 'generate categories sitemap successfully ... <br/>';
  }
  public function get_language_url($language,$link){

    if($link){
      $url_arr = explode('/',$link);

      foreach($url_arr as $key=>$value){
        if($url_arr[2] == 'localhost'){
          if($key == 3){
            $url_arr[$key] = $value.'/'.$language;
          }
        }else{
          if($key == 2){
            $url_arr[$key] = $value.'/'.$language;
          }
        }
      }
      return implode('/',$url_arr);
    }
  }

  /**
   * build products sitemap
   */
  function build_products_sitemap($language=""){
    global $db,$languages_id;
    $products = empty($language) ? 'products' : 'products_'.$language;
    unlink('sitemap_of_products000.xml.gz');
    //设置产品优先级
    $products_query_raw =
        "select sum(op.products_quantity) as products_ordered, op.products_id
      from ".TABLE_ORDERS_PRODUCTS." op
      left join orders o ON(op.orders_id = o.orders_id)
      where o.language_id = '" . $_SESSION['languages_id']. "'
      AND (o.orders_status = 2 OR o.orders_status = 3 OR o.orders_status = 4) 
      order by products_ordered DESC limit 2600";
    $products_sql = $db->Execute($products_query_raw);
    $products_id = array();
    while (!$products_sql->EOF) {
      $products_id [] = $products_sql->fields['products_id'];
      $products_sql->MoveNext();
    }
    $this->message('<h3>' . TEXT_HEAD_PRODUCTS . '</h3>');

    $last_date = $db->Execute("SELECT MAX(GREATEST(p.products_date_added, IFNULL(p.products_last_modified, 0))) AS last_date
                           FROM " . TABLE_PRODUCTS . " p
                           WHERE p.products_status = '1'");
    if ($this->SitemapOpen($products, $last_date->fields['last_date'])) {
      $products = $db->Execute("SELECT p.products_id, GREATEST(p.products_date_added, IFNULL(p.products_last_modified, '0001-01-01 00:00:00')) AS last_date, p.products_sort_order AS priority FROM " . TABLE_PRODUCTS . " as p WHERE p.products_status = '1' and p.show_type='0'"  . (SITEMAPXML_PRODUCTS_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_PRODUCTS_ORDERBY : ''));
      $this->SitemapSetMaxItems($products->RecordCount());
      while(!$products->EOF) {
        $link = zen_href_link(zen_get_info_page($products->fields['products_id']), 'products_id=' . $products->fields['products_id'] , 'SSL', false);
        if($language == 'es'){
          $link = $this->get_language_url($language,$link);
        }
        $priority ='';
        if(in_array($products->fields['products_id'],$products_id)){
          $priority = 0.7;
        }else{
          $priority = 0.6;
        }
//        $picture_microdata = get_product_picture_microdata($products->fields['products_id']);
        $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
        $products->MoveNext();
      }
      $this->SitemapClose();
    }
  }

  function build_reviews_sitemap($language=""){

    global $db,$languages_id;

    $solution_article = empty($language) ? 'all_review' : 'all_review_'.$language;

    $this->message('<h3>all_review</h3>');

    $last_date = $db->Execute("SELECT MAX(GREATEST(date_added, IFNULL(date_added, 0))) AS last_date FROM reviews ");

    if($this->SitemapOpen($solution_article, $last_date->fields['last_date'])){

      $sulution = $db->Execute("SELECT r.reviews_id,r.products_id 
	 		                          FROM reviews as r left join " . TABLE_PRODUCTS . " as p on(r.products_id = p.products_id)
	 		                          WHERE p.products_status = 1
	 		                         ");

      $this->SitemapSetMaxItems($sulution->RecordCount());
      while(!$sulution->EOF) {
        $link = zen_href_link('all_review', 'pr_id=' . $sulution->fields['products_id'] , 'SSL', false);
        $priority = 0.4;
        if($link){
          $this->SitemapWriteItem($link, time(), 'weekly',$priority);
        }
        $sulution->MoveNext();
      }
      $this->SitemapClose();

    }
  }

  /* add products list and article sitemap */
  function build_popular_list_sitemap($language=""){

    global $db,$languages_id;
	if($_SESSION['languages_code']=='en'){
		$solution_article = empty($language) ? 'popular list' : 'popular list_'.$language;

		$this->message('<h3>popular list</h3>');

		$last_date = $db->Execute("SELECT MAX(GREATEST(products_date_added, IFNULL(products_date_added, 0))) AS last_date FROM products ");

		if($this->SitemapOpen($solution_article, $last_date->fields['last_date'])){

		  $sulution = $db->Execute("SELECT tag_id,tag_name FROM products_tag_type ");

		  $this->SitemapSetMaxItems($sulution->RecordCount());
		  while(!$sulution->EOF) {
			$link = zen_href_link('Product_List','&tag_type='.$sulution->fields['tag_id'], 'SSL', false);
			$priority = 0.4;
			if($link){
			  $this->SitemapWriteItem($link, time(), 'weekly',$priority);
			}
			$sulution->MoveNext();
		  }
		  $this->SitemapClose();
		  $this->SitemapClose();
		}
	}
  }

  function build_popular_keyword_sitemap($language=""){

    global $db,$languages_id;
	if($_SESSION['languages_codes']=='en'){
		$solution_article = empty($language) ? 'popular keyword' : 'popular keyword'.$language;

		$this->message('<h3>popular keyword</h3>');

		$last_date = $db->Execute("SELECT MAX(GREATEST(products_date_added, IFNULL(products_date_added, 0))) AS last_date FROM products ");

		if($this->SitemapOpen($solution_article, $last_date->fields['last_date'])){

		  $sulution = $db->Execute("SELECT products_tag,tag_keywords FROM products_tags ");

		  $this->SitemapSetMaxItems($sulution->RecordCount());
		  while(!$sulution->EOF) {
			$link = zen_href_link('Popular_detail','&Popular_id='.$sulution->fields['products_tag'], 'SSL', false);
			$priority = 0.4;
			if($link){
			  $this->SitemapWriteItem($link, time(), 'weekly',$priority);
			}
			$sulution->MoveNext();
		  }
		  $this->SitemapClose();
		  $this->SitemapClose();
		}
	}
  }

  /* end of tags */

  function build_articlepage_sitemap($language=""){

    global $db,$languages_id;

    $solution_article = empty($language) ? 'fiberstore article' : 'fiberstore article';

    $this->message('<h3>fiberstore article</h3>');

    $last_date = date('Y-m-d',time());

    if($this->SitemapOpen($solution_article, $last_date)){
      $this->SitemapSetMaxItems(26);
      $article = array('contact_us','partner','site_map','live_chat_service','clearance','shipping_delivery','sample_application','inquiry_out');
      for($i = 0,$n=sizeof($article); $i< $n;$i++){
        $href = map_href_link($article[$i],'','SSL',false);
        $priority = 0.5;
        if($href){
          $this->SitemapWriteItem($href, time(), 'weekly',$priority);
        }
      }
	  //获取后台对应语种的所有单页面文章
	  $site_code = strtolower($_SESSION['languages_code'] ? $_SESSION['languages_code'] : 'en');
	  $language_id = fs_get_data_from_db_fields('languages_id',TABLE_LANGUAGES,"code = '".$site_code."'",'limit 1');
	  $single_res = $db->getAll("SELECT page_link FROM `fs_single_pages_description` where type=1 and status=1 and language_id=".$language_id);
	  if(sizeof($single_res)){
		foreach($single_res as $single){
			$single_href = zen_href_link('fs_single_pages','name='.$single['page_link'],'SSL');
			$priority = 0.5;
			if($single_href){
				$this->SitemapWriteItem($single_href, time(), 'weekly',$priority);
			}
		}  
	  }
      $this->SitemapClose();
    }
  }
  /**
   * build solution_article sitemap
   */
  function build_solution_article_sitemap($language=""){

    global $db,$languages_id;

    $solution_article = empty($language) ? 'products_article' : 'products_article_'.$language;

    if($language == 'es'){
      $languages_id = 2;
    }

    $this->message('<h3>products_article</h3>');

    //$last_date = date('Y-m-d H:i:s',time());
    $last_date = $db->Execute("SELECT MAX(GREATEST(p.doc_article_last_modified, IFNULL(p.doc_article_last_modified, 0))) AS last_date FROM ".TABLE_SOLUTION_ARTICLE." p where language_id = '$languages_id'");

    if($this->SitemapOpen($solution_article, $last_date->fields['last_date'])){

      $sql="select a.doc_article_id
from " . TABLE_SOLUTION_ARTICLE . " as a left join " . TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as  ad on(a.doc_article_id = ad.doc_article_id)
where  ad.language_id = ".$_SESSION['languages_id']." and a.doc_article_status =1 ";
      $sulution = $db->Execute($sql);

      $this->SitemapSetMaxItems($sulution->RecordCount());
      while(!$sulution->EOF) {
        //zen_href_link('products_detail','s_id='.$_GET['s_id'])
        $link = zen_href_link('products_detail', 's_id=' . $sulution->fields['doc_article_id'], 'SSL', false);
        $priority = 0.6;
        if($language == 'es'){
          $link = $this->get_language_url($language,$link);
        }
        if($link){
          $this->SitemapWriteItem($link, time(), 'weekly',$priority);
        }
        $sulution->MoveNext();
      }
      $this->SitemapClose();

    }
  }
  /**
   * bulid solution narrow_by sitemap
   */
  function create_other_narrow_by_sitemap($parent_id,$cancel_cid){
    global $db;

    $narrow_categories = array(897,1017,1217,1117,1115,1215,23,1004,1129,1128,628,1081,1075,384,1155,13,1003,1070,1098,1000,
        34,1100,51,48,50,52,43,44,45,22,837,1312,1311);

    if(empty($language)){
      require(DIR_WS_CLASSES . 'products_narrow_by.php');
    }
    $this->message('<h3>narrow_by</h3>');
    $last_date = date('Y-m-d H:i:s',time());

    $narrow_by = empty($language) ? 'narrow_by' : 'narrow_by_'.$language;

    if($this->SitemapOpen($narrow_by, $last_date)){


      global $db;
      $sql = "select a.categories_id from ".TABLE_CATEGORIES." as a,products_narrow_by_options_to_categories as b 
	 		        where a.categories_id = b.categories_id and a.categories_id in(".join(',',$narrow_categories).")";
      $categories = $db->getAll($sql);

      $cate_id_arr = array();
      foreach($categories as $key=>$q){
        $cate_id_arr[] = $q['categories_id'];
      }
      $cate_id_arr = array_unique($cate_id_arr);
      foreach($cate_id_arr as $v){

        $cID_array = array();

        $current_category_id = $cID = $v;
        //$current_category_id = $cID = 61;

        $sql = "SELECT products_narrow_by_options_id as oID FROM ".TABLE_PRODUCTS_NARROW_BY_OPTIONS_TO_CATEGORIES." AS nyc   
					JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTIONS . " AS nyo
					USING (products_narrow_by_options_id) 
					WHERE nyc.categories_id =  :categories_id 
					ORDER BY products_narrow_by_options_sort_order ";
        $result = $db->Execute($db->bindVars($sql,':categories_id',$cID,'integer'));
        if ($result->RecordCount()){
          while (!$result->EOF){
            $cID_array[] = $result->fields['oID'];
            $result->MoveNext();
          }
        }

        $options_values_arr = array();
        //var_dump($options_values_arr0);exit;
        foreach($cID_array as $key=>$oID){
          $products_narrow_by = new products_narrow_by();
          $narrow_by_options_values = $products_narrow_by->get_narrow_by_opions_values_by_oID($oID);
          sort($narrow_by_options_values,SORT_NUMERIC);
          $size = sizeof($narrow_by_options_values);
          if($size >0){
            foreach ($narrow_by_options_values as $ii => $vID){

              $is_current= $narrow_get_parmas_string = '';
              $page = FILENAME_NARROW;
              $except_values = array('cPath','narrow');

              //for new params list
              $new_narrow_by_array = array();
              $href =$name=$count_of_narrow_by_products= '';
              //loop narrows in $_GET to find current vID
              if (zen_not_null($narrow_by_params)) {
                if (in_array($vID,$narrow_by_params)) {
                  $is_current = 'class="xiand"';
                }
                $new_narrow_by_array = $products_narrow_by->get_narrow_by_values_not_in_the_same_option($vID,$narrow_by_params);
                if (!zen_not_null($new_narrow_by_array)) {
                  //if customer not choose narrow ,then go to category page
                  $page = FILENAME_DEFAULT;
                }
              }
              else {
                $new_narrow_by_array = array($vID);
              }
              //use zen_get_all_get_params to parse narrow to url
              $_GET['narrow']= $new_narrow_by_array;

              $name = $products_narrow_by->get_option_values_name($vID);

              // 						$count_of_narrow_by_products = $this->get_count_of_products($current_category_id, $vID);
              $href = zen_href_link($page,zen_get_all_get_params($except_values).'&cPath='.$current_category_id , 'SSL', false);
              if($href){
                if($language == 'es'){
                  $href = $this->get_language_url($language,$href);
                }
                $priority = 0.3;
                if($href){
                  $this->SitemapWriteItem($href, time(), 'weekly',$priority);
                  $options_values_arr[$key][$ii] = $href;
                }
              }
            }
          }
        }
        $info = array();
        if($options_values_arr){
          $options_values_arr_new = array();
          $options_values_arr = $this->array_unique_fb($options_values_arr);
          foreach($options_values_arr as $keys=>$gf){
            $options_values_arr_new[] = $gf;
          }
          $options_values_arr = $options_values_arr_new;
          $count = count($options_values_arr);
          foreach($options_values_arr as $key=>$v){
            if($count>=2){
              for($i=$count-1;$i>$key;$i--){
                foreach($options_values_arr[$key] as $n){
                  foreach($options_values_arr[$i] as $ns){
                    $rt = $ns."|||".$n;
                    $info[] = $this->get_url($rt);
                  }
                }
                if($count>=3){
                  for($j=$count-1;$j>$i;$j--){
                    foreach($options_values_arr[$key] as $n){
                      foreach($options_values_arr[$i] as $ns){
                        foreach($options_values_arr[$j] as $ns3){
                          $rt = $ns3."|||".$ns."|||".$n;
                          $info[] = $this->get_url($rt);
                        }
                      }
                    }
                  }
                }
              }

            }
          }
        }

        foreach($info as $j){
          if($language == 'es'){
            $j = $this->get_language_url($language,$j);
          }
          $priority = 0.3;
          $this->SitemapWriteItem($j, time(), 'weekly',$priority);
        }

      }
      $this->SitemapClose();
    }

  }

  function build_Narrow_by_sitemap($language=""){
    global $db;

    $narrow_categories = array(897,1017,1217,1117,1115,1215,23,1004,1129,1128,628,1081,1075,384,1155,13,1003,1070,1098,1000,
        34,1100,51,48,50,52,43,44,45,22,837,1312,1311);

    $narrow_priority = array(1017,837,1217,1117,1115,628,897,1000,1004,34);
    if(empty($language)){
      require(DIR_WS_CLASSES . 'products_narrow_by.php');
    }
    $this->message('<h3>narrow_by</h3>');
    $last_date = date('Y-m-d H:i:s',time());

    $narrow_by = empty($language) ? 'narrow_by' : 'narrow_by_'.$language;

    if($this->SitemapOpen($narrow_by, $last_date)){


      global $db;
      $sql = "select a.categories_id from ".TABLE_CATEGORIES." as a,products_narrow_by_options_to_categories as b 
	 		        where a.categories_id = b.categories_id and a.categories_id in(".join(',',$narrow_categories).")";
      $categories = $db->getAll($sql);

      $cate_id_arr = array();
      foreach($categories as $key=>$q){
        $cate_id_arr[] = $q['categories_id'];
      }
      $cate_id_arr = array_unique($cate_id_arr);
      foreach($cate_id_arr as $v){

        $cID_array = array();

        $current_category_id = $cID = $v;
        //$current_category_id = $cID = 61;

        $sql = "SELECT products_narrow_by_options_id as oID FROM ".TABLE_PRODUCTS_NARROW_BY_OPTIONS_TO_CATEGORIES." AS nyc   
					JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTIONS . " AS nyo
					USING (products_narrow_by_options_id) 
					WHERE nyc.categories_id =  :categories_id 
					ORDER BY products_narrow_by_options_sort_order ";
        $result = $db->Execute($db->bindVars($sql,':categories_id',$cID,'integer'));
        if ($result->RecordCount()){
          while (!$result->EOF){
            $cID_array[] = $result->fields['oID'];
            $result->MoveNext();
          }
        }

        $options_values_arr = array();
        //var_dump($options_values_arr0);exit;
        foreach($cID_array as $key=>$oID){
          $products_narrow_by = new products_narrow_by();
          $narrow_by_options_values = $products_narrow_by->get_narrow_by_opions_values_by_oID($oID);
          sort($narrow_by_options_values,SORT_NUMERIC);
          $size = sizeof($narrow_by_options_values);
          if($size >0){
            foreach ($narrow_by_options_values as $ii => $vID){

              $is_current= $narrow_get_parmas_string = '';
              $page = FILENAME_NARROW;
              $except_values = array('cPath','narrow');

              //for new params list
              $new_narrow_by_array = array();
              $href =$name=$count_of_narrow_by_products= '';
              //loop narrows in $_GET to find current vID
              if (zen_not_null($narrow_by_params)) {
                if (in_array($vID,$narrow_by_params)) {
                  $is_current = 'class="xiand"';
                }
                $new_narrow_by_array = $products_narrow_by->get_narrow_by_values_not_in_the_same_option($vID,$narrow_by_params);
                if (!zen_not_null($new_narrow_by_array)) {
                  //if customer not choose narrow ,then go to category page
                  $page = FILENAME_DEFAULT;
                }
              }
              else {
                $new_narrow_by_array = array($vID);
              }
              //use zen_get_all_get_params to parse narrow to url
              $_GET['narrow']= $new_narrow_by_array;

              $name = $products_narrow_by->get_option_values_name($vID);

              // 						$count_of_narrow_by_products = $this->get_count_of_products($current_category_id, $vID);
              $href = zen_href_link($page,zen_get_all_get_params($except_values).'&cPath='.$current_category_id , 'SSL', false);
              if($href){
                if($language == 'es'){
                  $href = $this->get_language_url($language,$href);
                }
                $priority = '';
                if(in_array($current_category_id,$narrow_priority)){
                  $priority = 0.9;
                }else{
                  $priority = 0.7;
                }
                if($href){
                  $this->SitemapWriteItem($href, time(), 'weekly',$priority);
                  $options_values_arr[$key][$ii] = $href;
                }
              }
            }
          }
        }
        $info = array();
        if($options_values_arr){
          $options_values_arr_new = array();
          $options_values_arr = $this->array_unique_fb($options_values_arr);
          foreach($options_values_arr as $keys=>$gf){
            $options_values_arr_new[] = $gf;
          }
          $options_values_arr = $options_values_arr_new;
          $count = count($options_values_arr);
          foreach($options_values_arr as $key=>$v){
            if($count>=2){
              for($i=$count-1;$i>$key;$i--){
                foreach($options_values_arr[$key] as $n){
                  foreach($options_values_arr[$i] as $ns){
                    $rt = $ns."|||".$n;
                    $info[] = $this->get_url($rt);
                  }
                }
                if($count>=3){
                  for($j=$count-1;$j>$i;$j--){
                    foreach($options_values_arr[$key] as $n){
                      foreach($options_values_arr[$i] as $ns){
                        foreach($options_values_arr[$j] as $ns3){
                          $rt = $ns3."|||".$ns."|||".$n;
                          $info[] = $this->get_url($rt);
                        }
                      }
                    }
                  }
                }
              }

            }
          }
        }

        foreach($info as $j){
          if($language == 'es'){
            $j = $this->get_language_url($language,$j);
          }
          $priority = '';
          if(in_array($current_category_id,$narrow_priority)){
            $priority = 0.9;
          }else{
            $priority = 0.7;
          }
          $this->SitemapWriteItem($j, time(), 'weekly',$priority);
        }

      }
      $this->SitemapClose();
    }
  }


  //other narrow url
  function build_other_Narrow_by_sitemap($language=""){
    global $db;
    // require(DIR_WS_CLASSES . 'products_narrow_by.php');
    $narrow_categories = array(897,1017,1217,1117,1115,1215,23,1004,1129,1128,628,1081,1075,384,1155,13,1003,1070,1098,1000,
        34,1100,51,48,50,52,43,44,45,22,837,1312,1311);

    $and_sql ='';
//        for($j=0;$j<sizeof($narrow_categories);$j++){
//         $and_sql .='and a.categories_id  != '.$narrow_categories[$j];
//        }

    $this->message('<h3>other narrow by</h3>');
    $last_date = date('Y-m-d H:i:s',time());

    $narrow_by = empty($language) ? 'other_narrow_by' : 'other_narrow_by_'.$language;

    if($this->SitemapOpen($narrow_by, $last_date)){


      global $db;
      $sql = "select a.categories_id from ".TABLE_CATEGORIES." as a,products_narrow_by_options_to_categories as b 
	 		        where a.categories_id = b.categories_id ";
      $categories = $db->getAll($sql);

      $cate_id_arr = array();
      foreach($categories as $key=>$q){
        $cate_id_arr[] = $q['categories_id'];
      }
      $cate_id_arr = array_unique($cate_id_arr);
      foreach($cate_id_arr as $v){

        $cID_array = array();

        $current_category_id = $cID = $v;
        //$current_category_id = $cID = 61;

        $sql = "SELECT products_narrow_by_options_id as oID FROM ".TABLE_PRODUCTS_NARROW_BY_OPTIONS_TO_CATEGORIES." AS nyc   
					JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTIONS . " AS nyo
					USING (products_narrow_by_options_id) 
					WHERE nyc.categories_id =  :categories_id 
					ORDER BY products_narrow_by_options_sort_order ";
        $result = $db->Execute($db->bindVars($sql,':categories_id',$cID,'integer'));
        if ($result->RecordCount()){
          while (!$result->EOF){
            $cID_array[] = $result->fields['oID'];
            $result->MoveNext();
          }
        }

        $options_values_arr = array();
        //var_dump($options_values_arr0);exit;
        foreach($cID_array as $key=>$oID){
          $products_narrow_by = new products_narrow_by();
          $narrow_by_options_values = $products_narrow_by->get_narrow_by_opions_values_by_oID($oID);
          sort($narrow_by_options_values,SORT_NUMERIC);
          $size = sizeof($narrow_by_options_values);
          if($size >0){
            foreach ($narrow_by_options_values as $ii => $vID){

              $is_current= $narrow_get_parmas_string = '';
              $page = FILENAME_NARROW;
              $except_values = array('cPath','narrow');

              //for new params list
              $new_narrow_by_array = array();
              $href =$name=$count_of_narrow_by_products= '';
              //loop narrows in $_GET to find current vID
              if (zen_not_null($narrow_by_params)) {
                if (in_array($vID,$narrow_by_params)) {
                  $is_current = 'class="xiand"';
                }
                $new_narrow_by_array = $products_narrow_by->get_narrow_by_values_not_in_the_same_option($vID,$narrow_by_params);
                if (!zen_not_null($new_narrow_by_array)) {
                  //if customer not choose narrow ,then go to category page
                  $page = FILENAME_DEFAULT;
                }
              }
              else {
                $new_narrow_by_array = array($vID);
              }
              //use zen_get_all_get_params to parse narrow to url
              $_GET['narrow']= $new_narrow_by_array;

              $name = $products_narrow_by->get_option_values_name($vID);

              // 						$count_of_narrow_by_products = $this->get_count_of_products($current_category_id, $vID);
              $href = zen_href_link($page,zen_get_all_get_params($except_values).'&cPath='.$current_category_id , 'SSL', false);
              if($href){
                if($language == 'es'){
                  $href = $this->get_language_url($language,$href);
                }
                $priority = 0.3;

                if($href){
                  $this->SitemapWriteItem($href, time(), 'weekly',$priority);
                  $options_values_arr[$key][$ii] = $href;
                }
              }
            }
          }
        }
        $info = array();
        if($options_values_arr){
          $options_values_arr_new = array();
          $options_values_arr = $this->array_unique_fb($options_values_arr);
          foreach($options_values_arr as $keys=>$gf){
            $options_values_arr_new[] = $gf;
          }
          $options_values_arr = $options_values_arr_new;
          $count = count($options_values_arr);
          foreach($options_values_arr as $key=>$v){
            if($count>=2){
              for($i=$count-1;$i>$key;$i--){
                foreach($options_values_arr[$key] as $n){
                  foreach($options_values_arr[$i] as $ns){
                    $rt = $ns."|||".$n;
                    $info[] = $this->get_url($rt);
                  }
                }
                if($count>=3){
                  for($j=$count-1;$j>$i;$j--){
                    foreach($options_values_arr[$key] as $n){
                      foreach($options_values_arr[$i] as $ns){
                        foreach($options_values_arr[$j] as $ns3){
                          $rt = $ns3."|||".$ns."|||".$n;
                          $info[] = $this->get_url($rt);
                        }
                      }
                    }
                  }
                }
              }

            }
          }
        }

        foreach($info as $j){
          if($language == 'es'){
            $j = $this->get_language_url($language,$j);
          }
          $priority = 0.3;
          $this->SitemapWriteItem($j, time(), 'weekly',$priority);
        }

      }
      $this->SitemapClose();
    }
  }

  //all narrow by url
  /*
  function build_Narrow_by_sitemap($language=""){

      global $db;
      if(empty($language)){
          require(DIR_WS_CLASSES . 'products_narrow_by.php');
      }
      $this->message('<h3>narrow_by</h3>');
      $last_date = date('Y-m-d H:i:s',time());

      $narrow_by = empty($language) ? 'narrow_by' : 'narrow_by_'.$language;

      if($this->SitemapOpen($narrow_by, $last_date)){


          global $db;
          $sql = "select a.categories_id from ".TABLE_CATEGORIES." as a,products_narrow_by_options_to_categories as b where a.categories_id = b.categories_id";
          $categories = $db->getAll($sql);

         $cate_id_arr = array();
         foreach($categories as $key=>$q){
             $cate_id_arr[] = $q['categories_id'];
         }
         $cate_id_arr = array_unique($cate_id_arr);
          foreach($cate_id_arr as $v){

         $cID_array = array();

         $current_category_id = $cID = $v;
         //$current_category_id = $cID = 61;

         $sql = "SELECT products_narrow_by_options_id as oID FROM ".TABLE_PRODUCTS_NARROW_BY_OPTIONS_TO_CATEGORIES." AS nyc
                 JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTIONS . " AS nyo
                 USING (products_narrow_by_options_id)
                 WHERE nyc.categories_id =  :categories_id
                 ORDER BY products_narrow_by_options_sort_order ";
         $result = $db->Execute($db->bindVars($sql,':categories_id',$cID,'integer'));
         if ($result->RecordCount()){
             while (!$result->EOF){
                 $cID_array[] = $result->fields['oID'];
                 $result->MoveNext();
             }
         }

         $options_values_arr = array();
         //var_dump($options_values_arr0);exit;
         foreach($cID_array as $key=>$oID){
             $products_narrow_by = new products_narrow_by();
             $narrow_by_options_values = $products_narrow_by->get_narrow_by_opions_values_by_oID($oID);
             sort($narrow_by_options_values,SORT_NUMERIC);
             $size = sizeof($narrow_by_options_values);
             if($size >0){
                 foreach ($narrow_by_options_values as $ii => $vID){

                     $is_current= $narrow_get_parmas_string = '';
                     $page = FILENAME_NARROW;
                     $except_values = array('cPath','narrow');

                     //for new params list
                     $new_narrow_by_array = array();
                     $href =$name=$count_of_narrow_by_products= '';
                     //loop narrows in $_GET to find current vID
                     if (zen_not_null($narrow_by_params)) {
                         if (in_array($vID,$narrow_by_params)) {
                             $is_current = 'class="xiand"';
                         }
                         $new_narrow_by_array = $products_narrow_by->get_narrow_by_values_not_in_the_same_option($vID,$narrow_by_params);
                         if (!zen_not_null($new_narrow_by_array)) {
                             //if customer not choose narrow ,then go to category page
                             $page = FILENAME_DEFAULT;
                         }
                     }
                     else {
                         $new_narrow_by_array = array($vID);
                     }
                     //use zen_get_all_get_params to parse narrow to url
                     $_GET['narrow']= $new_narrow_by_array;

                     $name = $products_narrow_by->get_option_values_name($vID);

                     // 						$count_of_narrow_by_products = $this->get_count_of_products($current_category_id, $vID);
                     $href = zen_href_link($page,zen_get_all_get_params($except_values).'&cPath='.$current_category_id);
                     if($href){
                         if($language == 'es'){
                             $href = $this->get_language_url($language,$href);
                         }
                         if($href){
                             $this->SitemapWriteItem($href, time(), 'weekly');
                             $options_values_arr[$key][$ii] = $href;
                         }
                     }

                 }
             }
         }
          $info = array();
          if($options_values_arr){
              $options_values_arr_new = array();
              $options_values_arr = $this->array_unique_fb($options_values_arr);
              foreach($options_values_arr as $keys=>$gf){
                  $options_values_arr_new[] = $gf;
              }
              $options_values_arr = $options_values_arr_new;
              $count = count($options_values_arr);
              foreach($options_values_arr as $key=>$v){
                  if($count>=2){
                      for($i=$count-1;$i>$key;$i--){
                          foreach($options_values_arr[$key] as $n){
                              foreach($options_values_arr[$i] as $ns){
                                  $rt = $ns."|||".$n;
                                  $info[] = $this->get_url($rt);
                              }
                          }
                          if($count>=3){
                              for($j=$count-1;$j>$i;$j--){
                                  foreach($options_values_arr[$key] as $n){
                                      foreach($options_values_arr[$i] as $ns){
                                          foreach($options_values_arr[$j] as $ns3){
                                              $rt = $ns3."|||".$ns."|||".$n;
                                              $info[] = $this->get_url($rt);
                                          }
                                      }
                                  }
                              }
                          }
                      }

                  }
              }
          }

          foreach($info as $j){
              if($language == 'es'){
                  $j = $this->get_language_url($language,$j);
              }
              $this->SitemapWriteItem($j, time(), 'weekly');
          }

        }
        $this->SitemapClose();
      }
  }
  */

  function get_url($rt){
    if($rt){
      $rt_arr = explode('|||',$rt);
      $url = '';
      foreach($rt_arr as $key=>$v){
        $rt_arr[$key] = str_replace('t0','t'.$key,$v);
      }
      foreach($rt_arr as $key=>$v){
        $urc = explode('/',$v);
        if($key == 0){
          foreach($urc as $keys=>$rt){
            if($rt == 'narrow'){
              $count = $keys;break;
            }

          }
        }
        $url.= $urc[$count+1]."/";
      }
      $href = "";
      $act = explode('/',$rt_arr[0]);
      foreach($act as $key=>$v){
        $href .= $v."/";
        if($v == 'narrow'){
          break;
        }

      }
      $href = $href.$url.$act[count($act)-1];
      return $href;
    }
  }
  function array_unique_fb($array2D){
    foreach ($array2D as $v)
    {
      $v = join(",",$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
      $temp[] = $v;
    }
    $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组

    foreach ($temp as $k => $v)
    {
      $temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
    }
    return $temp;
  }

  function build_tutorial_sitemap(){
    global $db,$languages_id;

    $this->message('<h3>Resources Sitemap</h3>');

    $last_date = date('Y-m-d',time());
    if ($this->SitemapOpen('resources', $last_date)) {
      $where = '';
      $doc_categories_id = [];
      //不展示ideas页面下的tag图文章数据
      $doc_categories = $db->Execute('SELECT doc_categories_id FROM doc_categories_description WHERE categories_code = "ideas" ');
      while(!$doc_categories->EOF){
        $doc_categories_id[] = $doc_categories->fields['doc_categories_id'];
        $doc_categories->MoveNext();
      }
      if(!empty($doc_categories_id)){
        $where = ' and ac.doc_categories_id NOT IN ('.join(',', $doc_categories_id).') ';
      }
      $articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id) 
	LEFT JOIN doc_article_category AS ac USING(doc_article_id)
	where doc_des_status = 1 ".$where."
	and ad.language_id = '" . $_SESSION['languages_id'] . "' order by doc_article_last_modified DESC";
      $results = $db->Execute($articles_query);
      //1.add tutorial home page
      $priority = '0.6';
      while(!$results->EOF) {
        $link = zen_href_link('tutorial_detail','&a_id='.$results->fields['doc_article_id'],'NONSSL');
        $this->SitemapWriteItem($link, time(), '',$priority);
        $results->MoveNext();
      }
      $this->SitemapClose();
    }
  }

  //categories search tag
  function build_categories_tag_sitemap(){
    global $db,$languages_id;

    $this->message('<h3>categories tag Sitemap</h3>');
    $priority ='0.6';
    $last_date = date('Y-m-d',time());
    if ($this->SitemapOpen('categories tag', $last_date)) {

      //1.add home page
      $priority = '0.6';
      $this->SitemapWriteItem(zen_href_link('tag_categories'), time(), '',$priority , 'SSL', false);
      //2.add categories
      $results = $db->Execute("select tag_categories_id,tag_name from meta_tags_of_search_categories ");
      $this->SitemapSetMaxItems($results->RecordCount());
      while(!$results->EOF) {
        $link = zen_href_link('tag_categories','tag='.$results->fields['tag_categories_id'], 'SSL', false);
        $this->SitemapWriteItem($link, time(), '',$priority);
        $results->MoveNext();
      }

      //3.add tutorial articles
      /* $connectors = $db->Execute("SELECT id FROM `connectors` ");
// 	 		$this->SitemapSetMaxItems($results->RecordCount());
      while(!$connectors->EOF) {
        $link = zen_href_link(FILENAME_FIBER_CATEGORIES,'con='.$connectors->fields['id'], 'SSL', false);
        $this->SitemapWriteItem($link, time(), '',$priority);
        $connectors->MoveNext();
      } */

      $this->SitemapClose();
    }
  }

  /**
   * build news sitemap
   */
  function build_news_sitemap(){
    global $db,$languages_id;
	if($_SESSION['languages_code']=='en'){
		//只有英文站才有news
		$this->message('<h3>News Sitemap</h3>');
		$priority ='0.6';
		$last_date = date('Y-m-d',time());
		if ($this->SitemapOpen('news', $last_date)) {

		  //2.add news articles
		  $results = $db->Execute("
					SELECT n.article_id as id FROM news_articles AS n LEFT JOIN  news_articles_text AS na 
	ON (n.news_status = 1 AND n.article_id = na.article_id  AND na.language_id=".(int)$languages_id.") 
	WHERE LENGTH(na.news_article_name) > 5 	 				
	ORDER BY n.article_id DESC");
	// 	 		$this->SitemapSetMaxItems($results->RecordCount());
		  while(!$results->EOF) {
			$link = zen_href_link(FILENAME_NEWS_ARTICLE, 'article_id=' . $results->fields['id'] , 'SSL', false);
			$this->SitemapWriteItem($link, time(), '',$priority);
			$results->MoveNext();
		  }

		  $this->SitemapClose();
		}
	}
  }

  /**
   * 循环获取分页的方法
   */
  function zen_get_page_total($total,$arry){
    global $db;
    $per_page = 36;
    //echo $products_count/$per_page."<br>";
    if($total/$per_page >= 1) {
      if($total % $per_page == 0){
        $pages = (int)($total/$per_page);
        for($page=1;$page <= $pages;$page++){
          if($page == 1) {
            $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry);
            $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers");
            $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate");
            $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price");
            $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new");
            //echo $link2."<br>";
          }else{
            $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/".$page.".html");
            $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers/".$page.".html");
            $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate/".$page.".html");
            $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price/".$page.".html");
            $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new/".$page.".html");
          }
          //echo $link2."<br>";
          $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link1, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link2, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link3, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link4, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);

        }
      }else{
        $pages = (int)($total/$per_page)+1;
        for($page=1;$page <= $pages;$page++){
          if($page == 1) $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry);
          else
            $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/".$page.".html");
          $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers/".$page.".html");
          $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate/".$page.".html");
          $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price/".$page.".html");
          $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new/".$page.".html");
          //echo $link."<br>";
          $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link1, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link2, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link3, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link4, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
        }
      }
    }else {
      $pages = (int)($total/$per_page)+1;
      $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry);
      $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers");
      $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate");
      $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price");
      $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new");
      //echo $link."<br>";
      $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link1, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link2, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link3, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link4, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
    }
  }

  function zen_get_page_rows($arry){
    global $db;
    $sql = "select count(p.products_id) as total from " .TABLE_PRODUCTS . " as p LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
						ON p.products_id  = ptc.products_id where ptc.categories_id = ".(int)$arry."    ";
    $get_products_count = $db->Execute($sql);
    $products_count = (int)$get_products_count->fields['total'];

    $per_page = 36;
    //echo $products_count/$per_page."<br>";
    if($products_count/$per_page >= 1) {
      if($products_count % $per_page == 0){
        $pages = (int)($products_count/$per_page);
        for($page=1;$page <= $pages;$page++){
          //echo "分类页数为".$page."<br>";
          $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/".$page.".html");
          $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers/".$page.".html");
          $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate/".$page.".html");
          $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price/".$page.".html");
          $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new/".$page.".html");
          //echo "目录下产品个数".$products_count."     ";
          //echo $link."<br>";
          $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link1, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link2, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link3, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link4, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
        }
      }else{
        $pages = (int)($products_count/$per_page)+1;
        for($page=1;$page <= $pages;$page++){
          //echo "分类页数为".$page;
          $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/".$page.".html");
          $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers/".$page.".html");
          $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate/".$page.".html");
          $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price/".$page.".html");
          $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new/".$page.".html");
          //echo $sql;
          //echo "目录下产品个数".$products_count."     ";
          echo $link4."<br>";
          $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link1, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link2, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link3, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
          $this->SitemapWriteItem($link4, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ);
        }
      }
    }else {
      $pages = (int)($products_count/$per_page)+1;
      //echo "分类页数为".$page;
      $link = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry);
      $link1 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_sellers");
      $link2 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_rate");
      $link3 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_price");
      $link4 = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arry."/sort-order_new");
      //echo $link."<br>";
      $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link1, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link2, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link3, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
      $this->SitemapWriteItem($link4, time(), SITEMAPXML_PRODUCTS_CHANGEFREQ,$priority);
    }

  }

  /**
   * build categories page link sitemap
   */
  function build_categories_page_link_sitemap(){
    global $db,$language_id;
    $arr = array();
    echo '<h3>' . TEXT_HEAD_EZPAGES . '</h3>';

    $last_date = $db->Execute("SELECT MAX(GREATEST(c.date_added, IFNULL(c.last_modified, 0))) AS last_date
	                FROM " . TABLE_CATEGORIES . " c left join ".TABLE_CATEGORIES_DESCRIPTION." as cd ON(c.categories_id = cd.categories_id and cd.language_id = ".(int)$languages_id.")
	                WHERE c.categories_status = '1'");
    if ($this->SitemapOpen('page_link', $last_date->fields['last_date'])) {
      $sql = "SELECT DISTINCT c.categories_id, GREATEST(c.date_added, IFNULL(c.last_modified, '0001-01-01 00:00:00')) AS last_date, c.sort_order AS priority, cd.language_id
		             FROM " . TABLE_CATEGORIES . " c
		             LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON (cd.categories_id = c.categories_id and cd.language_id = ".(int)$languages_id.")"  . "
		             WHERE c.categories_status = '1'"  .
          (SITEMAPXML_CATEGORIES_ORDERBY != '' ? "ORDER BY " . SITEMAPXML_CATEGORIES_ORDERBY : '') ;
      $categories = $db->Execute($sql);
      $this->SitemapSetMaxItems($categories->RecordCount());

      //根据产品种类名parent_id 循环得到产品
      $cat_id = $db->Execute("SELECT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id = 0");
      while (!$cat_id->EOF) {
        $arr []= $cat_id->fields['id'];
        $cat_id->MoveNext();
      }
      for($i=0;$i<sizeof($arr);$i++){
        //一级目录ID
        //echo $arr[$i]."<br>";
        $cat_id1 = $db->Execute("SELECT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id = ".(int)$arr[$i]." ");
        while (!$cat_id1->EOF) {
          $arr1 []= $cat_id1->fields['id'];
          $cat_id1->MoveNext();
        }
      }

      for($j=0;$j<sizeof($arr1);$j++){
        //二级目录ID
        //echo "二级目录".$arr1[$j]."<br>";
        $cat_id2 = $db->Execute("SELECT DISTINCT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id = ".(int)$arr1[$j]." ");
        $id_array = array();
        while (!$cat_id2->EOF) {
          $arr2 []= $cat_id2->fields['id'];
          $id_array []= $cat_id2->fields['id'];
          $cat_id2->MoveNext();
        }
        //二级分类目录下三级目录下产品
        //var_dump($id_array);
        if($id_array != null){
          $cat_id2_1 = $db->Execute("SELECT DISTINCT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id in (".join(',',$id_array).")  ");
          $id_array2 = array();
          while (!$cat_id2_1->EOF) {
            $id_array2 [] = $cat_id2_1->fields['id'];
            $cat_id2_1->MoveNext();
          }
          //二级分类目录下四级目录下产品
          //var_dump($id_array2);
          if($id_array2 != null){
            $cat_id2_2 = $db->Execute("SELECT DISTINCT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id in (".join(',',$id_array2).")  ");
            $id_array3 = array();
            while (!$cat_id2_2->EOF) {
              $id_array3 [] = $cat_id2_2->fields['id'];
              $cat_id2_2->MoveNext();
            }
            //二级分类目录下五级目录下产品
            //var_dump($id_array3);
            if($id_array3 != null){
              $cat_id2_3 = $db->Execute("SELECT DISTINCT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id in (".join(',',$id_array3).")  ");
              $id_array4 = array();
              while (!$cat_id2_3->EOF) {
                $id_array4 [] = $cat_id2_3->fields['id'];
                $cat_id2_3->MoveNext();
              }
              //二级分类目录下六级目录下产品
              //var_dump($id_array4)."二级分类目录下六级目录下产品";

              $sql3 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
									ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array3).")  ";
              $result3 = $db->Execute($sql3);
              while (!$result3->EOF) {
                $total = $result->fields['total'];
                $result3->MoveNext();
              }
              //echo "Count:".$total."<br>";
              $this->zen_get_page_total($total,$arr1[$j]);
            }else $this->zen_get_page_rows($arr1[$j]);

            $sql = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
						ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array2).")  ";
            $result = $db->Execute($sql);
            while (!$result->EOF) {
              $total = $result->fields['total'];
              $result->MoveNext();
            }
            //echo "Count:".$total."<br>";
            $this->zen_get_page_total($total,$arr1[$j]);
          }else $this->zen_get_page_rows($arr1[$j]);

          $sql2 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
					ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array).")  ";
          //echo $sql2;
          $result2 = $db->Execute($sql2);
          while (!$result2->EOF) {
            $total = $result2->fields['total'];
            $result2->MoveNext();
          }
          //echo "Count:".$total."<br>";
          //二级分类目录下三级产品个数
          $this->zen_get_page_total($total,$arr1[$j]);
        }else $this->zen_get_page_rows($arr1[$j]);
      }

      for($m=0;$m<sizeof($arr2);$m++){
        //三级目录ID
        //echo "三级目录".$arr2[$m]."<br>";
        //$this->zen_get_page_rows($arr2[$m]);
        $id_array = array();
        $cat_id3 = $db->Execute("SELECT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id = ".(int)$arr2[$m]." ");
        while (!$cat_id3->EOF) {
          $arr3 []= $cat_id3->fields['id'];
          $id_array []= $cat_id3->fields['id'];
          $cat_id3->MoveNext();
        }
        if($id_array != null){
          $cat_id3_1 = $db->Execute("SELECT DISTINCT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id in (".join(',',$id_array).")  ");
          $id_array3_1 = array();
          while (!$cat_id3_1->EOF) {
            $id_array3_1 [] = $cat_id3_1->fields['id'];
            $cat_id3_1->MoveNext();
          }

          //var_dump($id_array3_1);
          if($id_array3_1 != null){
            //三级分类目录下六级产品个数
            $cat_id3_2 = $db->Execute("SELECT DISTINCT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id in (".join(',',$id_array).")  ");
            $id_array3_2 = array();
            while (!$cat_id3_2->EOF) {
              $id_array3_2 [] = $cat_id3_2->fields['id'];
              $cat_id3_2->MoveNext();
            }
            if($id_array3_2 != null){
              $sql3_2 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
							ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array3_2).")  ";
              //echo $sql2;
              $result = $db->Execute($sql3_2);
              while (!$result->EOF) {
                $total = $result->fields['total'];
                $result->MoveNext();
              }
              $this->zen_get_page_total($total,$arr2[$m]);
            }else $this->zen_get_page_rows($arr2[$m]);

            //三级分类目录下五级产品个数
            $sql1 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
						ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array3_1).")  ";
            //echo $sql2;
            $result = $db->Execute($sql1);
            while (!$result->EOF) {
              $total = $result->fields['total'];
              $result->MoveNext();
            }
            //echo "Count:".$total."<br>";
            //三级分类目录下四级产品个数
            $this->zen_get_page_total($total,$arr2[$m]);
          }else $this->zen_get_page_rows($arr2[$m]);

          $sql2 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
					ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array).")  ";
          //echo $sql2;
          $result = $db->Execute($sql2);
          while (!$result->EOF) {
            $total = $result->fields['total'];
            $result->MoveNext();
          }
          //echo "Count:".$total."<br>";
          //二级分类目录下三级产品个数
          $this->zen_get_page_total($total,$arr2[$m]);
        }else $this->zen_get_page_rows($arr2[$m]);

      }

      for($n=0;$n<sizeof($arr3);$n++){
        //四级目录ID
        //echo "四级目录".$arr2[$m]."<br>";
        //$this->zen_get_page_rows($arr3[$n]);
        $id_array = array();
        $cat_id4 = $db->Execute("SELECT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id = ".(int)$arr3[$n]." ");
        while (!$cat_id4->EOF) {
          $arr4 []= $cat_id4->fields['id'];
          $id_array []= $cat_id4->fields['id'];
          $cat_id4->MoveNext();
        }
        if($id_array != null){
          $cat_id4_2 = $db->Execute("SELECT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id in (".join(',',$id_array).") ");
          $id_array4_2 = array();
          while (!$cat_id4_2->EOF) {
            $id_array4_2 []= $cat_id4_2->fields['id'];
            $cat_id4_2->MoveNext();
          }
          //var_dump($id_array4_2);
          //四级分类目录下六级产品个数
          if($id_array4_2 != null){
            $sql4_2 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
							ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array4_2).")  ";
            //echo $sql2;
            $result = $db->Execute($sql4_2);
            while (!$result->EOF) {
              $total = $result->fields['total'];
              $result->MoveNext();
            }
            //echo "Count:".$total."<br>";
            $this->zen_get_page_total($total,$arr3[$n]);
          }else $this->zen_get_page_rows($arr3[$n]);

          $sql2 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
					ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array).")  ";
          //echo $sql2;
          $result = $db->Execute($sql2);
          while (!$result->EOF) {
            $total = $result->fields['total'];
            $result->MoveNext();
          }
          //echo "Count:".$total."<br>";
          //四级分类目录下五级产品个数
          $this->zen_get_page_total($total,$arr3[$n]);
        }else $this->zen_get_page_rows($arr3[$n]);
      }

      for($k=0;$k<sizeof($arr4);$k++){
        //五级目录ID
        //echo "五级目录".$arr2[$m]."<br>";
        //$this->zen_get_page_rows($arr4[$k]);
        $id_array = array();
        $cat_id5 = $db->Execute("SELECT categories_id as id FROM " . TABLE_CATEGORIES . " WHERE parent_id = ".(int)$arr4[$k]." ");
        while (!$cat_id5->EOF) {
          $arr5 []= $cat_id5->fields['id'];
          $id_array []= $cat_id5->fields['id'];
          $cat_id5->MoveNext();
        }
        if($id_array != null){
          $sql2 = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p  LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc
					ON p.products_id=ptc.products_id where p.products_status = 1 AND ptc.categories_id in (".join(',',$id_array).")  ";
          //echo $sql2;
          $result = $db->Execute($sql2);
          while (!$result->EOF) {
            $total = $result->fields['total'];
            $result->MoveNext();
          }
          //echo "Count:".$total."<br>";
          //五级分类目录下六级产品个数
          $this->zen_get_page_total($total,$arr4[$k]);
        }else $this->zen_get_page_rows($arr4[$k]);
      }
      for($p=0;$p<sizeof($arr5);$p++){
        //六级目录ID
        //echo "六级目录".$arr2[$m]."<br>";
        $this->zen_get_page_rows($arr5[$p]);

      }

    }
    echo 'finished categories page link sitemap  <br/>';
    $this->SitemapClose();
  }
  public function build_es_categories_sitemap(){
    $this->build_categories_sitemap('es');
  }
  public function build_es_products_sitemap(){
    $this->build_products_sitemap('es');
  }
  public function build_es_solution_article_sitemap(){
    $this->build_solution_article_sitemap('es');
  }
//	 public function build_es_Narrow_by_sitemap(){
//	 	$this->build_Narrow_by_sitemap('es');
//	 }

}
