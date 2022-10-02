<?php require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));?>
<div class="contact_us">
  <div class="contact_banner"></div>
  <div class="contact_banner_p">
  <?php 
           $first_time=strtotime("05:00:00");//对应纽约时间上午八点
		   $morning_time = strtotime("08:00:00");// 对应纽约时间上午十一点
		   $last_time =strtotime("17:00:00");//对应纽约时间晚上八点
		   $nowtime=time();//获取西雅图时间
		   $time =date ('Y:m:d,H:i:s',$first_time);    	  
  ?> 
    <div class="banner_tit"><?php echo FS_CONTACT;?></div>

	  	    <?php 

			if($countryCode==CN){
       echo '<span class="tit01" >'.FS_CONTACT_HK.'</span> ';
		}  
		  if($countryCode==HK){
       echo '<span class="tit01" >'.FS_CONTACT_HK.'</span>';
		}  
             
		 if($countryCode==US){
				 if($nowtime>$first_time && $nowtime<$morning_time ){
				   echo '<span class="tit01" >'.FS_CONTACT_NEW_YORK.'</span>';
				 }elseif($nowtime>$morning_time && $nowtime<$last_time){
					  echo '<span class="tit01" >'.FS_CONTACT_SEATTLE.'</span>';
				 }else{
					 echo '<span class="tit01" >'.FS_CONTACT_HK .','.FS_CONTACT_CHINA.'</span>';
				 }
				 
			 
		} 
		  
		 if($countryCode==MX){
       echo '<span class="tit01" >'.FS_CONTACT_MEXICO.'</span> ';
		} 
		 if($countryCode==CA){
       echo '<span class="tit01" >'.FS_CONTACT_CANADA.'</span>';
		}
       if($countryCode==BR){
       echo '<span class="tit01" >'.FS_CONTACT_BRAZIL.'</span> ';
		} 
		if($countryCode==AR){
       echo '<span class="tit01" >'.FS_CONTACT_ARGENTINA.'</span>';
		}
		
		
      if($countryCode==GB){
       echo '<span class="tit01" >'.FS_CONTACT_LONDON.'</span> ';
		}	
      if($countryCode==FR){
       echo '<span class="tit01" >'.FS_CONTACT_FRANCE.'</span>';
		}	
     if($countryCode==NL){
       echo '<span class="tit01" >'.FS_CONTACT_NETHERLANDS.'</span>';
		}	
     if($countryCode==DE){
       echo '<span class="tit01" >'.FS_CONTACT_GERMANY.'</span>';
		}
     if($countryCode==AU){
       echo '<span class="tit01" >'.FS_CONTACT_AUSTRALIA.'</span> ';
		}	
    if($countryCode==ES){
       echo '<span class="tit01" >'.FS_CONTACT_SPAIN.'</span>';
		}
    if($countryCode==RU){
       echo '<span class="tit01" >'.FS_CONTACT_RUSSIA.'</span> ';
		}
    if($countryCode==SG){
       echo '<span class="tit01" >'.FS_CONTACT_SINGAPORE.'</span> ';
		}
	if($countryCode==TW){
       echo '<span class="tit01" >'.FS_CONTACT_TW.'</span>';
		}
     if($countryCode==IT){
       echo '<span class="tit01" >'.FS_CONTACT_ITALY.'</span>';
		}
     if($countryCode==CH){
       echo '<span class="tit01" >'.FS_CONTACT_SWITZERLAND.'</span>';
		}
     if($countryCode==DK){
       echo '<span class="tit01" >'.FS_CONTACT_DENMARK.'</span> ';
		}
     if($countryCode==NZ){
       echo '<span class="tit01" >'.FS_CONTACT_NZ.'</span>';
		}		
   if($countryCode!=SG && $countryCode!=RU && $countryCode!=ES && $countryCode!=AU && $countryCode!=DE && $countryCode!=NL && $countryCode!=FR && $countryCode!=GB && $countryCode!=BR && $countryCode!=BR && $countryCode!=AR && $countryCode!=CA && $countryCode!=MX && $countryCode!=US && $countryCode!=HK && $countryCode!=CN && $countryCode!=TW && $countryCode!=IT && $countryCode!=CH && $countryCode!=DK  && $countryCode!=NZ   ){
	   echo '<span class="tit01" >'.FS_CONTACT_GLOBL.'</span>';
   }		
		?>
       

	    <?php if($countryCode==CN){
       echo '<span class="tit02">+(852) 8176 3606</span> ';
       }
	       if($countryCode==HK){
       echo '<span class="tit02">+(852) 8176 3606</span> ';
       }

	   

        if($countryCode==US){
			if($nowtime>$first_time && $nowtime<$morning_time  ){
               echo '<span class="tit02">+1 (347) 682 5079</span>';
		     }elseif($nowtime>$morning_time && $nowtime<$last_time){
				 echo '<span class="tit02">+1 (425) 502 7191</span>' ;
			 }else{
				 echo '<span class="tit02">+027-87677765</span>' ;
			 }
			 
		}	
	
	 if($countryCode==MX){
         echo '<span class="tit02">+52 (55) 4169 2630</span> ';
		} 
	if($countryCode==CA){
         echo '<span class="tit02">+1 (647) 243 6342</span>';
		} 
	if($countryCode==BR){
         echo '<span class="tit02">+55 (11) 4349 6175</span>';
		}
		
	if($countryCode==AR){
         echo '<span class="tit02">+54 (11) 5031 9542 </span>';
		}	
		
		
	if($countryCode==GB){
         echo '<span class="tit02">+44 (020) 3287 6810</span></td>';
		}	
	if($countryCode==FR){
         echo '<span class="tit02">+33 (1) 82 884 336</span> ';
		}
    if($countryCode==NL){
         echo '<span class="tit02">+31 (20) 241 4029</span> ';
		}	
     if($countryCode==DE){
         echo '<span class="tit02">+49 (030) 2089 6762</span> ';
		}
    if($countryCode==AU){
         echo '<span class="tit02">+61 (02) 8005 1850</span></td> ';
		}
   if($countryCode==ES){
         echo '<span class="tit02">+34 (91) 123 7299</span> ';
		} 
    if($countryCode==RU){
         echo '<span class="tit02">+7 (499) 643 4876</span></td> ';
		}
    if($countryCode==SG){
         echo '<span class="tit02">+(65) 6443 7951</span> ';
		}
	if($countryCode==TW){
         echo '<span class="tit02">+886 (2) 7703 9076</span> ';
		}
	if($countryCode==IT){
         echo '<span class="tit02">+39 (02) 8295 0086</span>';
		}
     if($countryCode==CH){
         echo '<span class="tit02">+41 (43) 508 5909 </span> ';
		}
      if($countryCode==DK){
         echo '<span class="tit02">+45 7876 8321</span> ';
		}
      if($countryCode==NZ){
         echo '<span class="tit02">+64 (9) 985 3566</span>';
		}		

      if($countryCode!=SG && $countryCode!=RU && $countryCode!=ES && $countryCode!=AU && $countryCode!=DE && $countryCode!=NL && $countryCode!=FR && $countryCode!=GB && $countryCode!=BR && $countryCode!=BR && $countryCode!=AR && $countryCode!=CA && $countryCode!=MX && $countryCode!=US && $countryCode!=HK && $countryCode!=CN && $countryCode!=TW && $countryCode!=IT && $countryCode!=CH && $countryCode!=DK && $countryCode!=NZ ){
	   echo   '<span class="tit02">+1 (718) 577 1006</span>';
   }		
		?>
     
      </tr>
      
    </table>
  </div>
  <div class="contact_con">
    <div class="contact_left">
      <div class="contact_left_tit"><?php echo FS_CONTACT_LOCATIONS;?></div>
      <div class="contact_line"></div>
      <div class="left_01"><span><?php echo FS_CONTACT_NA;?></span> <?php echo FS_CONTACT_NA_ADDRESS;?><br />
        <?php echo FS_CONTACT_US;?><br />
        <?php echo FS_CONTACT_TEL;?> +1 (425) 502 7191<br />
        <?php echo FS_CONTACT_FAX;?> +1 (253) 246 7881 </div>
      <div class="left_01"><span><?php echo FS_CONTACT_LON_OFFICE;?></span> <?php echo FS_CONTACT_LON_ADDRESS;?><br />
        <?php echo FS_CONTACT_UK;?><br />
        <?php echo FS_CONTACT_TEL;?> +44 (020) 3287 6810<br />
      </div>
      <div class="left_01"><span><?php echo FS_CONTACT_APAC;?></span> <?php echo FS_CONTACT_APAC_ADDRESS;?> <br />
        <?php echo FS_CONTACT_APAC_STREET;?><br />
        <?php echo FS_CONTACT_TEL;?> +(852) 817 636 06<br />
        <?php echo FS_CONTACT_FAX;?> +(852) 817 636 06</div>
      <div class="left_01"><span><?php echo FS_CONTACT_MANU;?></span><?php echo FS_CONTACT_MANU_ADDRESS;?>
       </br></><?php echo FS_CONTACT_MANU_ROAD;?><br />
        <?php echo FS_CONTACT_TEL;?> +86 (755) 8300 3611<br />
        <?php echo FS_CONTACT_FAX;?> +86 (755) 8326 9395</div>
    </div>
    <div class="contact_right">
      <div class="contact_right01">
        <div class="contact_right01_tit"><?php echo FS_CONTACT_GLOBAL_TEL;?></div>
        <div class="contact_line"></div>
        <div class="right_01"><span><?php echo FS_CONTACT_N_AMERICA;?></span>
          <table width="100%" border="0">
            <tr>
              <td width="70%"><?php echo FS_CONTACT_US;?> <b class="right_td">(<?php echo FS_CONTACT_SEATTLE;?>)</b>  </td>
              <td>+1 (425) 502 7191</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_US;?> <b class="right_td">(<?php echo FS_CONTACT_NEW_YORK;?>)</b> </td>
              <td>+1 (347) 682 5079</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_MEXICO;?></td>
              <td>+52 (55) 4169 2630</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_CANADA;?></td>
              <td>+1 (647) 243 6342</td>
            </tr>
          </table>
        </div>
        <div class="right_01"><span><?php echo FS_CONTACT_S_AMERICA;?></span>
          <table width="100%" border="0">
            <tr>
              <td  width="70%"><?php echo FS_CONTACT_BRAZIL;?></td>
              <td>+55 (11) 4349 6175</td>
            </tr>
			<tr>
              <td  width="70%"><?php echo FS_CONTACT_ARGENTINA;?></td>
              <td>+54 (11) 5031 9542</td>
            </tr>
          </table>
        </div>
        <div class="right_01"><span><?php echo FS_CONTACT_EUROPE;?></span>
          <table width="100%" border="0">
            <tr>
              <td width="70%"><?php echo FS_CONTACT_UK;?> <b class="right_td">(<?php echo FS_CONTACT_LONDON;?>)</b> </td>
              <td>+44 (020) 3287 6810</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_FRANCE;?></td>
              <td>+33 (1) 82 884 336</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_NETHERLANDS;?></td>
              <td>+31 (20) 241 4029</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_GERMANY;?></td>
              <td>+49 (030) 2089 6762</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_SPAIN;?></td>
              <td>+34 (91) 123 7299</td>
            </tr>
			<tr>
              <td><?php echo FS_CONTACT_ITALY;?></td>
              <td>+39 (02) 8295 0086</td>
            </tr>
			
			<tr>
              <td><?php echo FS_CONTACT_SWITZERLAND;?></td>
              <td>+41 (43) 508 5909</td>
            </tr>
			<tr>
              <td><?php echo FS_CONTACT_DENMARK;?></td>
              <td>+45 7876 8321</td>
            </tr>
			
            <tr>
              <td><?php echo FS_CONTACT_RUSSIA;?></td>
              <td>+7 (499) 643 4876</td>
            </tr>
          </table>
        </div>
        <div class="right_01"><span><?php echo FS_CONTACT_ASIA;?></span>
          <table width="100%" border="0">
            <tr>
              <td  width="70%"><?php echo FS_CONTACT_SINGAPORE;?></td>
              <td>+(65) 6443 7951</td>
            </tr>
            <tr>
              <td><?php echo FS_CONTACT_HK;?> </td>
              <td>+(852) 8176 3606</td>
            </tr>
			<tr>
              <td><?php echo FS_CONTACT_TW;?> </td>
              <td>+886 (2) 7703 9076</td>
            </tr>
          </table>
        </div>
        <div class="right_01" style="border-bottom:none;"><span><?php echo FS_CONTACT_OCEANIA;?></span>
          <table width="100%" border="0">
            <tr>
              <td  width="70%"><?php echo FS_CONTACT_AUSTRALIA;?></td>
              <td>+61 (02) 8005 1850</td>
            </tr>
			<tr>
              <td  width="70%"><?php echo FS_CONTACT_NZ;?></td>
              <td>+64 (9) 985 3566</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="contact_right02">
        <div class="sedebar_contact01 "> <a target="_blank" href="http://www.fs.com/service/fs_support.html">
          <dl>
            <dt><b><?php echo FS_CONTACT_HELP;?></b><i><?php echo FS_FOOTER_CHAT_NOW;?></i></dt>
            <dd></dd>
            <div class="ccc"></div>
          </dl>
          </a> </div>
        <div class="contact_right01_tit"><?php echo FS_CONTACT_EMAIL;?></div>
        <div class="contact_line"></div>
        <dl>
          <dt><?php echo FS_CONTACT_E_SALES;?></dt>
          <dd><a href="mailto: sales@fs.com">sales@fs.com </a></dd>
          <dt><?php echo FS_CONTACT_E_SUPPORT;?></dt>
          <dd><a href="mailto: support@fs.com">support@fs.com</a></dd>
          <dt><?php echo FS_CONTACT_E_PRODUCT;?></dt>
          <dd><a href="mailto: product@fs.com">product@fs.com</a> </dd>
          <dt><?php echo FS_CONTACT_E_FINANCE;?></dt>
          <dd><a href="mailto: Finance@fs.com">Finance@fs.com</a> </dd>
          <dt><?php echo FS_CONTACT_E_JOB;?></dt>
          <dd><a href="mailto: job@fs.com">job@fs.com</a></dd>
          <dt><?php echo FS_CONTACT_E_MEDIA;?></dt>
          <dd><a href="mailto: pr@fs.com">pr@fs.com</a> </dd>
          <dt><?php echo FS_CONTACT_E_CEO;?></dt>
          <dd> <a href="mailto: daniel@fs.com">daniel@fs.com</a></dd>
        </dl>
      </div>
    </div>
  </div>
</div>
