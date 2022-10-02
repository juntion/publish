<?php
class description_template_class{
    // public  $aaaa;
    public $template = array();
    public $excel_head = array(); 

	function description_template_class() { 
	    $this->template = array('Product Details;Cisco Genuine: QSFP-40G-SR4:Vendor Name: FiberStore;Form Type: QSFP+:Max Data Rate: 41.25Gbps;',
	                            'Product Support;Cisco Nexus 2000 N2K-C2248PQ:Cisco Nexus 2000 N2K-2348TQ;Cisco Nexus 2000 N2K-C2248PQ:Cisco Nexus 2000 N2K-2348TQ;',
	                            'Product Description & Image;The Standard 1RU Rack ;-- Dimensions; -- Mounting: Universal; 图片链接;图片链接;',
	                            'Product Specs;Designation,OM1,OM2,OM3;Fiber Dia.(um), 62.5/125, 50/125, 50/125;Type, Multimode, Multimode, Multimode;',
	                            'Product Link;-- Using standard CWDM;#id; id; id; id; id; id'
	                           );

	    $this->excel_head = array('Product Details','Product Support','Product Description & Image','Product Description &amp; Image','Product Specs','Product Link','Description & PDF Link');                       	                           
	} 
	
        
	function compress_html($string) { 
				$string = str_replace("\r\n", '', $string); //清除换行符 
				$string = str_replace("\n", '', $string); //清除换行符 
				$string = str_replace("\t", '', $string); //清除制表符 
				$pattern = array ("/> *([^ ]*) *</","/[\s]+/","/<!--[^!]*-->/","/\" /", 
								  "/ \"/","'/\*[^*]*\*/'"); 
				$replace = array (">\\1<"," ","","\"","\"",""); 
	       return preg_replace($pattern, $replace, $string); 
	} 
		
	function explode_prod_desc(& $products_description,$div_array) { 
	    $prod_desc_array = array() ;	    
	    
	    while (1){	    		        
            for ($i = 0,$n = sizeof($div_array); $i < $n; $i++) {
			    $div_pos = strrpos($products_description, $div_array[$i]);
			    if ($div_pos === false) {	         
			        // 没找到;
			        continue ;
			    }else{
			        // 找到了 
			         $prod_desc_array[] = substr($products_description, $div_pos);
			         $products_description = substr($products_description, 0, $div_pos);			         
			         continue 2 ;  
			    }                   	
            }
            // 匹配的数组循环完了  还没有找到  说明 没有可以分割的了
            break ;                       
	    }
	    
	    // 如果开头的字符串  还有没截取完的  加入第一个
//	    if (mb_strlen($products_description) > 0) {   
//	       $index = sizeof($prod_desc_array) > 0 ? sizeof($prod_desc_array)-1 : 0;
//	       $prod_desc_array[$index] = $products_description.$prod_desc_array[$index] ;      
//	    }
	    
	    if (mb_strlen(trim($products_description)) > 0) {  
	        $prod_desc_array[] =  $products_description ;     
	    }	    

	   //调整分块的顺序  倒叙
	   $prod_desc_array = array_reverse($prod_desc_array);
	   
	   return $prod_desc_array; 
	} 	

	//  2016 4 26    按照     $explode_str = '<div name="description">';  拆分
	function explode_product_desc($products_description,$explode_str) { 
	    $prod_desc_array = array() ;	    

	    while (1){        
            $div_pos = strrpos($products_description, $explode_str); 
	        if ($div_pos === false) {  break ;   }	
	                        
		    $prod_desc_array[] = substr($products_description, $div_pos);
			$products_description = substr($products_description, 0, $div_pos);			         			         	                      
	    }	

	   //调整分块的顺序  倒叙
	   $prod_desc_array = array_reverse($prod_desc_array);	    
	   return $prod_desc_array; 
	} 	
	
	
	
	
    function make_sure_is_stand($products_description ,$explode_str) { 
            $div_pos = strrpos($products_description, $explode_str); 
	        if ($div_pos === false) { 
	              return false; 
	        }else {
	              return true; 
	        }	
	} 		
	
   function get_excel_head($excel_head) { 
	    $return_array = array() ;
	    //$this->excel_head ;	    

        foreach ($excel_head as $value) {        
           foreach ($this->excel_head as $head_value) {
           
                $temp_str = '<div class="p_con_01" name="'.$head_value.'">' ;
             	$div_pos = strrpos($value, $temp_str);
			    if ($div_pos === false) {	         
			        // 没找到;
			        continue ;
			    }else{
			        // 找到了 
			        $return_array[] = $head_value;			         
			        continue 2 ;  
			    }         
           }	    
        }

	   //$return_array = array_reverse($return_array);
	   return $return_array; 
	} 	

	
	function filter_code($str) { 
	  $str = strip_tags($str);   
	   return $str; 
	} 	
	
/*
 * 	
	
   function delete_code($prod_desc_temp) { 
	    $return_array = array() ;

        foreach ($prod_desc_temp as $value) {      
           foreach ($this->excel_head as $head_value) {  
           
                $temp_str = '<div class="p_con_01" name="'.$head_value.'">' ;
             	$div_pos = strrpos($value, $temp_str);
			    if ($div_pos === false) {
			        //$return_array[] = 'bbbb';		         
			        // 没找到;
			        continue ;
			    }else{
			        // 找到了 
			       // $return_array[] = $this->delete_code_type($value,$head_value);			         
			        $return_array[] = 'aaaa';			         
			        continue 2 ;  
			    }         
           }	              
        }

	  // $return_array = array_reverse($return_array);
	   return $return_array; 
	} 	

	
	

	
 * */	
	
