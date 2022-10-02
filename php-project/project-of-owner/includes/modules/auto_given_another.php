<?php

		if(!$admin_id){
					$sql= "select 	live_chat_service_id from  live_chat_service where live_chat_service_email='". $email_address ."' order by live_chat_service_id desc limit 1 ";
					$customer = $db->Execute($sql);
					if($customer->fields['live_chat_service_id']){
						$sql="select admin_id from  live_chat_assign_for_phone where customers_id='".(int)$customer->fields['live_chat_service_id']."' order by customers_id desc limit 1";
						$order = $db->Execute($sql);
						$admin_id=$order->fields['admin_id'];
					};
				};
		if(!$admin_id){
					$sql= "select customers_id from  customers_enquiry where customers_email='". $email_address ."' order by customers_id desc limit 1 ";
					$customer = $db->Execute($sql);
					if($customer->fields['customers_id']){
						$sql="select admin_id from  admin_to_enquiry where customers_id='".(int)$customer->fields['customers_id']."' order by customers_id desc limit 1";
						$order = $db->Execute($sql);
						$admin_id=$order->fields['admin_id'];
					};
				}
				if(!$admin_id){//邮箱尾缀和邮箱地址  livechat对比判断过滤是否存在类似或相同
			    $pub_mail=array('@hotmail.com',
			        '@emirates.net.ae',
			        '@amet.com.ar',
			        '@infovia.com.ar',
			        '@bigpond.net.au',
			        '@westnet.com.au',
			        '@bigpond.com',
			        '@westnet.com.all',
			        '@cairns.net.all',
			        '@gionline.com.au',
			        '@cairns.net.au',
			        '@mail.ru',
			        '@yahoo.ie',
			        '@indigo.ie',
			        '@eircom.net',
			        '@omantel.net.om',
			        '@eunet.at',
			        '@rawagegypt.com',
			        '@pro.onet.pl',
			        '@cicomputer.pl',
			        '@poczta.onet.pl',
			        '@swiszcz.com',
			        '@poczta.onet.pl',
			        '@cyber.net.pk',
			        '@sinos.net',
			        '@foetex.dk',
			        '@t-online.de',
			        '@multi-industrie.de',
			        '@chinacity.ru',
			        '@yandex.ru',
			        '@mail.ru',
			        '@wanadoo.fr',
			        '@mindspring.com',
			        '@excite.com',
			        '@club-internet.fr',
			        '@worldonline.fr',
			        '@rasa.co.cr',
			        '@yahoo.co.kr',
			        '@sotelgui.net.gn',
			        '@africaonline.co.zw',
			        '@samara.co.zw',
			        '@zol.co.zw',
			        '@mweb.co.zw',
			        '@mondis.com',
			        '@sourcesexpert.com',
			        '@rogers.ca',
			        '@sympatic.ca',
			        '@yahoo.ca',
			        '@rogers.ca',
			        '@qualitynet.net',
			        '@aviso.ci',
			        '@africaonline.co.ci',
			        '@afnet.net',
			        '@qatar.net.qa',
			        '@aol.com',
			        '@sbcglobal.net',
			        '@inntecmx.com',
			        '@nrtzero.net',
			        '@twycny.rr.com',
			        '@comcast.net',
			        '@warwick.net',
			        '@cs.com',
			        '@verizon.net',
			        '@mail.com',
			        '@mt.net.mk',
			        '@prodigy.net.mx',
			        '@citechco.net',
			        '@mongol.net',
			        '@magicnet.com',
			        '@mail.mn',
			        '@tm.net.my',
			        '@mti.gov.na',
			        '@namibnet.com',
			        '@iway.na',
			        '@be-local.com',
			        '@infoclub.com.np',
			        '@mos.com.np',
			        '@ntc.net.np',
			        '@webmail.co.za',
			        '@vodamail.co.za',
			        '@iafrica.com',
			        '@walla.com',
			        '@excite.co.jp',
			        '@candel.co.jp',
			        '@yahoo.co.jp',
			        '@caron.se',
			        '@ptt.yu',
			        '@sltnet.lk',
			        '@cicksa.com',
			        '@nesma.net.sa',
			        '@adsl.loxinfo.com',
			        '@mynet.com',
			        '@ji-net.com',
			        '@hinet.net',
			        '@seed.net.tw',
			        '@topmarkeplg.com.tw ',
			        '@pchome.com.tw',
			        '@kobimar.com',
			        '@kalianet.to',
			        '@vsnl.com',
			        '@telesal.net',
			        '@ihug.co.nz',
			        '@xtra.co.nz',
			        '@xtra.co.nz',
			        '@scs-net.org',
			        '@fastmail.fm',
			        '@pacific.net.sg',
			        '@xxx.meh.es',
			        '@terra.es',
			        '@netvigator.com',
			        '@hongkong.com',
			        '@ctimail.com',
			        '@hknet.com',
			        '@biznetvigator.com',
			        '@mail.hk.com',
			        '@itccolp.com.hk',
			        '@swe.com.hk',
			        '@spark.net.gr',
			        '@tiscali.co.uk',
			        '@ntlworld.com',
			        '@cwgsy.net',
			        '@btinternet.com',
			        '@sal.gbm.net',
			        '@netvision.net.il',
			        '@zahav.net.il',
			        '@xx.org.il',
			        '@libero.it',
			        '@hn.vnn.vn',
			        '@hcm.fpt.vn',
			        '@hcm.vnn.vn',
			        '@ndf.vsnl.net.in',
			        '@del3.vsnl.net.in',
			        '@rediff.com',
			        '@dnet.net.id',
			        '@cbn.net.id',
			        '@zamnet.zm',
                    '@msn.com',
                    '@yahoo.com',
                    '@gmail.com',
                    '@aim.com',
                    '@aol.com',
                    '@mail.com',
                    '@walla.com',
                    '@inbox.com',
                    '@126.com',
                    '@163.com',
                    '@sina.com',
                    '@21cn.com',
                    '@sohu.com',
                    '@yahoo.com.cn',
                    '@tom.com',
                    '@qq.com',
                    '@etang.com',
                    '@eyou.com',
                    '@56.com',
                    '@x.cn',
                    '@chinaren.com',
                    '@sogou.com',
                    '@citiz.com',
                    '@yahoo.de',
                                );
                $email_tail=strrchr($email_address,'@');

				 if(!in_array($email_tail,$pub_mail)){
					
					if(!$admin_id){//验证customers是否有类似邮箱
						 $email_sql='SELECT customers_id  FROM `customers` where customers_email_address like "%'.$email_tail.'" order by customers_id desc limit 1 ';
                    $email_res = $db->Execute($email_sql);
                    if($email_res->fields['customers_id']){
                        $admin_id = zen_get_customer_has_allot_to_admin($email_res->fields['customers_id']);
					};
					}
					if(!$admin_id){//验证线下客户是否有类似邮箱
						 $email_sql='SELECT admin_id  FROM `customers_offline` where customers_email_address like "%'.$email_tail.'" order by customers_id desc limit 1 ';
                    $email_res = $db->Execute($email_sql);

                        $admin_id = $email_res->fields['admin_id'];

					}
					 if(!$admin_id){//验证livechat是否有类似邮箱
                    $email_sql='SELECT live_chat_service_id  FROM live_chat_service where live_chat_service_email like "%'.$email_tail.'" order by live_chat_service_id desc limit 1 ';
                    $email_res = $db->Execute($email_sql);

						if($email_res->fields['live_chat_service_id']){
						   $sql="select admin_id from  live_chat_assign_for_phone where customers_id='".(int)$email_res->fields['live_chat_service_id']."' order by live_chat_phone_id desc limit 1";
							$order = $db->Execute($sql);
							$admin_id=$order->fields['admin_id'];
						}
                    }
                if(!$admin_id){//验证询单客户是否有类似邮箱
                   $email_sql='SELECT customers_id  FROM `customers_enquiry` where 	customers_email like "%'.$email_tail.'" order by customers_id desc limit 1 ';
                    $email_res = $db->Execute($email_sql);
                    if($email_res->fields['customers_id']){
                      $sql="select admin_id from  admin_to_enquiry where customers_id='".$email_res->fields['customers_id']."' order by admin_to_enquiry_id desc limit 1";
						$order = $db->Execute($sql);
						$admin_id=$order->fields['admin_id'];
                    };
                }
				}
				};
				//echo $admin_id;
				if($admin_id){//判断管理员是否存在
					$admin_sql="SELECT admin_name FROM admin WHERE admin_id=".$admin_id."";
					$res = $db->Execute($admin_sql);
					if(!$res->fields['admin_name']){
						$admin_id=null;
					}
				}

			/*	if(!$admin_id){//根据自动分配管理员表来自动分配
				    $auto_sql='SELECT id,admin_id FROM live_chat_admin WHERE is_beforeadmin="1" && more_num="0" && stop_auto="0"';
				    $res = $db->Execute($auto_sql);
				    if(!$res->fields['admin_id']){
						$sec_sql='SELECT id,admin_id FROM live_chat_admin WHERE is_beforeadmin="1" && stop_auto="0"';
						$sec_res=$db->Execute($sec_sql);
						if(!$sec_res->fields['admin_id']){
							$autoadmin_sql='SELECT id,admin_id FROM live_chat_admin where american_id!=1 && stop_auto="0"  order by id asc limit 1';
							$autoadmin_res = $db->Execute($autoadmin_sql);
							$admin_id=$autoadmin_res->fields['admin_id'];
							$db->Execute("UPDATE live_chat_admin set is_beforeadmin='1' where id>'".$autoadmin_res->fields['id']."' order by id asc limit 1");
							$db->Execute("UPDATE live_chat_admin set is_beforeadmin='0' where id='".$autoadmin_res->fields['id']."' order by id asc limit 1");
							$db->Execute("UPDATE live_chat_admin set more_num=more_num-1 where more_num!=0 ");
							//echo $admin_id;
						}else{
							$autoadmin_sql="SELECT id,admin_id FROM live_chat_admin where id>'".$sec_res->fields['id']."' && stop_auto='0' order by id asc limit 1";
							$autoadmin_res=$db->Execute($autoadmin_sql);
							$admin_id=$autoadmin_res->fields['admin_id'];
							$db->Execute("UPDATE live_chat_admin set is_beforeadmin='1' where id>'".$autoadmin_res->fields['id']."' && stop_auto='0' order by id asc limit 1");
							$db->Execute("UPDATE live_chat_admin set is_beforeadmin='0' where id='".$sec_res->fields['id']."' && stop_auto='0' order by id asc limit 1");
							//echo $autoadmin_sql;
						}
				    }else{
				        $admin_id=$res->fields['admin_id'];
				        $db->Execute("UPDATE live_chat_admin set is_beforeadmin='0' where id='".$res->fields['id']."' order by id asc limit 1");
				      $last_res=$db->Execute("UPDATE live_chat_admin set is_beforeadmin='1' where id>'".$res->fields['id']."' && stop_auto='0' order by id asc limit 1");
				    }
				}*/
				

		//end
?>