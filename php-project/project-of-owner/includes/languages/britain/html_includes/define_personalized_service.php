<div class="currentPath">
        	<a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">Home</a><em>&gt;</em><span>Personalized service</span>
        </div>

    	<div class="LH18px">
        	<p>FiberStore has built its reputation as a leading supplier of high integrity optical communication products assemblies by sourcing only the highest quality products as well as being committed to our customers' needs. </p>
            <p>FiberStore also provides Personalized Service for you. To submit your request for a custom application or other personalized needs, please fill out the information found in the following forms and provide us the specs of your project with a rough sketch. We will review the assembly, consult with you on actual specifications, and provide you with a quote within 24 hours. Normally your products will be ready in 3 days or 5 days. Thank you for giving us the opportunity to earn your business. All custom products are guaranteed against manufacturing defect; however,</p>
            <p>please keep in mind all custom assemblies are non-cancelable and non-returnable once production begins.</p>
        </div>

    	<div class="blank15"></div>
    	<form name="personalized_service" id="personalized_service" action="<?php echo zen_href_link("personalized_service",'','SSL');?>" method="post" enctype="multipart/form-data" onsubmit="return check_personalized_service(personalized_service);">
        <div class="bestBox">
        	<h2>Personalized Service Request Form</h2>
            <div class="bestList" style="border-top:none; padding:8px 0;">
           	  <table width="700" border="0" cellspacing="0" cellpadding="0" class="loginTab">
                  <tr>
                    <td colspan="4" style=" text-indent:15px;">Please fill in your details below and we will contact you as soon as possible</td>
                  </tr>
                  <tr>
                    <td width="159" align="right"><em>*</em> Contact Name:</td>
                    <td width="215"><input name="username" type="text" class="input" /></td>
                    <td width="100" align="right">Fax:<br /></td>
                    <td width="226"><input name="fax" type="text" class="input" /></td>
                  </tr>
                  <tr>
                    <td align="right">Company:</td>
                    <td><input name="company" type="text" class="input" /></td>
                    <td align="right"><em>*</em>E-mail:</td>
                    <td><input name="email_address" type="text" class="input" /></td>
                  </tr>
                  <tr>
                    <td align="right"><em>*</em>Telephone:</td>
                    <td><input name="telephone" type="text" class="input" /></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td rowspan="2" align="right" valign="top"><em>*</em>Address:</td>
                    <td rowspan="2" valign="top"><textarea name="address" cols="" rows="" style=" width:200px; height:50px;"></textarea></td>
                    <td align="right"><em>*</em>Postal Code:<br /></td>
                    <td><input name="postcode" type="text" class="input" /></td>
                  </tr>
                  <tr>
                    <td align="right"><em>*</em>Country:</td>
                    <td><input name="country" type="text" class="input" /></td>
                  </tr>
                  </table>
              <div class="cb"></div>
       	  </div>

            <div class="bestList" style="border-top:none; padding:8px 0;">
           	  <table width="700" border="0" cellspacing="0" cellpadding="0" class="loginTab">
                  <tr>
                    <td width="159" align="right"><em>*</em> Type of Product:</td>
                    <td width="215"><input name="product_type" type="text" class="input" /></td>
                    <td width="100" align="right"><br /></td>
                    <td width="226">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">If Other,<br /> Please Specify:</td>
                    <td><input name="other_specify" type="text" class="input" /></td>
                    <td align="right">Reference <br />
                    products:</td>
                    <td><input name="reference_products" type="text" class="input" /></td>
                  </tr>
                  <tr>
                    <td align="right"><em>*</em>Place to be used:</td>
                    <td><input name="place_to_be_used" type="text" class="input" /></td>
                    <td align="right"><em>*</em>Qty</td>
                    <td><input name="qty" type="text" class="input" /></td>
                  </tr>
                  <tr>
                    <td align="right"><em>*</em>Lead time expected:</td>
                    <td><input name="lead_time" type="text" class="input" /></td>
                    <td align="right"><em>*</em>Package</td>
                    <td><input name="package" type="text" class="input" /></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top"><em>*</em>Specs information:</td>
                    <td colspan="3" valign="top"><textarea name="specs_information" cols="" rows="" style=" width:520px; height:100px;"></textarea></td>
                  </tr>
                   <tr>
                   <td align="right" ><div id="upFileNav"><input class="Finput" type="file" name="attach_file" /></div></td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"><input name="" type="submit"" value="Submit" class="btn5" /></td>
                  </tr>

                  </table>
              <div class="cb"></div>
       	  </div>

   	  	</div>
        <!--End bestBox-->
        </form>