   function delete_code($excel_head) { 
	    $return_array = array() ;
        foreach ($excel_head as $value) {        
           foreach ($this->excel_head as $head_value) {
           
                $temp_str = '<div class="p_con_01" name="'.$head_value.'">' ;
             	$div_pos = strrpos($value, $temp_str);
			    if ($div_pos === false) {	         
			        // 没找到;
			        continue ;
			    }else{
			        // 找到了 
			        //$return_array[] = $head_value;	
			        $return_array[] = $this->delete_code_type($value,$head_value);		         
			        continue 2 ;  
			    }         
           }	    
        }
	   return $return_array; 
	} 	

	
//  array('Product Details','Product Support','Product Description & Image','Product Specs','Product Link'); 	
   function delete_code_type($value,$head_value) {
        $return_str = '';
        switch ($head_value) {
        	case 'Product Details':
        	    $return_str = $this->delete_code_details($value);
        	break;
        	case 'Product Support':
        	    $return_str = $this->delete_code_support($value);
        	break;
        	case 'Product Description & Image':
        	    $return_str = $this->delete_code_image($value);
        	break;
        	case 'Product Specs':
        	    $return_str = $this->delete_code_specs($value);
        	break;       	        	
         	case 'Product Link':
        	    $return_str = $this->delete_code_link($value);
        	break;   
          	case 'Description & PDF Link':
        	    $return_str = $this->delete_code_pdf($value);
        	break; 
        	default:
        	    ;
        	break;
        }
	   return $return_str; 
	} 	
	
	function delete_code_details($product_details) {
	   // $product_details = $this->compress_html($product_details);
	    
	    $temp_str = '';
        $str_pos = strpos($product_details, '</div>');    
        // 标题       
        $detail_titile = substr($product_details, 0, $str_pos+6);        
		$detail_titile =str_replace('<div name="description">', '', $detail_titile);
		$detail_titile =str_replace('<div class="p_con_01" name="Product Details">', '', $detail_titile);
		$detail_titile =str_replace('</div>', '', $detail_titile);

	    if (!$detail_titile) { return '' ;}	
	    
	    $product_details = substr($product_details, $str_pos+6);
	    
	    
	    
	   $str_pos = strpos($product_details, '<table'); 	
	   if ($str_pos === false) {
	      // 没有表格的情况	;
		 $detail_span = $product_details;
	     $product_details = '';      	   
	   }else{	   
	     $detail_span = substr($product_details, 0, $str_pos);
	     $product_details = substr($product_details, $str_pos);
	   }
	    
	   $detail_span =str_replace('<div class="p_con_02">', '', $detail_span);
	   $detail_span =str_replace('</div>', '', $detail_span);
	   $detail_span =str_replace('<br>', '#', $detail_span);
	   if ($detail_span) { $detail_span .= '#';}
	    

	   
	   // $product_details = substr($product_details, $str_pos);
	   
	   
	
		$product_details =str_replace('<div name="description">', '', $product_details);
		$product_details =str_replace('<div class="p_con_01" name="Product Details">', '', $product_details);
		$product_details =str_replace('</div>', '', $product_details);
		$product_details =str_replace('<tbody>', '', $product_details);
		$product_details =str_replace('<tr>', '', $product_details);
		$product_details =str_replace('<td>', '', $product_details);
		$product_details =str_replace('<td >', '', $product_details);
		$product_details =str_replace('<td bgcolor="#f4f4f4">', '', $product_details);
		$product_details =str_replace('<b>', '', $product_details);
		$product_details =str_replace('</b>', '', $product_details);
        $product_details =str_replace('</tbody>', '', $product_details);
        $product_details =str_replace('</table>', '', $product_details);	

        
        
		
		$product_details =str_replace('<table border="0" cellpadding="0" cellspacing="0" class="solu_table01" width="100%">', '', $product_details);
		$product_details =str_replace('</td>', ':', $product_details);
		$product_details =str_replace('</tr>', ';', $product_details);
		
		$product_details =str_replace('::', '', $product_details);
        $product_details =str_replace(':;', ';', $product_details);
        
       // if (!$product_details) { return   ''; }
        
		$product_details = substr($product_details,0,strlen($product_details)-1); 
		
	    return $detail_titile.';'.$detail_span.$product_details; 
	}
	
