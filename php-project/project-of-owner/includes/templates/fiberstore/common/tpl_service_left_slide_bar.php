
<div class="con_left">
<div class="title_zhenghe">
  <ul>
    <p>Company Info</p>

     <li <?php echo (FILENAME_CONTACT_US == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_CONTACT_US,'').'" target="_self">Contact Us</a>' ;?>
     </li>

     <li <?php echo (FILENAME_ABOUT_US == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_ABOUT_US,'').'" target="_self">About Fiberstore</a>' ;?>
     </li>

     <li <?php echo (FILENAME_WHY_US == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_WHY_US,'').'" target="_self">Why Us</a>' ;?>
     </li>
     <!--
     <li <?php // echo (FILENAME_PRIVACY_POLICY == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php // echo  '<a href="'.zen_href_link(FILENAME_PRIVACY_POLICY,'').'" target="_self">Privacy Policy</a>' ;?>
     </li>
     -->
     <li <?php echo (FILENAME_NEWS == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_NEWS,'').'" target="_self">News</a>' ;?>
     </li>

     <li <?php echo (FILENAME_PARTNER == $_GET['main_page'] || FILENAME_PARTNER_SUBMIT == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_PARTNER,'').'" target="_self">Business Account</a>' ;?>
     </li>
     <li <?php echo ('distributors' == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link('distributors','').'" target="_self">Distributors</a>' ;?>
     </li>

     <!--

      <li <?php echo (FILENAME_SITE_MAP == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_SITE_MAP,'').'" target="_self">Site Map</a>' ;?>
     </li>

      -->
    <div class="title_zhenghe_bor">

    <b>Customer Service</b>
    </div>
     <li <?php echo (FILENAME_OEM == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_OEM,'').'">OEM & Custom</a>' ;?>
     </li>

     <li <?php echo ('quality_control' == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link('quality_control','').'">Quality Control</a>' ;?>
     </li>

<!--     <li <?php /*echo (FILENAME_ISO_STANDARD == $_GET['main_page']) ? 'class="mrxs"' : ''; */?>>
     <?php /*echo '<a href="'.zen_href_link(FILENAME_ISO_STANDARD,'').'">ISO Standard</a>' ;*/?>
     </li>-->


                <li <?php echo (FILENAME_WARRANTY== $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_WARRANTY,'').'">Warranty</a>' ;?>
     </li>


      <li <?php echo (FILENAME_RMA_SOLUTION == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_RMA_SOLUTION,'').'">RMA Solution</a>' ;?>
     </li>

     <!--
     <li <?php // echo ('terms_of_use' == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php // echo '<a href="'.zen_href_link('terms_of_use' ,'').'">Terms of Use</a>' ;?>
     </li>
     -->
           <li <?php echo (FILENAME_DAY_RETURN_POLICY == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_DAY_RETURN_POLICY ,'').'">Return Policy</a>' ;?>
     </li>
           <?php /*?> <li <?php echo (FILENAME_MONEY_BACK_GUARANTEE == $_GET['main_page'] || FILENAME_MONEY_BACK_GUARANTEE == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_MONEY_BACK_GUARANTEE,'').'">Money Back Guarantee</a>' ;?>
     </li><?php */?>
     <div class="title_zhenghe_bor">

    <b>Payment & Shipping</b>
    </div>
     <li <?php echo (FILENAME_PAYMENT_METHODS == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_PAYMENT_METHODS,'').'">Payment Methods</a>' ;?>
     </li>

     <li <?php echo (FILENAME_Net_30 == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_Net_30,'').'">Net 30 & W9</a>' ;?>
     </li>

     <li <?php echo (FILENAME_GLOBAL_SHIPPING == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_GLOBAL_SHIPPING,'').'">Shipping Guide</a>' ;?>
     </li>

           <li <?php echo ('estimated_lead_time' == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link('estimated_lead_time','').'">Delivery & Shipment</a>' ;?>
     </li>

     <div class="title_zhenghe_bor">

    <b>Quick Help</b>
    </div>
     <li <?php echo (FILENAME_HOW_TO_BUY == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_HOW_TO_BUY,'').'">Purchase Help</a>' ;?>
     </li>

      <li <?php echo (FILENAME_FAQ == $_GET['main_page'] || FILENAME_FAQ_DETAIL == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo  '<a href="'.zen_href_link(FILENAME_FAQ,'').'">FAQ</a>' ;?>
     </li>


  </ul>
</div>
</div>
