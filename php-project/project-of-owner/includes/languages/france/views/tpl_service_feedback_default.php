<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/includes/templates/fiberstore/css/sweetalert.css" media="all" type="text/css" rel="stylesheet">
<script src="/includes/templates/fiberstore/jscript/jquery.js" type="text/javascript"></script>
<script src="/includes/templates/fiberstore/jscript/sweetalert.min.js" type="text/javascript"></script>
<title>无标题文档</title>
<script type="text/javascript">
function linkMenu(n){
	document.getElementById('link'+n).className="link"+n+"_o";
	document.getElementById('title'+n).className="left_bar_over";
	document.getElementById('divs'+n).style.display="block";
}
function showDiv(n){
	for(i=1; i<=7; i++){
		var title=document.getElementById('title'+i);
		var divs=document.getElementById('divs'+i);
		title.className=i==n?"left_bar_over":"left_bar_out";
		divs.style.display=i==n?"block":"none";
	}
}
</script>
<style type="text/css">
body { font-family: 'Open Sans', Arial, Helvetica, sans-serif; font-style: normal; font-weight:400%; color: #232323; font-size: 13px; }
.feedback { z-index: 5; padding: 0; min-height: 48px; height: 65px; width:100%; border-bottom: 1px solid #cbcbcb; background-color: #fff; position: relative; }
.feedback_logo { width:600px; margin: 0 auto; }
.feedback_bg { background: #f4f4f4; overflow: auto; }
.feedback_con { width:600px; margin: 0 auto; padding:30px 0 0 0; color: #555; }
.feedback_con .top { min-width:530px; }
div.top { margin: 0 auto; padding: 0; height: 46px; border-bottom: 1px solid #ccc; }
div.content { margin: 0 auto; padding: 10px 30px; border: 1px solid #ccc; border-top: none; height: auto; background: #fff; }
.left_bar_out { background: #DFEBED; cursor: pointer; height: 44px; line-height: 46px; float: left; width:298px;text-align: center; font-size: 14px; color: #232323; border: 1px solid #DFEBED;}
.tip_over, .left_bar_over { background: #fff; color: #232323; cursor: pointer; height: 46px; line-height: 46px; float: left; width:298px; text-align: center; border: 1px solid #ccc; border-bottom: none; border-top-left-radius: 3px; border-top-right-radius: 3px; font-size: 14px; }
.tip_out { background: #DFEBED; cursor: pointer; float: left; height: 46px; width:300px; text-align: center; line-height: 48px; font-size: 14px; color: #616265; }
.content em, .content span { display: block; height: 15px; font-size: 25px; overflow: hidden; position: relative; margin-left: 5px; }
.content em { margin-top: -17px; color: #da2e2e; font-style: normal; }
.content span { margin-top: -13px; color: white; }
.feedback_tit { font-size: 20px; line-height:30px; color: #232323; font-weight: normal; }
.feedback_titcon { font-size: 14px; color: #555; padding: 16px 0 25px 0; }
.feedback_con a { color: #0070BC; text-decoration: none; }
.feedback_con a:hover { color: #0070BC; text-decoration: underline; }
.Pro_feedback { margin: 10px 0; }
.Pro_feedback p { padding-bottom:15px; }
.Pro_feedback_tit { font-size: 14px; line-height: 24px; }
.Pro_feedback table { text-align: center; }
.Pro_feedback td { border: 1px solid #ccc; background-color: #fff; }
.Pro_feedback td:hover { background: #f4f4f4; border: 1px solid #D92F2F; }
.position_nps_0 { padding-left: 20px; float: left; }
.position_nps_10 { padding-right: 20px; float: right; }
.position_nps_0, .position_nps_10 { font-size: 12px; color: #616265; white-space: nowrap; }
.Pro_feedback_con, .Pro_feedback_con p { padding-top:10px; }
.Pro_feedback_con textarea { height: 100px; font-family:'Open Sans', Arial, Helvetica, sans-serif; width:100%; }
.Pro_feedback_con p { padding-bottom:10px; }
.Pro_feedback_con input { width:100%; font-family:'Open Sans', Arial, Helvetica, sans-serif; height: 38px; border:1px solid #dedede; text-indent:10px;}
.submit { float: right; margin: 20px 0 0px 0; }
.submit button { color: #FFF; letter-spacing: normal; word-spacing: normal; text-transform: none; text-indent: 0px; text-shadow: none; -webkit-writing-mode: horizontal-tb; }
.notice { margin: 0 auto; padding: 20px 0 20px 0; line-height: 24px; font-size: 13px; }
.description1, .description2 { padding-top:6px; padding-left:210px; }
.demo_2{ margin-top:20px;}
.button_10{ min-width:80px;}
@media(max-width:1220px){.content{width: auto;}
}

@media (max-width:960px){
.feedback_logo, .feedback_con{ width:initial; margin:0;}
.feedback_con .top{ min-width:initial; display:block;}
.feedback_con{ padding:16px 10px 25px 10px;}
.tip_out,.tip_over, .left_bar_over,.left_bar_out{ border:0; width:50%; height:initial; line-height:20px; padding:13px 0; font-size:13px;}
div.top{ border:0; height:46px; overflow:hidden;}
div.content{ border:0;}
.write_review_from{ clear:both;}
	}
.write_review_increase_btn {margin-top:0;}	
</style>
</head>
<body style="background:#f4f4f4; visibility: visible; margin:0; padding:0;">
<div class="feedback">
  <div class="feedback_logo"><a href="http://www.fs.com<?php echo $code;?>"><img src="/images/logo_new_fs.gif" width="190" height="64" / class="aaa"></a></div>
</div>
<div class="feedback_bg">
<div class="feedback_con">
  <div class="feedback_tit"><?php echo FS_FEEDBACK_YOUR;?></div>
  <div class="feedback_titcon"><?php echo FS_FEEDBACK_THIS;?> <a href="https://www.fs.com<?php echo $code;?>/service/fs_support.html" target="_blank"><?php echo FS_FEEDBACK_CONTACT;?></a>.</div>
  <div class="top">
    <div id="title1" onClick="showDiv(1)" class="tip_over top_item"><?php echo FS_FEEDBACK_PRODUCTS;?></div>
    <div id="title2" onClick="showDiv(2)" class="tip_out top_item"><?php echo FS_FEEDBACK_WEBSITE;?></div>
  </div>
  <div class="content">
    <div id="divs1">
      <form action="" method="post" id="products_form" enctype="multipart/form-data">
        <div class="write_review_from">
          <div class="Pro_feedback">
            <p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_WEBSITE;?></p>
            <!-- js打分 -->
            <div id="xzw_starSys">
              <div id="xzw_starBox">
                <ul class="star" id="star1">
                  <li><a href="javascript:void(0)" title="1" class="one-star">1</a></li>
                  <li><a href="javascript:void(0)" title="2" class="two-stars">2</a></li>
                  <li><a href="javascript:void(0)" title="3" class="three-stars">3</a></li>
                  <li><a href="javascript:void(0)" title="4" class="four-stars">4</a></li>
                  <li><a href="javascript:void(0)" title="5" class="five-stars">5</a></li>
                </ul>
                <input type="hidden"  name="rating" id="rating" value="">
                <div class="current-rating" id="showb1" ></div>
              </div>
              <!--评价文字-->
              <div class="description1"></div>
            </div>
          </div>
        </div>
        <div class="Pro_feedback_con">
          <p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_SHARE;?>:</p>
          <textarea id="products_content" name="content" cols="30" rows="3"></textarea>
		 
         	 <!-- bof 上传评论图片  -->
	<div class="write_review_from" >
	<p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_IMAGE;?></p>
		<div id="review_img_show">
			<div class="write_review_increase_img" id="display1" style="display:none">
				<img id="imghead1" src="" title=" " width="100" height="100" border="0">
				<span onclick="cls(1)"><i></i></span>
			</div>
		</div>
		<div class="write_review_increase_btn"  id="addinput">
			<div id="upload1"><i><?php echo FS_FEEDBACK_ATTACH;?> +</i><input type="file" onchange="previewImage1(this,this.id)" id="1" name="reviews_img[]"/></div> 
		</div>
		<!-- EOF 上传评论图片  -->
	</div>
		 <p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_EMAIL;?>:</p>
          <input id="products_email" name="email" type="text" />
          <input name="feedback_type" value="0" type="hidden">
          <div class="demo_2">
            <button class="button_10"><?php echo FS_FEEDBACK_SUBMIT;?></button>
          </div>
        </div>
      </form>
    </div>
    <div style="display:none;" id="divs2">
      <form action="" method="post" id="website_form" enctype="multipart/form-data">
        <div class="write_review_from">
          <div class="Pro_feedback">
            <p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_FS;?></p>
            <!-- js打分 -->
            <div id="xzw_starSys">
              <div id="xzw_starBox">
                <ul class="star" id="star2">
                  <li><a href="javascript:void(0)" title="1" class="one-star">1</a></li>
                  <li><a href="javascript:void(0)" title="2" class="two-stars">2</a></li>
                  <li><a href="javascript:void(0)" title="3" class="three-stars">3</a></li>
                  <li><a href="javascript:void(0)" title="4" class="four-stars">4</a></li>
                  <li><a href="javascript:void(0)" title="5" class="five-stars">5</a></li>
                </ul>
                <input type="hidden"  name="rating" id="website_rating" value="">
                <div class="current-rating" id="showb2" ></div>
              </div>
              <!--评价文字-->
              <div class="description2"></div>
            </div>
          </div>
        </div>
        <div class="Pro_feedback_con">
          <p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_SHARE;?>:</p>
          <textarea id="website_content" name="content" cols="" rows=""></textarea>
		  
          <div class="write_review_from" >
		  <p class="Pro_feedback_tit" ><?php echo FS_FEEDBACK_IMAGE;?></p>
			<div id="review_img_show">
				<div class="write_review_increase_img" id="display2" style="display:none">
					<img id="imghead2" src="" title=" " width="100" height="100" border="0">
					<span onclick="cls(2)"><i></i></span>
				</div>
			</div>
			<div class="write_review_increase_btn"  id="addinput">
				<div id="upload2"><i><?php echo FS_FEEDBACK_ATTACH;?> +</i><input type="file" onchange="previewImage2(this,this.id)" id="2" name="reviews_img[]"/></div> 
			</div>
			<!-- EOF 上传评论图片  -->
			
		</div>
		  
		  <p class="Pro_feedback_tit"><?php echo FS_FEEDBACK_EMAIL;?>:</p>
          <input id="website_email" name="email" type="text" />
          <input name="feedback_type" value="1" type="hidden">
          <div class="demo_2">
            <button class="button_10"><?php echo FS_FEEDBACK_SUBMIT;?></button>
          </div>
        </div>
      </form>
    </div>
    <div>&nbsp;</div>
  </div>
  <div class="notice"> <?php echo FS_FEEDBACK_NOTICE;?>.</div>
</div>
<script type="text/javascript">
function linkMenu(n){
	document.getElementById('link'+n).className="link"+n+"_o";
	document.getElementById('title'+n).className="left_bar_over";
	document.getElementById('divs'+n).style.display="block";
}
$(function(){
	$("#title2").click(function(){
	   
	    $("#divs1").attr("style",'display:none')
	})

	$("#title1").click(function(){
	 
	   $("#divs2").attr("style",'display:none')
	})
	
	
})

function showDiv(n){
	for(i=1; i<=7; i++){
		var title=document.getElementById('title'+i);
		var divs=document.getElementById('divs'+i);
		title.className=i==n?"left_bar_over":"left_bar_out";
		divs.style.display=i==n?"block":"none";
	}
}

$(document).ready(function(){
    var stepW = 40;
    var description = new Array("<?php echo FS_FEEDBACK_POOR;?>","<?php echo FS_FEEDBACK_FAIR;?>","<?php echo FS_FEEDBACK_AVERAGE?>","<?php echo FS_FEEDBACK_GOOD;?>","<?php echo FS_FEEDBACK_EXCELLENT;?>");
    var stars = $("#star1 > li");
    var descriptionTemp;
    $("#showb1").css("width",0);
	
    stars.each(function(i){
        $(stars[i]).click(function(e){
            var n = i+1;
            $("#rating").val(n);
            $("#showb1").css({"width":stepW*n});
			
            descriptionTemp = description[i];
            $(this).find('a').blur();
            return stopDefault(e);
            return descriptionTemp;
            
        });
    });
    stars.each(function(i){
        $(stars[i]).hover(
            function(){
                $(".description1").text(description[i]);
            },
            function(){
                if(descriptionTemp != null)
                    $(".description1").text(descriptionTemp);
                else 
                    $(".description1").text(" ");
            }
        );
    });
});


$(function(){
    var stepW = 40;
    var description = new Array("<?php echo FS_FEEDBACK_POOR;?>","<?php echo FS_FEEDBACK_FAIR;?>","<?php echo FS_FEEDBACK_AVERAGE?>","<?php echo FS_FEEDBACK_GOOD;?>","<?php echo FS_FEEDBACK_EXCELLENT;?>");
    var stars = $("#star2 > li");
    var descriptionTemp;
    $("#showb2").css("width",0);
	
	
    stars.each(function(i){
        $(stars[i]).click(function(e){
            var s = i+1;
            $("#website_rating").val(s);
            $("#showb2").css({"width":stepW*s});
			var width =$("#showb2").attr("width");
			
            descriptionTemp = description[i];
            $(this).find('a').blur();
            return stopDefault(e);
            return descriptionTemp;
            
        });
    });
    stars.each(function(i){
        $(stars[i]).hover(
            function(){
                $(".description2").text(description[i]);
            },
            function(){
                if(descriptionTemp != null)
                    $(".description2").text(descriptionTemp);
                else 
                    $(".description2").text(" ");
            }
        );
    });
});
function stopDefault(e){
    if(e && e.preventDefault)
           e.preventDefault();
    else
           window.event.returnValue = false;
    return false;
};

$(function() {
	
	$("#products_form").submit(function() {
		var rating =$("#rating").val();
			var content=$("#products_content").val();
			var email =$("#products_email").val();
			if(rating!="" && content!="" && email!=""){
				 swal("Success!", "", "success");
			}else{
			  return false;
			} 
		var r =$("#cont").attr('value');
		if(r==1){
		  $("#cont").click(function(){
		  window.location.href="<?php echo FS_FEEDBACK_HREF;?>";
		  });
		}
		
	});
	
	$("#website_form").submit(function() {
		    var rating =$("#website_rating").val();
			var content=$("#website_content").val();
			var email =$("#website_email").val();
			if(rating!="" && content!="" && email!=""){
				swal("Success!", "", "success");
			}else{
				return false;
			}
		var r =$("#cont").attr('value');
		if(r==1){
		  $("#cont").click(function(){
		  window.location.href="<?php echo FS_FEEDBACK_HREF;?>";
		  });
		}
		
	});
	
	
	
		$("#products_form").submit(function(){
			var rating =$("#rating").val();
			var content=$("#products_content").val();
			var email =$("#products_email").val();
			 if(rating!="" && content!="" && email!=""){
				 return true;
			 }else{
			return false;
			 } 
		});
		
	
     
	
		$("#website_form").submit(function(){
			var rating =$("#website_rating").val();
			var content=$("#website_content").val();
			var email =$("#website_email").val();
			 if(rating!="" && content!="" && email!=""){
				 return true;
			 }else{
			return false;
			 } 
		});
		
	
	

	

	
});


function previewImage1(file,id){
  var MAXWIDTH  = 120; 
  var MAXHEIGHT = 120;
  var div = document.getElementById('preview');
  var img = new Array(),$i=0,$len = 0;
	$('input[name^="reviews_img"]').each(function(){
		img[$i++] = $(this).val();
	});
   $len = img.length;
  var newID = parseInt(id) + 1;
  var str = '<div id="upload'+newID+'"><i>Attach Image +</i><input type="file" onchange="previewImage1(this,this.id)" id="'+newID+'"/ name="reviews_img[]"></div>';
  var  newImg = '<div class="write_review_increase_img" style="display:none" id="display'+newID+'"><img id="imghead'+newID+'" src="" title=" " width="100" height="100" border="0"><span onclick="cls('+newID+')"><i></i></span></div>';
  var  imgsrc =  $("#imghead"+id).attr('src');
  if($len <5){
	  $("#review_img_show").append(newImg);
	  $("#addinput").append(str);
	  }
  // alert(imgsrc);
  if(id > 5 || ($len ==2 && id == 3 ) || imgsrc.length > 0){
	  selectID = newID;
 }else{
	 selectID = id;
	 }
  //alert(selectID);
  if (file.files && file.files[0]){
      var img = document.getElementById('imghead'+selectID);
      img.onload = function(){
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        img.width  =  rect.width;
        img.height =  rect.height;
        img.style.marginTop = rect.top+'px';
      }
      var reader = new FileReader();
      reader.onload = function(evt){img.src = evt.target.result;}
      reader.readAsDataURL(file.files[0]);
  }else {
    var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
    file.select();
    var src = document.selection.createRange().text;
    div.innerHTML = '<img id=imghead >';
    var img = document.getElementById('imghead');
    img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
  }
  //alert(selectID);
  $("#display"+selectID).show();
  if($len ==5){
	  $("#addinput").hide();
   }
}

function previewImage2(file,id){
  var MAXWIDTH  = 120; 
  var MAXHEIGHT = 120;
  var div = document.getElementById('preview');
  var img = new Array(),$i=0,$len = 0;
	$('input[name^="reviews_img"]').each(function(){
		img[$i++] = $(this).val();
	});
   $len = img.length;
  var newID = parseInt(id) + 1;
  var str = '<div id="upload'+newID+'"><i>Attach Image +</i><input type="file" onchange="previewImage2(this,this.id)" id="'+newID+'"/ name="reviews_img[]"></div>';
  var  newImg = '<div class="write_review_increase_img" style="display:none" id="display'+newID+'"><img id="imghead'+newID+'" src="" title=" " width="100" height="100" border="0"><span onclick="cls('+newID+')"><i></i></span></div>';
  var  imgsrc =  $("#imghead"+id).attr('src');
  if($len <5){
	  $("#review_img_show").append(newImg);
	  $("#addinput").append(str);
	  }
  // alert(imgsrc);
  if(id > 5 || ($len ==2 && id == 3 ) || imgsrc.length > 0){
	  selectID = newID;
 }else{
	 selectID = id;
	 }
  //alert(id);
  if (file.files && file.files[0]){
      var img = document.getElementById('imghead'+selectID);
      img.onload = function(){
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        img.width  =  rect.width;
        img.height =  rect.height;
        img.style.marginTop = rect.top+'px';
      }
      var reader = new FileReader();
      reader.onload = function(evt){img.src = evt.target.result;}
      reader.readAsDataURL(file.files[0]);
  }else {
    var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
    file.select();
    var src = document.selection.createRange().text;
    div.innerHTML = '<img id=imghead >';
    var img = document.getElementById('imghead');
    img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
  }
  //alert(selectID);
  $("#display"+selectID).show();
  if($len ==5){
	  $("#addinput").hide();
   }
}

//移除上传的图片
function cls(id){ 
	  var img = new Array(),$i=0,$len = 0;
		$('input[name^="reviews_img"]').each(function(){
			img[$i++] = $(this).val();
		});
	   $len = img.length;
	  
	   $("#upload"+id).remove(); // 删除某个div 
	   $("#display"+id).remove();// 删除某个div
	   if($len < 2){
		   $("#review_img_show").append('<div class="write_review_increase_img" id="display1" style="display:none"><img id="imghead1" src="" title=" " width="100" height="100" border="0"><span onclick="cls(1)"><i></i></span></div>');
		   $("#addinput").append('<div id="upload1"><i>Attach Image +</i><input type="file" onchange="previewImage(this,this.id)" id="1" name="reviews_img[]"/></div> ');
		   }
	   
	// if($(this).attr('src')==''){ $(this).attr('src','/img/default.png');               }       
	//document.getElementById("imghead"+id).src='';
	$("#addinput").show();
}

function clacImgZoomParam( maxWidth, maxHeight, width, height ){
    var param = {top:0, left:0, width:width, height:height};
    if( width>maxWidth || height>maxHeight )
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;
         
        if( rateWidth > rateHeight )
        {
            param.width =  maxWidth;
            param.height = Math.round(height / rateWidth);
        }else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }
    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;
}
</script>
</body>
</html>