	function delete_code_support($platform_support) {
	  //  $platform_support = $this->compress_html($platform_support);
	  
        $str_pos = strpos($platform_support, '</div>');    
        // 标题       
        $detail_titile = substr($platform_support, 0, $str_pos+6);        
		$detail_titile =str_replace('<div name="description">', '', $detail_titile);
		$detail_titile =str_replace('<div class="p_con_01" name="Product Support">', '', $detail_titile);
		$detail_titile =str_replace('</div>', '', $detail_titile);
		
		if (!$detail_titile) { return '' ;}

         // 内容
        $platform_support = substr($platform_support, $str_pos+6);	
        
        $str_pos = strpos($platform_support, '</div>');    
        // 小标题       
        $detail_titile1 = substr($platform_support, 0, $str_pos+6);        
		$detail_titile1 =str_replace('<div name="description">', '', $detail_titile1);
		$detail_titile1 =str_replace('<div class="p_con_02">', '', $detail_titile1);
		$detail_titile1 =str_replace('</div>', '', $detail_titile1);
        
	
	    $platform_support = substr($platform_support, $str_pos+6);	

		$platform_support =str_replace('<div name="description">', '', $platform_support);
		$platform_support =str_replace('<div class="p_con_01" name="Product Support">', '', $platform_support);	
		$platform_support =str_replace('</div><div class="p_con_02">', '', $platform_support);       
		$platform_support =str_replace('<table width="100%" cellspacing="0" cellpadding="0" border="0">', '', $platform_support);    
        $platform_support =str_replace('</div>', '', $platform_support);
        $platform_support =str_replace('<br/>', '', $platform_support);	    
		$platform_support =str_replace('<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>', '', $platform_support);
		$platform_support =str_replace('<table border="0"cellpadding="0"cellspacing="0"width="100%">', '', $platform_support);
		$platform_support =str_replace('<td valign="top"width="50%">', '', $platform_support);
		$platform_support =str_replace('<tr>', '', $platform_support);
		$platform_support =str_replace('</tr>', '', $platform_support);
		$platform_support =str_replace('<td valign="top" width="50%">', '', $platform_support);
		$platform_support =str_replace('<div class="p_con_02">', '', $platform_support);
		$platform_support =str_replace('</td>', '', $platform_support);        
        
		$platform_support =str_replace('<table border="0" cellpadding="0" cellspacing="0" width="100%">', '', $platform_support);
		$platform_support =str_replace('<br />', '', $platform_support);
		$platform_support =str_replace('<tbody>', '', $platform_support);
		$platform_support =str_replace('</tbody>', '', $platform_support);
		$platform_support =str_replace('</table>', '', $platform_support);

		$platform_support =str_replace('<span>', '', $platform_support);  //先替换span  然后以  </span>  分成数组
		
		
		//Product Support;test_small_total;
		//  Cisco Nexus 2000 N2K-C2248PQ</span>Cisco Nexus 2000 N2K-C2248PQ</span>Cisco Nexus 2000 N2K-C2248PQ
		// </span></span>
		//Cisco Nexus 2000 N2K-2348TQ</span>Cisco Nexus 2000 N2K-2348TQ</span>Cisco Nexus 2000 N2K-2349TQ</span></span>
		//去掉最后一个  span
		$str_pos = strrpos($platform_support, "</span>"); 
	    $platform_support = substr($platform_support, 0, $str_pos); 

		$platform_array = explode("</span>",$platform_support) ; 
		$arr_num  =  ceil(sizeof($platform_array)/2) ;
		
		    $platform_string= '';
			 
			for($st=0;$st<$arr_num;$st++){
			       if ($st == ($arr_num-1)) {
			       	   $platform_string.=$platform_array[$st].':'.$platform_array[$st+$arr_num];
			       }else{
			           $platform_string.=$platform_array[$st].':'.$platform_array[$st+$arr_num].';';
			       }   
			}
			 
	    return $detail_titile.';'.$detail_titile1.';'.$platform_string; 
	   // return $detail_titile.';'.$detail_titile1.';'.$platform_support; 
	}	

	
	function delete_code_image($product_image) {
	  //  $product_image = $this->compress_html($product_image);

        $str_pos = strpos($product_image, '</div>');    
        // 标题       
        $detail_titile = substr($product_image, 0, $str_pos+6);        
		$detail_titile =str_replace('<div name="description">', '', $detail_titile);
		$detail_titile =str_replace('<div class="p_con_01" name="Product Description & Image">', '', $detail_titile);
		$detail_titile =str_replace('</div>', '', $detail_titile);
		
	    if (!$detail_titile) { return '' ;}

         // 内容
        $product_image = substr($product_image, $str_pos+6);  
            
		$product_image =str_replace('<div name="description">', '', $product_image);
		$product_image =str_replace('<div class="p_con_01" name="Product Description & Image">', '', $product_image);
		$product_image =str_replace('<div class="p_con_02">', '', $product_image);	
		$product_image =str_replace('</div>', '', $product_image);	
				
		$product_image =str_replace('<br>', ';', $product_image);			
		$product_image =str_replace('<div style="text-align: center;" class="p_con_02">', '#', $product_image);			
		
		$product_image =str_replace('<img src="', '', $product_image);			
		$product_image =str_replace('" >', ';', $product_image);		

		$product_image = substr($product_image,0,strlen($product_image)-1); 

	    return $detail_titile.';'.$product_image; 
	}		
	
	
	function delete_code_specs($product_data) {
	   // $product_data = $this->compress_html($product_data);
        $temp_str = '';
        $str_pos = strpos($product_data, '</div>');    
        // 标题       
        $detail_titile = substr($product_data, 0, $str_pos+6);        
		$detail_titile =str_replace('<div name="description">', '', $detail_titile);
		$detail_titile =str_replace('<div class="p_con_01" name="Product Specs">', '', $detail_titile);
		$detail_titile =str_replace('</div>', '', $detail_titile);

	    if (!$detail_titile) { return '' ;}
	    
	     $product_data = substr($product_data, $str_pos+6);
	     

	     
	    $product_data_arr = $this->explode_product_desc($product_data,'<div class="p_con_02">') ;
	    
	    foreach ($product_data_arr as $value) {
	       if ($value) {
	       	 $temp_str .= $this->delete_code_specs_tab($value).'||';
	       }
	    }
	    if ($temp_str) {
	         $temp_str = substr($temp_str,0,strlen($temp_str)-2);
	    }

	    return $detail_titile.';'.$temp_str; 
	  //  return $detail_titile.';'.$product_data; 
	}		
	
	
	
