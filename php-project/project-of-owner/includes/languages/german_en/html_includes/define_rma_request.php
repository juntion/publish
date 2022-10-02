<div class="currentPath"><a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">Home</a><em>&gt;</em><span>RMA Request</span></div>

        <p>We realize that there may be times when an item you ordered needs to be returned. When that does happen, we want to make it as easy as possible for you.,<br /><br /></p>
      <h3>Please fill out the form below making sure to include your contact information and email address. <br />We ask that you also provide a comment so that we can facilitate this process more efficiently.</h3>

	  <?php echo zen_draw_form('rma_request',zen_href_link('rma_request'),'post');?>
      <ul class="Request">
       	<li>Customer's Name: <input type="text" name="customers_name" class="input" /> </li>
        <li>E-Mail Address: <input type="text" name="customers_email_address" class="input" /> </li>
		<li>Order Number:  <input type="text" name="order_number" class="input1" />
        	   Date of Original Purchase (mm/dd/yyyy): <input type="text" name="date_of_purchase" class="input1" /></li>
		<li>Reason for Return (Check all that apply):</li>
        <li><input type="checkbox" name="reason_for_return[]" value="defective" id="1_0" /> Item is defective - (If defective, you must fill out the Defective Product Report in order to get an RMA number)</li>
        <li><input type="checkbox" name="reason_for_return[]" value="wrong_product" id="1_1" /> Ordered wrong product(s)</li>
        <li><input type="checkbox" name="reason_for_return[]" value="not_compatible" id="1_2" /> Item is not compatible with my vehicle/radio</li>
        <li><input type="checkbox" name="reason_for_return[]" value="not_fit" id="1_3" /> Item(s) will not fit - too small/large</li>
        <li><input type="checkbox" name="reason_for_return[]" value="not_need" id="1_4" /> Item not needed any longer</li>
        <li><input type="checkbox" name="reason_for_return[]" value="not_work" id="1_5" /> Item(s) did not work as described<br /></li>
		</ul>

        <ul class="Request">
       	<li>Condition of returning product:</li>
        <li>
        <input type="radio" name="condition_of_return" value="1" id="b_0" /> Unopened
        <input type="radio" name="condition_of_return" value="2" id="b_1" /> Opened for inspection only
        <input type="radio" name="condition_of_return" value="3" id="b_2" /> Opened, installed,
        <input type="radio" name="condition_of_return" value="4" id="b_3" /> Opened, installed, wires cut/soldered</li>
        <li>Expected action by Logjam Electronics on receipt of return:</li>
        <li>
        <input type="radio" name="expected_action" value="1" id="c_0" /> Refund
        <input type="radio" name="expected_action" value="2" id="c_1" /> Warranty Replacement
        <input type="radio" name="expected_action" value="3" id="c_2" /> Exchange for correct item  </li>
     	</ul>

      <ul class="Request">
       	<li>If item is being returned for exchange, list the part number of the exchange item/s:</li>
        <li>
        (eg.)<br/>
        Part1 number of exchange product: ......<br />
        Part2 number of exchange product: ......<br />
        Part3 number of exchange product: ......<br />
        </li>
       
        <li>
        <textarea rows="8" cols="0" style="width: 700px;" name="exchange_item" onclick="javascript:this.value='';">write down your exchange product(s) here ...</textarea>
         </li>
        </ul>

        <ul class="Request">
       	<li>Please write a brief statement describing your reason for returning product (Required to obtain an RMA number):  </li>
        <li><textarea name="brief_description" cols="0" rows="8" style="width: 700px;"></textarea></li>        </ul>        <div class="blank10"></div>        <p align="center"><input type="submit" value="Submit RMA Request Form" class="btn6" /> &nbsp;        <input type="submit" value="Clear Form" class="btn2" /></p>
        </form>
        <div class="blank10 line"></div>

        <ul class="Request2">
        <li><h2>Return &amp; Refunds</h2>
        <p>All returns require a Return Merchandise Authorization # ( RMA # ) within 7 days after the receiving date for an exchange or refund. Otherwise, the product will be considered as damaged by the customer. RMA # is valid for 14 days only. Any products returned after the expiration date will be refused. Please go to your account and then post your RMA request and contact FiberStore.com customer representative at <a href="mailto:service@ecoptical.com">service@ecoptical.com</a> to get return address. All returns will be evaluated by our technical team. Please confirm your personal info is accurate and effective. FiberStore.com will not responsible for refund if out of touch with you. Refunds are made for product value only, excluding shipping and handling charges. For Exchange, we support shipping charges in China only.
        </p>
        </li>

        <li><h2>Wrong Order</h2>
        <p>(1)If you receive a product different from what you ordered, you have 7 days since the date of receipt to request a RMA# and contact FiberStore.com customer representative at service@ecoptical.com . Returns without valid RMA numbers will be discarded.<br />
        (2)If you place a wrong order, you have 7 days since the date of receipt to request return for refund or exchange. If you would like to exchange an item for a correct one, you will be responsible for return shipping fee and reshipping fee as well as any difference in price. If you would like a refund, you will get the item price (excluding postage costs).
        </p>
        </li>

        <li><h2>Return Charges</h2>
        <p>You are responsible for risk of loss, shipping and handling fees for returning or exchanging product. All shipping charges are NON-Refundable unless agreed by FiberStore.com. 20% restocking fee will be imposed if shipment is refused at time of delivery. If you fail to follow the return or exchange instructions or policies provided by FiberStore.com, FiberStore.com is not responsible for product which is lost, damaged, modified or processed for disposal or resale. We reserve the right to refuse the return or charge a 20% restocking fee for damaged or incomplete returns. No returns or exchanges will be accepted without the prior approval issued by FiberStore.com.

        </p> </li>
      </ul>

        </div>    <!--End rightBar-->