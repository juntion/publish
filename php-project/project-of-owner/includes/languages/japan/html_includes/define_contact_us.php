<?php require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));?>

<div class="contact_us">
  <div class="contact_banner"></div>
  <div class="contact_banner_p">
    <?php 
        
           $first_time=strtotime("08:00:00");//对应纽约时间上午八点
		   $morning_time = strtotime("08:00:00");// 对应纽约时间上午十一点
		   $last_time =strtotime("17:00:00");//对应纽约时间晚上八点
		   $nowtime=time();//获取西雅图时间
		   $time =date ('Y:m:d,H:i:s',$nowtime); 
           /* $first_kindom_time=strtotime("00:00:00");
	       $last_kindom_time=strtotime("05:00:00"); */
	       $first_es_time=strtotime("06:30:00")-24*3600;
	       $last_es_time=strtotime("03:00:00");		

           $inline_tel ='<a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a>';
           $offline_tel ='<a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a>';		   
  ?>
    <div class="banner_tit"><?php echo FS_CONTACT;?></div>
    <?php 

			if($countryCode==CN){
       echo '<span class="tit01">'.FS_CONTACT_UNITED.'</span> ';
		}  
		  if($countryCode==HK){
       echo '<span class="tit01">'.FS_CONTACT_HK .'</span>';
		}  
             
		 if($countryCode==US){
					 echo '<span class="tit01">'.FS_CONTACT_UNITED.'</span>';	 
		} 
		  
		 if($countryCode==MX){
       echo '<span class="tit01">'.FS_CONTACT_MEXICO.'</span> ';
		} 
		 if($countryCode==CA){
       echo '<span class="tit01">'.FS_CONTACT_CANADA.'</span>';
		}
       if($countryCode==BR){
       echo '<span class="tit01">'.FS_CONTACT_BRAZIL.'</span> ';
		} 
		if($countryCode==AR){
       echo '<span class="tit01">'.FS_CONTACT_ARGENTINA.'</span>';
		}
		
		
      if($countryCode==GB){
       echo '<span class="tit01">'.FS_CONTACT_LONDON.'</span> ';
		}	
      if($countryCode==FR){
       echo '<span class="tit01">'.FS_CONTACT_FRANCE.'</span>';
		}	
     if($countryCode==NL){
       echo '<span class="tit01">'.FS_CONTACT_NETHERLANDS.'</span>';
		}	
     if($countryCode==DE){
       echo '<span class="tit01">'.FS_CONTACT_GERMANY.'</span>';
		}
     if($countryCode==AU){
       echo '<span class="tit01">'.FS_CONTACT_AUSTRALIA.'</span> ';
		}	
    if($countryCode==ES){
       echo '<span class="tit01">'.FS_CONTACT_SPAIN.'</span>';
		}
    if($countryCode==RU){
       echo '<span class="tit01">'.FS_CONTACT_RUSSIA.'</span> ';
		}
    if($countryCode==SG){
       echo '<span class="tit01">'.FS_CONTACT_SINGAPORE.'</span> ';
		}
	if($countryCode==TW){
       echo '<span class="tit01">'.FS_CONTACT_TW.'</span>';
		}
     if($countryCode==IT){
       echo '<span class="tit01">'.FS_CONTACT_ITALY.'</span>';
		}
     if($countryCode==CH){
       echo '<span class="tit01">'.FS_CONTACT_SWITZERLAND.'</span>';
		}
     if($countryCode==DK){
       echo '<span class="tit01">'.FS_CONTACT_DENMARK.'</span> ';
		}
     if($countryCode==NZ){
       echo '<span class="tit01">'.FS_CONTACT_NZ.'</span>';
		}		
   if($countryCode!=SG && $countryCode!=RU && $countryCode!=ES && $countryCode!=AU && $countryCode!=DE && $countryCode!=NL && $countryCode!=FR && $countryCode!=GB && $countryCode!=BR && $countryCode!=BR && $countryCode!=AR && $countryCode!=CA && $countryCode!=MX && $countryCode!=US && $countryCode!=HK && $countryCode!=CN && $countryCode!=TW && $countryCode!=IT && $countryCode!=CH && $countryCode!=DK  && $countryCode!=NZ   ){
	   echo '<span class="tit01">'.FS_CONTACT_GLOBL.'</span>';
   }		
		?>
    </tr>
    <tr>
      <?php 
	   if($countryCode==HK){
             echo '<span class="tit02"><a href="tel:+(852) 8176 3606">+(852) 8176 3606</a></span> ';
       }
        
		if($countryCode==CN){
				 echo '<span class="tit02"><a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a></span>' ;
			 
		}
	   

        if($countryCode==US){
			if($nowtime>$first_time && $nowtime<$last_time ){
               echo '<span class="tit02"><a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a></span>';
		     }else{
				 echo '<span class="tit02"><a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a></span>' ;
			 }
			 
		}	
	
	 if($countryCode==MX){
         echo '<span class="tit02"><a href="tel:+52 (55) 4169 2630">+52 (55) 4169 2630</a></span> ';
		} 
	if($countryCode==CA){
         echo '<span class="tit02"><a href="tel:+1 (647) 243 6342">+1 (647) 243 6342</a></span>';
		} 
	if($countryCode==BR){
         echo '<span class="tit02"><a href="tel:+55 (11) 4349 6175">+55 (11) 4349 6175</a></span>';
		}
		
	if($countryCode==AR){
         echo '<span class="tit02"><a href="tel:+54 (11) 5031 9542">+54 (11) 5031 9542</a></span>';
		}	
		
		
	if($countryCode==GB){
             echo '<span class="tit02"><a href="tel:+44 (020) 3287 6810">+44 (020) 3287 6810</a></span></td>';
		}	
	if($countryCode==FR){
         echo '<span class="tit02"><a href="tel:+33 (1) 82 884 336">+33 (1) 82 884 336</a></span> ';
		}
    if($countryCode==NL){
         echo '<span class="tit02"><a href="tel:+31 (20) 241 4029">+31 (20) 241 4029</a></span> ';
		}	
     if($countryCode==DE){
         echo '<span class="tit02"><a href="tel:+49 8165 9904326">+49 8165 9904326</a></span> ';
		}
    if($countryCode==AU){
		if($nowtime>$first_es_time && $nowtime<$last_es_time){
         echo '<span class="tit02"><a href="tel:+61 (02) 8005 1850">+61 (02) 8005 1850</a></span></td> ';
		}else{
	     echo '<span class="tit02"><a href="tel:+61 (02) 8005 1850">+61 (02) 8005 1850</a></span></td> ';
		}
	}
   if($countryCode==ES){
         echo '<span class="tit02"><a href="tel:+34 (91) 123 7299">+34 (91) 123 7299</a></span> ';
		} 
    if($countryCode==RU){
         echo '<span class="tit02"><a href="tel:+7 (499) 643 4876">+7 (499) 643 4876</a></span> ';
		}
    if($countryCode==SG){
         echo '<span class="tit02"><a href="tel:+(65) 6443 7951">+(65) 6443 7951</a></span> ';
		}
	if($countryCode==TW){
         echo '<span class="tit02"><a href="tel:+886 (2) 7703 9076">+886 (2) 7703 9076</a></span> ';
		}
	if($countryCode==IT){
         echo '<span class="tit02"><a href="tel:+39 (02) 8295 0086">+39 (02) 8295 0086</a></span>';
		}
     if($countryCode==CH){
         echo '<span class="tit02"><a href="tel:+41 (43) 508 5909">+41 (43) 508 5909</a></span> ';
		}
      if($countryCode==DK){
         echo '<span class="tit02"><a href="tel:+45 7876 8321">+45 7876 8321</a></span> ';
		}
      if($countryCode==NZ){
         echo '<span class="tit02"><a href="tel:+64 (9) 985 3566">+64 (9) 985 3566</a></span>';
		}		

      if($countryCode!=SG && $countryCode!=RU && $countryCode!=ES && $countryCode!=AU && $countryCode!=DE && $countryCode!=NL && $countryCode!=FR && $countryCode!=GB && $countryCode!=BR && $countryCode!=BR && $countryCode!=AR && $countryCode!=CA && $countryCode!=MX && $countryCode!=US && $countryCode!=HK && $countryCode!=CN && $countryCode!=TW && $countryCode!=IT && $countryCode!=CH && $countryCode!=DK && $countryCode!=NZ ){
	   echo   '<span class="tit02"><a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a></span> ';
   }		
		?>
  </div>
  <div class="contact_con">
    <div class="contact_left">
      <div class="contact_left_tit"><?php echo FS_CONTACT_LOCATIONS;?></div>
      <div class="contact_line"></div>
      <div class="left_01"> <span><?php echo FS_CONTACT_NA;?></span> <?php echo FS_CONTACT_NA_ADDRESS;?><br />
        <?php echo FS_CONTACT_UNITED;?><br />
        <?php echo FS_CONTACT_TEL;?> <a href="tel:+1 (253) 277 3058">+1 (253) 277 3058</a><br />
       <!-- <?php //echo FS_CONTACT_FAX;?> +1 (253) 246 7881--></div>
	   
	   <div class="left_01"> <span><?php echo FS_CONTACT_GE;?></span> <?php echo FS_CONTACT_GE_ADDRESS;?><br />
        <?php echo FS_CONTACT_GEA;?><br />
        <?php echo FS_CONTACT_TEL;?> <a href="tel:+49 8165 9904326">+49 8165 9904326
       </a><br /></div>
      <div class="left_01"><span><?php echo FS_CONTACT_LON_OFFICE;?></span> <?php echo FS_CONTACT_LON_ADDRESS;?><br />
        <?php echo FS_CONTACT_UK;?><br />
        <?php echo FS_CONTACT_TEL;?><a href="tel:+44 (020) 3287 6810"> +44 (020) 3287 6810</a><br />
      </div>
      <div class="left_01"><span><?php echo FS_CONTACT_APAC;?></span> <?php echo FS_CONTACT_APAC_ADDRESS;?> <br />
        <?php echo FS_CONTACT_APAC_STREET;?><br />
        <?php echo FS_CONTACT_TEL;?> <a href="tel:+(852) 8176 3606">+(852) 8176 3606</a><br />
      <!--  <?php //echo FS_CONTACT_FAX;?> +(852) 817 636 06--></div>
      <div class="left_01" style="display:none"><span><?php echo FS_CONTACT_MANU;?></span><?php echo FS_CONTACT_MANU_ADDRESS;?> </br>
        </><?php echo FS_CONTACT_MANU_ROAD;?><br />
        <?php echo FS_CONTACT_TEL;?> <a href="tel:+86 (755) 8300 3611">+86 (755) 8300 3611</a><br />
        <?php echo FS_CONTACT_FAX;?> +86 (755) 8326 9395</div>
    </div>
    <div class="contact_right">
      <div class="contact_right01">
        <div class="contact_right01_tit"><?php echo FS_CONTACT_GLOBAL_TEL;?></div>
        <div class="contact_line"></div>
        <div class="right_01"> <span> <img src="/images/telephone.png"><?php echo FS_CONTACT_N_AMERICA;?><i class="arrow_top"></i></span>
          <div class="contact_phone1 contact_show" style="display:block">
            <table width="100%" border="0">
              <!--<tr>
              <td width="70%"><?php //echo FS_CONTACT_UNITED;?> <b class="right_td">(<?php //echo FS_CONTACT_SEATTLE;?>)</b>  </td>
              <td>+1 (425) 502 7191</td>
            </tr>
            <tr>
              <td><?php //echo FS_CONTACT_UNITED;?> <b class="right_td">(<?php //echo FS_CONTACT_NEW_YORK;?>)</b> </td>
              <td>+1 (347) 682 5079</td>
            </tr>-->
              <tr>
                <td width="70%"><?php echo FS_CONTACT_UNITED;?></td>
                <td><?php
              if($countryCode==CN) {
				  echo  $offline_tel;
			  }else{
				  if($nowtime>$first_time && $nowtime<$last_time ){
				   echo  $inline_tel;
			  }else{
				  echo  $offline_tel;
			  }	
				  
			  }  
              		  
			 ?></td>
              </tr>
              <tr>
                <td width="70%"><?php echo FS_CONTACT_MEXICO;?></td>
                <td><a href="tel:+52 (55) 4169 2630">+52 (55) 4169 2630</a></td>
              </tr>
              <tr>
                <td width="70%"><?php echo FS_CONTACT_CANADA;?></td>
                <td><a href="tel:+1 (647) 243 6342">+1 (647) 243 6342</a></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="right_01"><span> <img src="/images/telephone.png"><?php echo FS_CONTACT_S_AMERICA;?><i class="arrow_bottom"></i></span>
          <div class="contact_phone2 contact_show" style="display:none">
            <table width="100%" border="0">
              <tr>
                <td  width="70%"><?php echo FS_CONTACT_BRAZIL;?></td>
                <td><a href="tel:+55 (11) 4349 6175">+55 (11) 4349 6175</a></td>
              </tr>
              <tr>
                <td  width="70%"><?php echo FS_CONTACT_ARGENTINA;?></td>
                <td><a href="tel:+54 (11) 5031 9542">+54 (11) 5031 9542</a></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="right_01"><span><img src="/images/telephone.png"><?php echo FS_CONTACT_EUROPE;?><i class="arrow_bottom"></i></span>
          <div class="contact_phone3 contact_show" style="display:none">
            <table width="100%" border="0">
              <tr>
                <td width="70%"><?php echo FS_CONTACT_UK;?> <b class="right_td">(<?php echo FS_CONTACT_LONDON;?>)</b></td>
                <td><a href="tel:+44 (020) 3287 6810">+44 (020) 3287 6810</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_FRANCE;?></td>
                <td><a href="tel:+33 (1) 82 884 336">+33 (1) 82 884 336</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_NETHERLANDS;?></td>
                <td><a href="tel:+31 (20) 241 4029">+31 (20) 241 4029</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_GERMANY;?></td>
                <td><a href="tel:+49 8165 9904326">+49 8165 9904326</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_SPAIN;?></td>
                <td><a href="tel:+34 (91) 123 7299">+34 (91) 123 7299</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_ITALY;?></td>
                <td><a href="tel:+39 (02) 8295 0086">+39 (02) 8295 0086</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_SWITZERLAND;?></td>
                <td><a href="tel:+41 (43) 508 5909">+41 (43) 508 5909</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_DENMARK;?></td>
                <td><a href="tel:+45 7876 8321">+45 7876 8321</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_RUSSIA;?></td>
                <td><a href="tel:+7 (499) 643 4876">+7 (499) 643 4876</a></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="right_01"><span><img src="/images/telephone.png"><?php echo FS_CONTACT_ASIA;?><i class="arrow_bottom"></i></span>
          <div class="contact_phone4 contact_show" style="display:none">
            <table width="100%" border="0">
              <tr>
                <td  width="70%"><?php echo FS_CONTACT_SINGAPORE;?></td>
                <td><a href="tel:+(65) 6443 7951">+(65) 6443 7951</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_HK;?></td>
                <td><a href="tel:+(852) 8176 3606">+(852) 8176 3606</a></td>
              </tr>
              <tr>
                <td><?php echo FS_CONTACT_TW;?></td>
                <td><a href="tel:+886 (2) 7703 9076">+886 (2) 7703 9076</a></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="right_01"> <span><img src="/images/telephone.png"><?php echo FS_CONTACT_OCEANIA;?><i class="arrow_bottom"></i></span>
          <div class="contact_phone5 contact_show" style="display:none">
            <table width="100%" border="0">
              <tr>
                <td  width="70%"><?php echo FS_CONTACT_AUSTRALIA;?></td>
                <td><a href="tel:+61 (02) 8005 1850">+61 (02) 8005 1850</a></td>
              </tr>
              <tr>
                <td  width="70%"><?php echo FS_CONTACT_NZ;?></td>
                <td><a href="tel:+64 (9) 985 3566">+64 (9) 985 3566</a></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="contact_right02">
        <div class="sedebar_contact01 "> <a target="_blank" href="http://www.fs.com/service/fs_support.html">
          <dl>
            <dt><b><?php echo FS_CONTACT_HELP;?></b><i><?php echo FS_CONTACT_CHAT;?></i></dt>
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
          <dd><a href="mailto: Tech@fs.com">Tech@fs.com</a></dd>
          <dt><?php echo FS_CONTACT_E_SER;?></dt>
          <dd> <a href="mailto: daniel@fs.com">service.us@fs.com</a></dd>
          <dt><?php echo FS_CONTACT_E_JOB;?></dt>
          <dd><a href="mailto: job@fs.com">job@fs.com</a></dd>
          <dt><?php echo FS_CONTACT_E_CEO;?></dt>
          <dd> <a href="mailto: daniel@fs.com">daniel@fs.com</a></dd>
          <div class="email_list" style="display:none">
            <dt><?php echo FS_CONTACT_E_PRODUCT;?></dt>
            <dd><a href="mailto: product@fs.com">product@fs.com</a> </dd>
            <dt><?php echo FS_CONTACT_E_FINANCE;?></dt>
            <dd><a href="mailto: Finance@fs.com">Finance@fs.com</a> </dd>
            <dt><?php echo FS_CONTACT_E_MEDIA;?></dt>
            <dd><a href="mailto: pr@fs.com">pr@fs.com</a> </dd>
          </div>
          <span class="more_email" onclick="$('.email_list').toggle()"><?php echo MORE_EAMIL;?><i class="arrow_bottom"></i></span>
        </dl>
      </div>
    </div>
  </div>
</div>
<script>
	$('.right_01 span').click(function(){
		if($(this).hasClass('active')){
			$(this).siblings('.contact_show').hide();
			$(this).removeClass('active');
			$(this).find('i').removeClass('arrow_top');
			$(this).find('i').addClass('arrow_bottom');
		}else{
			$(this).siblings('.contact_show').show();
			$(this).addClass('active');
			$(this).find('i').removeClass('arrow_bottom');
			$(this).find('i').addClass('arrow_top');
		}
		$(this).parent().siblings('.right_01').find('.contact_show').hide();
		$(this).parent().siblings('.right_01').find('span').find('i').removeClass('arrow_top').addClass('arrow_bottom');
		$(this).parent().siblings('.right_01').find('span').removeClass();
	})
	
	 $('.more_email').click(function(){
    if($(this).hasClass('active')){
        $(this).find('i').css('background-position-y','-728px');
        $(this).removeClass('active');
    }else{
         $(this).find('i').css('background-position-y','-748px');
        $(this).addClass('active');
    }
})
</script>