	function delete_code_specs_tab($product_data) {
	
	   $str_pos = strpos($product_data, '<table'); 	   
	   $detail_span = substr($product_data, 0, $str_pos);
	   	   
	   $detail_span =str_replace('<div class="p_con_02">', '', $detail_span);
	   $detail_span =str_replace('</div>', '', $detail_span);
	   $detail_span =str_replace('<br>', '#', $detail_span);
	   if ($detail_span) { $detail_span .= '#';}	    

	    
		$product_data = substr($product_data, $str_pos); 
            
		$product_data =str_replace('<div name="description">', '', $product_data);
		$product_data =str_replace('<div class="p_con_01" name="Product Specs">', '', $product_data);
		$product_data =str_replace('</div>', '', $product_data);
		$product_data =str_replace('<div class="p_con_02">', '', $product_data);
		$product_data =str_replace('<table width="100%" cellspacing="0" cellpadding="0" class="p_con_tab_01">', '', $product_data);
		$product_data =str_replace('<tbody>', '', $product_data);
		$product_data =str_replace('<tr>', '', $product_data);
		$product_data =str_replace('<tr >', '', $product_data);
		$product_data =str_replace('<tr class="p_con_04">', '', $product_data);
		$product_data =str_replace('<td>', '', $product_data);
		$product_data =str_replace('<td >', '', $product_data);
		$product_data =str_replace('<td bgcolor="#dedede">', '', $product_data);
		$product_data =str_replace('</tbody>', '', $product_data);		
		$product_data =str_replace('</table>', '', $product_data);		
		
		$product_data =str_replace('</td>', ':', $product_data);
		$product_data =str_replace('</tr>', ';', $product_data);

        $product_data =str_replace(':;', ';', $product_data);	
        
        $product_data = substr($product_data,0,strlen($product_data)-1); 	
		
        //  Designation:Fiber Dia.(um):Type   ;  OM1: 62.5/125: Multimode  ;   OM2: 50/125: Multimode;   OM3: 50/128: Multimode
		
		if ($product_data) {
			    $row = explode(";",$product_data) ;  
			    $tr_qty = sizeof($row);             //行 数  
			    $td = explode(":",$row[0]) ;     
		        $td_qty = sizeof($td);          // 表格的  列的数量   多少个td       
		        		       		
		        $temp_arr = array();
		        $temp_str = '';
		        for ($i = 0; $i < $td_qty; $i++) {   
		            for ($j = 0; $j < $tr_qty; $j++) { 		                          
		                $line = explode(":",$row[$j]) ; 		                           
		                $temp_arr[$i][$j] = $line[$i];        	
		            }
		        }

		        for ($i = 0; $i < $td_qty; $i++) {		              
		              for ($j = 0 ; $j < $tr_qty; $j++) {
		              	  $temp_str .=  $j==($tr_qty-1) ? $temp_arr[$i][$j] : $temp_arr[$i][$j].',';
		              }
		        	  $temp_str .= $i == ($td_qty-1) ? '' : ';';
		        }       
		}	
	
	 return $detail_span.$temp_str; 
	
	}	
	
