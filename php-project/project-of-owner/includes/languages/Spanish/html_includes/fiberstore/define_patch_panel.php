<style>
.patch_contact { margin-top:0px;padding:0 40px 40px 0; }
.patch_contact_tit { font-size: 20px; line-height:30px; font-weight: 400; color: #232323; text-align: left; margin:42px 0 15px 0; }
.patch_contact_txt { font-size: 13px; color: #616265;text-align: left; line-height: 24px; }
.patch_contact_txt a { color: #0070BC; text-decoration: none; }
.patch_contact_txt a:hover { text-decoration: underline; }
.popup_con_collect .alen1 ul{margin: inherit;}
.popup_con_collect {padding: 50px 40px 0;}
.popup_con .alena1 { padding-top:0px;}
.popup_share{width: 1440px; padding:50px 40px 0px 0; margin:0 auto;box-sizing:border-box;border-top:1px solid #dedede; }
.alen1 ul{margin: 0 !important;overflow: inherit !important; } 
.alen1 ul li a:hover{text-decoration:none}

i.iconfont.icon.cacheicon{font-size: 23px;margin-right: 20px;color:#787777;}
i.iconfont.icon.cacheicon:hover{color:#232323;}
.alen1 ul:after{content:"";display:block;clear:both;}
.alen1 ul li:nth-child(3) .cacheicon{font-size: 20px;}

@media(max-width:1440px) {.popup_share{width:1200px;padding:20px 35px 35px 0px;}}
@media(max-width:1220px) { .patch_contact{ padding-left:0;}
.popup_share{width:960px; padding:20px 0 35px;}
}
@media(max-width:960px) {
 .patch_contact_tit {
font-size: 30px;
margin-bottom: 20px;
}
.patch_contact{ padding:0px 10px 0 10px;}
.popup_share{ width:inherit;padding: 20px 10px 25px 10px;}
}
@media(max-width: 480px) {
 .patch_contact_list a {
 padding-left: 20px;
}
 .patch_contact_list div {
 width: 218px;
}

 .patch_contact_tit {
font-size:20px;
}
}
</style>
<?php echo getShareTheBox()?>
<div class="patch_contact">
  <h2 class="patch_contact_tit"><?php echo PATCH_PANEL_01;?></h2>
  <p class="patch_contact_txt"><?php echo PATCH_PANEL_02;?>  <br />
     <?php echo PATCH_PANEL_03;?> <a href="mailto:tech@fs.com">tech@fs.com</a>  <?php echo PATCH_PANEL_04;?>  <a href="mailto:es@fs.com">es@fs.com</a>.
  </p>
</div>
