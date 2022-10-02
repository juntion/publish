

<div class="con_left">
<div class="title_zhenghe">
  <ul>
    <p>Company Info</p>
    
     <li <?php echo (FILENAME_CONTACT_US == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_CONTACT_US == $_GET['main_page']) ? 'Contact Us': '<a href="'.zen_href_link(FILENAME_CONTACT_US,'').'" target="_self">Contact Us</a>' ;?>
     </li>
    
     <li <?php echo (FILENAME_ABOUT_US == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_ABOUT_US == $_GET['main_page']) ? 'About Us': '<a href="'.zen_href_link(FILENAME_ABOUT_US,'').'" target="_self">About Us</a>' ;?>
     </li>
     
     <li <?php echo (FILENAME_WHY_US == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_WHY_US == $_GET['main_page']) ? 'Why Us': '<a href="'.zen_href_link(FILENAME_WHY_US,'').'" target="_self">Why Us</a>' ;?>
     </li>
     
     <li <?php echo (FILENAME_PRIVACY_POLICY == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_PRIVACY_POLICY == $_GET['main_page']) ? 'Privacy Policy': '<a href="'.zen_href_link(FILENAME_PRIVACY_POLICY,'').'" target="_self">Privacy Policy</a>' ;?>
     </li>
     
     <li <?php echo (FILENAME_NEWS == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_NEWS == $_GET['main_page']) ? 'NEWS': '<a href="'.zen_href_link(FILENAME_NEWS,'').'" target="_self">News</a>' ;?>
     </li>
     
     <li <?php echo (FILENAME_PARTNER == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_PARTNER == $_GET['main_page']) ? 'Partner': '<a href="'.zen_href_link(FILENAME_PARTNER,'').'" target="_self">Partner</a>' ;?>
     </li>
     <!--
     
      <li <?php echo (FILENAME_SITE_MAP == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_SITE_MAP == $_GET['main_page']) ? 'Site Map': '<a href="'.zen_href_link(FILENAME_SITE_MAP,'').'" target="_self">Site Map</a>' ;?>
     </li>

      -->
    <div class="title_zhenghe_bor">
    
    <b>Customer Service</b>
    </div>
    <!--
    
      <li <?php echo (FILENAME_GET_A_QUICK_QUOTE == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_GET_A_QUICK_QUOTE == $_GET['main_page']) ? 'Get A Quick Quote': '<a href="'.zen_href_link(FILENAME_GET_A_QUICK_QUOTE,'').'">Get A Quick Quote</a>' ;?>
     </li>
    
     --><li <?php echo (FILENAME_OEM == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_OEM == $_GET['main_page']) ? 'OEM & Custom': '<a href="'.zen_href_link(FILENAME_OEM,'').'">OEM & Custom</a>' ;?>
     </li>
     
     <li <?php echo (FILENAME_PAYMENT_METHODS == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_PAYMENT_METHODS == $_GET['main_page']) ? 'Payment Methods': '<a href="'.zen_href_link(FILENAME_PAYMENT_METHODS,'').'">Payment Methods</a>' ;?>
     </li>
     <!--
     
     <li <?php // echo (FILENAME_SHIPPING_GUIDE == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php // echo (FILENAME_SHIPPING_GUIDE == $_GET['main_page']) ? 'Shipping Guide': '<a href="'.zen_href_link(FILENAME_SHIPPING_GUIDE,'').'">Shipping Guide</a>' ;?>
     </li>
     
     
      <li <?php // echo (FILENAME_BOTH_WAYS == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php // echo (FILENAME_BOTH_WAYS == $_GET['main_page']) ? 'Free shipping': '<a href="'.zen_href_link(FILENAME_BOTH_WAYS,'').'">Free Shipping</a>' ;?>
     </li>
      -->
     <li <?php echo (FILENAME_GLOBAL_SHIPPING == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_GLOBAL_SHIPPING == $_GET['main_page']) ? 'Shipping Guide': '<a href="'.zen_href_link(FILENAME_GLOBAL_SHIPPING,'').'">Shipping Guide</a>' ;?>
     </li>
     
           <li <?php echo ('estimated_lead_time' == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo ('estimated_lead_time' == $_GET['main_page']) ? 'Processing Time': '<a href="'.zen_href_link('estimated_lead_time','').'">Processing Time</a>' ;?>
     </li> 
     
     
           <li <?php echo (FILENAME_ISO_STANDARD == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo '<a href="'.zen_href_link(FILENAME_ISO_STANDARD,'').'">ISO Standard</a>' ;?>
     </li> 
     
     
                <li <?php echo (FILENAME_WARRANTY== $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_WARRANTY == $_GET['main_page']) ? 'Lifetime Warranty': '<a href="'.zen_href_link(FILENAME_WARRANTY,'').'">Lifetime Warranty</a>' ;?>
     </li> 
     
     
      <li <?php echo (FILENAME_RMA_SOLUTION == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_RMA_SOLUTION == $_GET['main_page']) ? 'RMA Solution': '<a href="'.zen_href_link(FILENAME_RMA_SOLUTION,'').'">RMA Solution</a>' ;?>
     </li>
     
           <li <?php echo (FILENAME_DAY_RETURN_POLICY == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_DAY_RETURN_POLICY  == $_GET['main_page']) ? '60 Days Return & Exchange Policy': '<a href="'.zen_href_link(FILENAME_DAY_RETURN_POLICY ,'').'">60 Days Return & Exchange Policy</a>' ;?>
     </li><!--
    <div class="title_zhenghe_bor">
        <b>Resources</b>
        </div>
     <li <?php //echo (FILENAME_CUSTOM_OEM == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php //echo (FILENAME_CUSTOM_OEM == $_GET['main_page']) ? ' Solution': '<a href="'.zen_href_link(FILENAME_CUSTOM_OEM,'').'"> Solution</a>' ;?>
     </li>
      <li <?php //echo (FILENAME_TUTORIAL == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php //echo (FILENAME_TUTORIAL == $_GET['main_page']) ? 'Tutorial': '<a href="'.zen_href_link(FILENAME_TUTORIAL,'').'">Tutorial</a>' ;?>
     </li>     
     -->
     
     <div class="title_zhenghe_bor">
    
    <b>Quick Help</b>
    </div>
     <li <?php echo (FILENAME_HOW_TO_BUY == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_HOW_TO_BUY == $_GET['main_page']) ? 'Purchase Help': '<a href="'.zen_href_link(FILENAME_HOW_TO_BUY,'').'">Purchase Help</a>' ;?>
     </li>
          
      <li <?php echo (FILENAME_FAQ == $_GET['main_page']) ? 'class="mrxs"' : ''; ?>>
     <?php echo (FILENAME_FAQ == $_GET['main_page']) ? 'FAQ': '<a href="'.zen_href_link(FILENAME_FAQ,'').'">FAQ</a>' ;?>
     </li> 

    
  </ul>
</div>
</div>