	function delete_code_link($product_data) {
	   // $product_data = $this->compress_html($product_data);

        $str_pos = strpos($product_data, '</div>');    
        // 标题       
        $detail_titile = substr($product_data, 0, $str_pos+6);        
		$detail_titile =str_replace('<div name="description">', '', $detail_titile);
		$detail_titile =str_replace('<div class="p_con_01" name="Product Link">', '', $detail_titile);
		$detail_titile =str_replace('</div>', '', $detail_titile);	
		
		
	    if (!$detail_titile) { return '' ;}
	    
        
        $product_data = substr($product_data, $str_pos+6);  
        
        // 文字描述
        $str_pos = strpos($product_data, '<div class="p_con_recommended">');           
        $detail_span = substr($product_data, 0, $str_pos);  

        $detail_span =str_replace('<div class="p_con_02">', '', $detail_span);
        $detail_span =str_replace('</div>', '', $detail_span);
               
        $detail_span =str_replace('<br>', ';', $detail_span);
        
        // 内容
        $product_data = substr($product_data, $str_pos+6); 
        
        
        
	 //if ( $_SESSION['languages_id'] ==  1 ) { $_SESSION['languages_id'] =  6 ;}
	 
        if($_SESSION['languages_id'] !=1){         
 			switch ($_SESSION['languages_id']) {  	
				case '2': $lan_str = 'http://www.fs.com/es'; $pre_str = 'http:\/\/www.fs.com\/es'; break;
				case '3': $lan_str = 'http://www.fs.com/fr'; $pre_str = 'http:\/\/www.fs.com\/fr'; break;
				case '4': $lan_str = 'http://www.fs.com/ru'; $pre_str = 'http:\/\/www.fs.com\/ru'; break;
				case '5': $lan_str = 'http://www.fs.com/de'; $pre_str = 'http:\/\/www.fs.com\/de'; break;	
							
				case '6': $lan_str = 'http://www.feisu.com';   $pre_str = 'http:\/\/www.feisu.com';    break;	
							
				default:  $lan_str = ''; $pre_str = '';        break;
			}	            
		  }else{          $lan_str = ''; $pre_str = ''; }
		  
	 //	$_SESSION['languages_id'] =  1  ;  		  		  
		  		 		  
		  
	    if ($lan_str  && strpos($product_data, $lan_str.'/products')) {
        	preg_match_all('/'.$pre_str.'\/products\/([0-9]+).html/', $product_data, $matches);
        }else{
            preg_match_all('/http:\/\/www.fs.com\/products\/([0-9]+).html/', $product_data, $matches);
        }
		          
        //preg_match_all('/http:\/\/www.fs.com'.$lan_str.'\/products\/([0-9]+).html/', $product_data, $matches);
        
        $product_id = $matches[1] ;  
        $product_id_str = '';
        
        for ($i = 0 , $n=sizeof($product_id); $i < $n; $i++) {
        	$product_id_str .= $i==($n-1) ? $product_id[$i] : $product_id[$i].';';
        }
        
        //<a href="http://www.fs.com/products/15385.html" target="_blank">
        
       // preg_match_all("/http://www.fs.com/products/(*).html/", $product_data, $matches);

	    return $detail_titile.';'.$detail_span.'#'.$product_id_str; 
	}		
		
	
	function delete_code_pdf($product_data) {
	
	   $return_str = '' ;
	   $product_data =str_replace('<div name="description">', '', $product_data);

	   $product_data_arr = $this->explode_product_desc($product_data,'<div class="p_con_01" name="Description & PDF Link">') ;
	   
	   $n = sizeof($product_data_arr);
	   
	   foreach ($product_data_arr as $i=>$value) {
	      if ($value) {
		        $str_pos = strpos($value, '</div>');     
		        $detail_titile = substr($value, 0, $str_pos+6); 
		               
				$detail_titile =str_replace('<div name="description">', '', $detail_titile);
				$detail_titile =str_replace('<div class="p_con_01" name="Description & PDF Link">', '', $detail_titile);
				$detail_titile =str_replace('</div>', '', $detail_titile);
				
				
	           if (!$detail_titile) { continue ;}
	           
				
				$return_str .= $detail_titile.';' ;
				
				
			   $value = substr($value, $str_pos+6);  
               preg_match_all('/<a href="(.+)" target="_blank">(.+)<\/a>/', $value, $matches);
               $pdf_src = $matches[1][0] ;  
               $pdf_name = $matches[2][0] ;               
               $pdf_str = $pdf_src.':'.$pdf_name;
    
               $return_str .=  $i==($n-1) ? $pdf_str : $pdf_str.'#';  
               
	      }
	   }
	   
	  return  $return_str;  
	
	
	
//	
//        $str_pos = strpos($product_data, '</div>');    
//        // 标题       
//        $detail_titile = substr($product_data, 0, $str_pos+6);        
//		$detail_titile =str_replace('<div name="description">', '', $detail_titile);
//		$detail_titile =str_replace('<div class="p_con_01" name="Description & PDF Link">', '', $detail_titile);
//		$detail_titile =str_replace('</div>', '', $detail_titile);	
//		
//		
//	    if (!$detail_titile) { return '' ;}
//	           
//        $product_data = substr($product_data, $str_pos+6);  
//
//       // preg_match_all('/http:\/\/www.fs.com\/products\/([0-9]+).html/', $product_data, $matches);
//        preg_match_all('/<a href="(.+)" target="_blank">(.+)<\/a>/', $product_data, $matches);
//        $pdf_src = $matches[1][0] ;  
//        $pdf_name = $matches[2][0] ;  

//	    return $detail_titile.';'.$pdf_src.':'.$pdf_name; 
	}	
	
	
   // 加上代码
   function add_code_type($value,$head_value) {
        $return_str = '';
        switch ($head_value) {
        	case 'Product Details':
        	    $return_str = $this->add_code_details($value);
        	break;       	
        	case 'Product Support':
        	    $return_str = $this->add_code_support($value);
        	break;
        	case 'Product Description & Image':
        	    $return_str = $this->add_code_image($value);
        	break;
			case 'Product Description &amp; Image':
        	    $return_str = $this->add_code_image($value);
        	break;
        	case 'Product Specs':
        	    $return_str = $this->add_code_specs($value);
        	break;       	        	
         	case 'Product Link':
        	    $return_str = $this->add_code_link($value);
        	break; 
         	case 'Description & PDF Link':
        	    $return_str = $this->add_code_pdf($value);
        	break; 
        	default:
                 ;
        	break;
        }
	   return $return_str; 
  } 		
	
	
	
  
	//Product Details  样式的板块
   function add_code_details($detail) {
   
    $return_str = '';
    $detail = str_replace("；", ";",$detail);
    $detail = str_replace("：", ":",$detail); 

    $str_pos = strpos($detail, ';'); 
    if ($str_pos === false) {  
        // 没有填写内容   和  填写不规范的 情况
        //  待处理
        return '<div name="description"><div class="p_con_01" name="Product Details"></div></div>'; 
    }else{
        $detail_titile = substr($detail, 0, $str_pos+1);	
        $detail = substr($detail, $str_pos+1);      
    }	

     // 标题
     $detail_titile = str_replace(";", "",$detail_titile);
     
    //  第一个元素为标题
    // '<div class="p_con_01" name="'.$head_value.'">'
    $return_str = '<div name="description"><div class="p_con_01" name="Product Details">'.$detail_titile.'</div>';
     

     
      $str_pos = strrpos($detail, '#');   
	 if ($str_pos === false) {  }else{
	    $detail_span = substr($detail, 0, $str_pos+1);
	   	$detail = substr($detail, $str_pos+1);	
	   	
	    $detail_span = substr($detail_span,0,strlen($detail_span)-1); 
        $detail_span = str_replace("#", "<br>",$detail_span);         
	   	$return_str .= '<div class="p_con_02">'.$detail_span.'</div>';   	
	 }	
     
    
	 
	 $detail = trim($detail);
	 if (strlen($detail) > 1) {
	  
     $wordurl = explode(";",$detail) ;     
     $tr_qty = sizeof($wordurl);          // 表格的行数   多少个tr
     $td = explode(":",$wordurl[0]) ;     
     $td_qty = sizeof($td);               //一行几列    
     $to_td = str_replace(";", ":",$detail);
     $total_td = explode(":",$to_td) ;    //总共有多少 td 
    


    $detail_table ='';
     if($tr_qty){                
          $detail_table .='<table border="0" cellpadding="0" cellspacing="0" class="solu_table01" width="100%"><tbody>';
          $now_td = 0;
          $tdcss ='';
	    for($i=0;$i<$tr_qty;$i++){
	    	if($i % 2 ==0){  $tdcss ='bgcolor="#f4f4f4"';	}else{  $tdcss ='';	}	
	    	
	        $detail_table .='<tr>';	        	        
	          for($d=0;$d<$td_qty;$d++){
	            $now_td = ($i * $td_qty) + $d;
	            if($d % 2 ==0){
	            $detail_table .='<td '.$tdcss.'><b>'.$total_td[$now_td].'</b></td>';
	            }else{
	            $detail_table .='<td '.$tdcss.'>'.$total_td[$now_td].'</td>';
	            }	            
	          }
	        $detail_table .='</tr>';
	    }
     $detail_table .='</tbody></table>';
     }
        
     
	 }
     
     
     $return_str = $return_str .$detail_table.'</div>' ;
        
	 return $return_str; 
	} 		
	
	//Product Support  样式的板块
   function add_code_support($support) {
   
    $return_str = '';
    $support = str_replace("；", ";",$support);
    $support = str_replace("：", ":",$support); 

    $str_pos = strpos($support, ';'); 
    if ($str_pos === false) {  
        // 没有填写内容   和  填写不规范的 情况
        //  待处理
        return '<div name="description"><div class="p_con_01" name="Product Support"></div></div>'; 
    }else{
        $detail_titile = substr($support, 0, $str_pos+1);	
        $support = substr($support, $str_pos+1);    
    }	

     // 标题
     $detail_titile = str_replace(";", "",$detail_titile);

     $return_str = '<div name="description"><div class="p_con_01" name="Product Support">'.$detail_titile.'</div>';

       if($support){    
          $wordurl = explode(";",$support) ;
          $support_title ='<div class="p_con_02">'.$wordurl[0].'</div>';
      	//获取的页面内容也要做成表格
	     $support_table ='';
	     $support_table .='<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr>';
	     $wordurl[1] = trim($wordurl[1]);    //移除空格
         if(!strpos($wordurl[1],"www.")){       //判断机制 是 第二个数组里没有  www.       
       //如果是手动填写的内容   
           $show_hide = false;
	       if(sizeof($wordurl) > 20){  $show_hide = true;  }
	       $idnum =0;
	       for($tdline=0;$tdline<2;$tdline++){
	       	$idnum ++;
		        $support_table .='<td valign="top" width="50%"><div class="p_con_02">';
		          for($st=1;$st<sizeof($wordurl);$st++){
		            $Gspan = explode(":",$wordurl[$st]) ;
		          if($st == 21){
			      $support_table .= '<div id="platform_support'.$idnum.'_'.$id.'" style="display:none;">';
			    }
	                $support_table .='<span>'.$Gspan[$tdline].'</span>';
		          }
		        $support_table .='</td>';
	        }
        if($show_hide){
		    $support_table .='</div>';
		  }
      }else{
         //从链接中获取内容
	     $match = get_contents($wordurl[1],'/<div[^>]*id="p6"[^>]*>(.*?) <\/div>/si');
	     $match = str_replace('div','span',$match['1']['0']);
		 $span_qty = explode("</span>",$match) ;   //总共 span 个数。然后将其分为两个数组
		 $span_size = sizeof($span_qty);
		 $sz = (int)($span_size/2);
		 $show_hide = false;
	       if($sz > 20){  $show_hide = true;  }
		 //第一列
		 $support_table .='<td valign="top" width="50%"><div class="p_con_02">';
		  for($s=0;$s<$sz;$s++){
		    if($s == 20){
		      $support_table .= '<div id="platform_support1_'.$id.'" style="display:none;">';
		    }
		     $support_table .=$span_qty[$s].'</span>';
		  }
		  if($show_hide){
		    $support_table .='</div>';
		  }
		 $support_table .='</td>';
		 //第二列
		 $support_table .='<td valign="top" width="50%"><div class="p_con_02">';
		 $lss =0;
	     for($ls=$sz;$ls<$span_size;$ls++){
	     $lss ++;
	       if($lss == 21){
		      $support_table .= '<div id="platform_support2_'.$id.'" style="display:none;">';
		    }
		     $support_table .=$span_qty[$ls].'</span>';
		  }
          if($show_hide){
		    $support_table .='</div>';
		  }
		 $support_table .='</td>';
      }

      //填了链接，又需要手动填写交换器的情况
	 if(strpos($wordurl[1],"www.") && $wordurl[2]){
	  $support_table .='</tr><tr>';
	   for($td=0;$td<2;$td++){
	        $support_table .='<td valign="top" width="50%"><div class="p_con_02">';
	          for($std=2;$std<sizeof($wordurl);$std++){
	            $addspan = explode(":",$wordurl[$std]) ;
                $support_table .='<span>'.$addspan[$td].'</span>';
	          }
	        $support_table .='</td>';
        }
	 }  

	 if($show_hide){
	   $support_table .='</tr><tr><td colspan="2"><div class="sidebar_more p_con_platform_more"><a onClick="show_hide_compatible('.$id.')" id="platform_support_sh_'.$id.'" href="javascript:;">More</a></div></td>';
	 }
	 
	$support_table .='</tr></tbody></table>';
    $platform_support = $support_title.'<br/>'.$support_table;
    }
    
     $return_str = $return_str .$platform_support.'</div>' ;
        
	 return $return_str; 
	} 		
	
   //Product Description & Image  样式的板块
	function add_code_image($detail) { 
		$return_str = '';
		$detail = str_replace("；", ";",$detail);
		$detail = str_replace("：", ":",$detail); 

		$str_pos = strpos($detail, ';'); 
		if ($str_pos === false) {  
			// 没有填写内容   和  填写不规范的 情况
			//  待处理
			return '<div name="description"><div class="p_con_01" name="Product Description & Image"></div></div>'; 
		}else{
			$detail_titile = substr($detail, 0, $str_pos+1);	
			$detail = substr($detail, $str_pos+1);      
		}	

		 // 标题
		$detail_titile = str_replace(";", "",$detail_titile);
		$return_str = '<div name="description"><div class="p_con_01" name="Product Description & Image">'.$detail_titile.'</div>';
			
		if ($detail) {
			$detail_arr = explode("#",$detail) ;
			//文字部分
			$detail_span = str_replace(";", "<br>",$detail_arr[0]);         
			$detail_span = '<div class="p_con_02">'.$detail_span.'</div>';
			if (strlen($detail_arr[1]) > 1) {  
				$detail_image = explode(";",$detail_arr[1]) ;         
				$detail_num = sizeof($detail_image);          
				if ($detail_num) {         
					$image_str = '<div style="text-align: center;" class="p_con_02">';
					for ($i = 0; $i < $detail_num; $i++) {
						$img_src = zen_db_prepare_input($detail_image[$i]);
						$img_src = str_replace(" ","",$img_src);
						$image_str .= '<img src="'.$img_src.'" >';          	
					}  
					$image_str .= '</div>';                 
				}
			} 
		} 
		$return_str = $return_str .$detail_span.$image_str.'</div>' ;
		return $return_str; 
	} 	

   //Product Specs  样式的板块
   function add_code_specs($detail) { 
    $return_str = '';
    
    $detail = str_replace("；", ";",$detail);
    $detail = str_replace("：", ":",$detail); 
    $detail = str_replace("，", ",",$detail); 

    $str_pos = strpos($detail, ';'); 
    if ($str_pos === false) {  
        // 没有填写内容   和  填写不规范的 情况
        //  待处理
        return '<div name="description"><div class="p_con_01" name="Product Specs"></div></div>'; 
    }else{
        $detail_titile = substr($detail, 0, $str_pos+1);	
        $detail = substr($detail, $str_pos+1);      
    }	

     // 标题
     $detail_titile = str_replace(";", "",$detail_titile);
     $return_str = '<div name="description"><div class="p_con_01" name="Product Specs">'.$detail_titile.'</div>';    
     
     if ($detail) {
         $detail_tab = explode("||",$detail) ; 
         foreach ($detail_tab as $value) {
            if ($value) {
            	$return_str .= $this->add_code_specs_tab($value) ;
            }
         }
     }

	 $return_str .='</div>' ;
	 	 
	 return $return_str;  
	 
	} 	
	
	
	
 function add_code_specs_tab($detail) {
      $return_str = '';
      if ($detail) {
        $return_str = '<div class="p_con_02">';
 
      $str_pos = strrpos($detail, '#');   
	 if ($str_pos === false) {  }else{
	    $detail_span = substr($detail, 0, $str_pos+1);
	   	$detail = substr($detail, $str_pos+1);	
	   	
	    $detail_span = substr($detail_span,0,strlen($detail_span)-1); 
        $detail_span = str_replace("#", "<br>",$detail_span);         
	   	$return_str .= $detail_span;   	
	 }	         
	 
        $line = explode(";",$detail) ;  
        $td_qty = sizeof($line);          // 表格的  列的数量   多少个td       
        $tr = explode(",",$line[0]) ;     
        $tr_qty = sizeof($tr);             //行 数    

        $temp_arr = array();
        for ($i = 0; $i < $tr_qty; $i++) {
            for ($j = 0; $j < $td_qty; $j++) {               
                $row = explode(",",$line[$j]) ;            
                $temp_arr[$i][$j] = $row[$i];        	
            }
        }

        if($tr_qty && $td_qty){       
          
          $detail_table .='<table width="100%" cellspacing="0" cellpadding="0" class="p_con_tab_01"><tbody>';

		    for($i=0;$i<$tr_qty;$i++){
		    	if($i ==0){   $trcss ='class="p_con_04"';	
		    	              $tdcss ='bgcolor="#dedede"';	
		    	}else{        $trcss ='';	
		    	              $tdcss ='';	
		    	}	
		    	
		        $detail_table .='<tr '.$trcss.'>';	        	        
		          for($d=0;$d<$td_qty;$d++){		            
		           $detail_table .='<td '.$tdcss.'>'.$temp_arr[$i][$d].'</td>';            
		          }
		        $detail_table .='</tr>';
		    }
	    
		    
          $detail_table .='</tbody></table>';
          $return_str .= $detail_table ;
        }  
        
        $return_str .= '</div>' ;  
     } 
       
    return $return_str;        
 }	
	

 //Product Link  样式的板块
    function add_code_link($detail) { 
		$return_str = '';    
		$detail = str_replace("；", ";",$detail);
		$str_pos = strpos($detail, ';'); 
		if ($str_pos === false) {  
			// 没有填写内容   和  填写不规范的 情况
			//  待处理
			return '<div name="description"><div class="p_con_01" name="Product Link"></div></div>'; 
		}else{
			$detail_titile = substr($detail, 0, $str_pos+1);	
			$detail = substr($detail, $str_pos+1);      
		}	
		// 标题
		$detail_span = $image_str = '';
		$detail_titile = str_replace(";", "",$detail_titile);
		$return_str = '<div name="description"><div class="p_con_01" name="Product Link">'.$detail_titile.'</div>';
		if ($detail) {
			$detail_arr = explode("#",$detail) ;          
			//文字部分
			$detail_span = str_replace(";", "<br>",$detail_arr[0]);
			$detail_span = '<div class="p_con_02">'.$detail_span.'</div>';
			$detail_id = explode(";",$detail_arr[1]) ;
			$detail_num = sizeof($detail_id);          
			if ($detail_num) {
				if($detail_num == 1){
					//为1时处理的是Bulk Fiber Cables(573)/Indoor Cables(609)/Tight-Buffered Interconnect LS(1108)类产品详情页的Product Link  样式的板块
					$image_str = '<div style="text-align: center;" class="p_con_02">';
					$img_src = zen_db_prepare_input($detail_id[0]);
					$img_src = str_replace(" ","",$img_src);
					$image_str .= '<img src="'.$img_src.'"></div>';
				}else{
					if($_SESSION['languages_id'] !=1){
						switch ($_SESSION['languages_id']) {  	
							case '2': $lan_str = 'http://www.fs.com/es'; break;
							case '3': $lan_str = 'http://www.fs.com/fr'; break;
							case '4': $lan_str = 'http://www.fs.com/ru'; break;
							case '5': $lan_str = 'http://www.fs.com/de'; break;				
							case '6': $lan_str = 'http://www.feisu.com'; break;								
							default:  $lan_str = 'http://www.fs.com'; break;
						}	            
					}else{
						$lan_str = 'http://www.fs.com';
					}		  
					//zen_get_products_model
					$image_str = '<div class="p_con_recommended"><ul>';
					for ($i = 0; $i < $detail_num; $i++) {               
					$image_str .=  '<li><a href="'.$lan_str.'/products/'.(int)$detail_id[$i].'.html" target="_blank">
									<img width="150" height="150" title="" src="/images/'.zen_get_products_image($detail_id[$i]).'" > 
									<span>'.zen_get_products_name($detail_id[$i]).'</span></a>
									<b>'.zen_get_products_display_price($detail_id[$i]).'</b>
									</li>';         	
					}  
					$image_str .= '</ul></div>';        
				}   
			}
		} 
		$return_str = $return_str.$detail_span.$image_str.'</div>' ;
		return $return_str;  
		 
	} 	

	
	
	
	
 //Description & PDF Link  样式的板块
   function add_code_pdf($detail) { 

    $return_str = '';    
    $detail = str_replace("；", ";",$detail);
    $detail = str_replace("：", ":",$detail);
    
    $str_pos = strpos($detail, ';'); 
    if ($str_pos === false) {  
        return '<div name="description"><div class="p_con_01" name="Description & PDF Link"></div></div>'; 
    }    

//    $str_pos = strpos($detail, ';'); 
//    if ($str_pos === false) {  
//        return '<div name="description"><div class="p_con_01" name="Description & PDF Link"></div></div>'; 
//    }else{
//        $detail_titile = substr($detail, 0, $str_pos+1);	
//        $detail = substr($detail, $str_pos+1);      
//    }	
//
//     // 标题
//     $detail_titile = str_replace(";", "",$detail_titile);
//     $return_str = '<div name="description"><div class="p_con_01" name="Description & PDF Link">'.$detail_titile.'</div>';
//     
//     if ($detail) {
//         $temp = explode(":",$detail) ;
//         $return_str .= '<img alt="Fs pdf.png" src="/images/pdf.png"><u><strong><a href="'.zen_db_prepare_input($temp[0]).'" target="_blank">'.
//                         zen_db_prepare_input($temp[1]).'</a></strong></u>'; 
//     } 
//
//	 $return_str = $return_str.'</div>' ;
	 
	 
    
    $return_str = '<div name="description">';
    
	  $detail_arr = explode("#",$detail) ;
	  foreach ($detail_arr as $value) {
	     if ($value) {
	     
	       $str_pos = strpos($value, ';'); 
           if ($str_pos) {  
              $detail_titile = substr($value, 0, $str_pos+1);	
              $value = substr($value, $str_pos+1);   
              
              $detail_titile = str_replace(";", "",$detail_titile);
              $return_str .= '<div class="p_con_01" name="Description & PDF Link">'.$detail_titile.'</div>';
           } 
          
           if ($value) {
	           $temp = explode(":",$value) ;
               $return_str .= '<img alt="Fs pdf.png" src="/images/pdf.png"><u><strong><a href="'.zen_db_prepare_input($temp[0]).'" target="_blank">'.
                               zen_db_prepare_input($temp[1]).'</a></strong></u>'; 
           }
	     }
	  }
	 
     $return_str = $return_str.'</div>' ;
	 return $return_str;  	 
	} 	
	
	
	
	
	
	
}

?>