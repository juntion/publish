 <script>
    $(function(){
        $(window).scroll(function(){
            height = $(window).scrollTop();
            if(height > 170){
                $('.page_nav').fadeIn();
            }else{
                $('.page_nav').stop(true).hide();
            };

        });
    });
</script>
<div class="box">
<div class="content ">
<div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a><?php echo EU_SHIPPING_1;?></a> </div>
        <div class="short_title"><a href="payment_methods.html"><?php echo EU_SHIPPING_2;?></a><a href="net_30.html">購買注文</a><a href="#" class="title_selected"><?php echo EU_SHIPPING_4;?></a></div>
      </div>
    </div>
 <div class="page_banner">
		        	<div class="page_banner_con shipping_banner"><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/m_shipping_banner.jpg" /></div>
		        	<div class="shipping_banner_text"><span>配送する &amp; 配達</span>配送方法についての情報、送料と配送時間です。</div>
		        </div>
		        <div class="sd_main">
		        	<div class="sd_shipping">
			        	<img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_location_icon.png" width="82px" height="74px" />
			        	<h2 class="sd_tit">配送する</h2>
			        	<p class="sd_txt">FS.COMはドイツと米国に倉庫を持っています。当社のドイツ倉庫（NOVA Gewerbepark Neufahrn, building 7, Am Gfild 7, 85375 Neufahrn near Munich）から、以下の国家へ指定の送料と配達時間でご注文を配達されます。
						私たちはUPS標準サービスをデフォルト配送方法で設定されます。サービスエリア以内$79金額以上のご注文は無料送料を享受します。</p>
			        </div>
			        <div class="sd_tab">
			        	<div class="sd_tab_choose">
			        		<div class="sd_tab_choose_con choose">
			        			<p>
			        				<span></span>「UPS配送サービス」を設定する
			        			</p>
			        		</div>
			        		<div class="sd_tab_choose_con">
			        			<p>
			        				<span></span>「DHL配送サービス」を設定する
			        			</p>
			        		</div>
			        	</div>
			        	<div class="sd_tab_main">
			        		<div class="sd_tab_con">
			        			<h2 class="sd_tit">「UPS標準サービス」を設定する</h2>
			        			<div class="sd_tab_con_font">
			        				<p class="sd_tab_con_font_left">Zone 1- ドイツ</p>
			        				<p class="sd_tab_con_font_right">Zone 3- ベルギー、オーストリア、ルクセンブルク、オランダ、チェコ共和国</p>
			        				
			        				<p class="sd_tab_con_font_left">Zone 31- クロアチア、ポーランド、スロベニア、スロバキア</p>
			        				<p class="sd_tab_con_font_right">Zone 4- デンマーク、フィンランド、英国、モナコ、スウェーデン、フランス</p>
			        				
			        				<p class="sd_tab_con_font_left">Zone 41- ブルガリア、エストニア、ラトビア、ルーマニア、ハンガリー、リトアニア</p>
			        				<p class="sd_tab_con_font_right">Zone 5- ギリシャ、アイルランド、イタリア、ポルトガル、スペイン</p>
									
									<p class="sd_tab_con_font_left">Zone 6- アンドラ、ジャージー、リヒテンシュタイン、ノルウェー、サンマリノ、スイス</p>
			        			</div>
			        			<div class="sd_tab_con_table marginBottom40">
			        				<table cellpadding="0" cellspacing="0">
			        					<thead>
			        						<tr>
			        							<td width="16%">重量（kg）</td>
			        							<td width="12%">Zone 1（ユーロ）</td>
			        							<td width="12%">Zone 3（ユーロ）</td>
			        							<td width="12%">Zone 31（ユーロ）</td>
			        							<td width="12%">Zone 4（ユーロ）</td>
			        							<td width="12%">Zone 41（ユーロ）</td>
			        							<td width="12%">Zone 5（ユーロ）</td>
			        							<td width="12%">Zone 6（ユーロ）</td>
			        						</tr>
			        					</thead>
			        					<tbody>
			        						<tr>
			        							<td>1</td>
			        							<td>3.13</td>
			        							<td>6.29</td>
			        							<td>7.36</td>
			        							<td>7.35</td>
			        							<td>9.52</td>
			        							<td>9.41</td>
			        							<td>15.84</td>
			        						</tr>
			        						<tr>
			        							<td>2-4</td>
			        							<td>3.15</td>
			        							<td>6.29</td>
			        							<td>7.36</td>
			        							<td>7.35</td>
			        							<td>9.52</td>
			        							<td>9.41</td>
			        							<td>15.84</td>
			        						</tr>
			        						<tr>
			        							<td>5-7</td>
			        							<td>3.38</td>
			        							<td>6.72</td>
			        							<td>7.86</td>
			        							<td>7.82</td>
			        							<td>10.19</td>
			        							<td>10.07</td>
			        							<td>16.96</td>
			        						</tr>
			        						<tr>
			        							<td>8-10</td>
			        							<td>3.62</td>
			        							<td>7.23</td>
			        							<td>8.47</td>
			        							<td>8.45</td>
			        							<td>10.96</td>
			        							<td>10.83</td>
			        							<td>18.21</td>
			        						</tr>
			        						<tr>
			        							<td>12-14</td>
			        							<td>3.94</td>
			        							<td>7.85</td>
			        							<td>9.20</td>
			        							<td>9.15</td>
			        							<td>11.91</td>
			        							<td>11.80</td>
			        							<td>19.84</td>
			        						</tr>
			        						<tr>
			        							<td>16-20</td>
			        							<td>4.42</td>
			        							<td>8.8</td>
			        							<td>10.32</td>
			        							<td>10.23</td>
			        							<td>13.28</td>
			        							<td>13.18</td>
			        							<td>22.20</td>
			        						</tr>
			        						<tr>
			        							<td>30</td>
			        							<td>5.98</td>
			        							<td>11.95</td>
			        							<td>13.99</td>
			        							<td>13.96</td>
			        							<td>18.03</td>
			        							<td>17.93</td>
			        							<td>30.07</td>
			        						</tr>
			        						<tr>
			        							<td>40</td>
			        							<td>9.47</td>
			        							<td>18.82</td>
			        							<td>22.10</td>
			        							<td>21.98</td>
			        							<td>28.57</td>
			        							<td>28.25</td>
			        							<td>47.55</td>
			        						</tr>
			        						<tr>
			        							<td>50</td>
			        							<td>25.78</td>
			        							<td>45.25</td>
			        							<td>58.98</td>
			        							<td>69.28</td>
			        							<td>79.78</td>
			        							<td>86.40</td>
			        							<td>98.73</td>
			        						</tr>
			        						<tr>
			        							<td>60</td>
			        							<td>27.23</td>
			        							<td>53.80</td>
			        							<td>69.13</td>
			        							<td>82.73</td>
			        							<td>94.20</td>
			        							<td>99.78</td>
			        							<td>108.75</td>
			        						</tr>
			        						<tr>
			        							<td>70</td>
			        							<td>28.70</td>
			        							<td>62.35</td>
			        							<td>79.3</td>
			        							<td>96.18</td>
			        							<td>108.58</td>
			        							<td>113.13</td>
			        							<td>118.78</td>
			        						</tr>
			        					</tbody>
			        				</table>
			        			</div>
			        			<h2 class="sd_tit">「UPS Express Saver」を設定する</h2>
			        			<div class="sd_tab_con_font">
			        				<p class="sd_tab_con_font_left">Zone 1- ドイツ</p>
			        				<p class="sd_tab_con_font_right">Zone 2- ベルギー、ルクセンブルク、オランダ、オーストリア</p>
			        				
			        				<p class="sd_tab_con_font_left">Zone 3- デンマーク、英国、イタリア、フランス、モナコ</p>
			        				<p class="sd_tab_con_font_right">Zone 4- フィンランド、ギリシャ、アイルランド、ポルトガル、スペイン、スウェーデン</p>
			        				
			        				<p class="sd_tab_con_font_left">Zone 41- クロアチア、ポーランド、スロベニア、ハンガリー、チェコ共和国、スロバキア</p>
			        				<p class="sd_tab_con_font_right">Zone 42- ブルガリア、エストニア、ラトビア、ルーマニア、リトアニア、マルタ、キプロス</p>
									
									<p class="sd_tab_con_font_left">Zone 5- アンドラ、ジャージー、リヒテンシュタイン、ノルウェー、サンマリノ、スイス</p>
			        				<p class="sd_tab_con_font_right">Zone 6- アルバニア、ボスニア・ヘルツェゴビナ、アイスランド、グリーンランド、マケドニア、モルドバ、モンテネグロ、セルビア、フェロー諸島</p>
									
									<p class="sd_tab_con_font_left">Zone 8- グアドループ、マルティニーク、アルバ</p>
			        				<p class="sd_tab_con_font_right">Zone 12- レユニオン島、マヨット島</p>
			        			</div>
			        			<div class="sd_tab_con_table">
			        				<table cellpadding="0" cellspacing="0">
			        					<thead>
			        						<tr>
			        							<td width="10%">重量（kg）</td>
			        							<td width="9%">Zone 1（ユーロ）</td>
			        							<td width="9%">Zone 2（ユーロ）</td>
			        							<td width="9%">Zone 3（ユーロ）</td>
			        							<td width="9%">Zone 4（ユーロ）</td>
			        							<td width="9%">Zone 41（ユーロ）</td>
			        							<td width="9%">Zone 42（ユーロ）</td>
			        							<td width="9%">Zone 5（ユーロ）</td>
			        							<td width="9%">Zone 6（ユーロ）</td>
			        							<td width="9%">Zone 8（ユーロ）</td>
			        							<td width="9%">Zone 12（ユーロ）</td>
			        						</tr>
			        					</thead>
			        					<tbody>
			        						<tr>
			        							<td>1</td>
			        							<td>5.90</td>
			        							<td>15.22</td>
			        							<td>18.18</td>
			        							<td>19.29</td>
			        							<td>23.64</td>
			        							<td>24.31</td>
			        							<td>19.16</td>
			        							<td>27.84</td>
			        							<td>25.38</td>
			        							<td>39.47</td>
			        						</tr>
			        						<tr>
			        							<td>2</td>
			        							<td>5.90</td>
			        							<td>16.55</td>
			        							<td>20.92</td>
			        							<td>22.23</td>
			        							<td>27.37</td>
			        							<td>28.05</td>
			        							<td>21.51</td>
			        							<td>31.77</td>
			        							<td>29.53</td>
			        							<td>52.93</td>
			        						</tr>
			        						<tr>
			        							<td>3</td>
			        							<td>5.90</td>
			        							<td>17.39</td>
			        							<td>23.47</td>
			        							<td>25.59</td>
			        							<td>32.69</td>
			        							<td>32.86</td>
			        							<td>23.81</td>
			        							<td>35.47</td>
			        							<td>33.70</td>
			        							<td>65.25</td>
			        						</tr>
			        						<tr>
			        							<td>4</td>
												<td>5.90</td>
			        							<td>18.59</td>
			        							<td>25.73</td>
			        							<td>28.12</td>
			        							<td>35.97</td>
			        							<td>36.21</td>
			        							<td>26.01</td>
			        							<td>39.03</td>
			        							<td>38.10</td>
			        							<td>76.41</td>
			        						</tr>
			        						<tr>
			        							<td>5</td>
			        							<td>5.90</td>
			        							<td>19.78</td>
			        							<td>27.95</td>
			        							<td>30.67</td>
			        							<td>39.23</td>
			        							<td>39.51</td>
			        							<td>28.23</td>
			        							<td>42.60</td>
			        							<td>42.47</td>
			        							<td>87.61</td>
			        						</tr>
			        						<tr>
			        							<td>6</td>
			        							<td>5.99</td>
			        							<td>20.99</td>
			        							<td>30.18</td>
			        							<td>33.15</td>
			        							<td>42.53</td>
			        							<td>42.85</td>
			        							<td>30.47</td>
			        							<td>46.18</td>
			        							<td>45.45</td>
			        							<td>96.64</td>
			        						</tr>
			        						<tr>
			        							<td>7</td>
			        							<td>6.12</td>
			        							<td>22.21</td>
			        							<td>32.43</td>
			        							<td>35.66</td>
			        							<td>45.78</td>
			        							<td>46.18</td>
			        							<td>32.69</td>
			        							<td>49.74</td>
			        							<td>48.40</td>
			        							<td>105.73</td>
			        						</tr>
			        						<tr>
			        							<td>8</td>
			        							<td>6.24</td>
			        							<td>23.44</td>
			        							<td>34.65</td>
			        							<td>38.15</td>
			        							<td>49.03</td>
			        							<td>49.50</td>
			        							<td>34.89</td>
			        							<td>53.30</td>
			        							<td>51.33</td>
			        							<td>114.77</td>
			        						</tr>
			        						<tr>
			        							<td>9</td>
			        							<td>6.34</td>
			        							<td>24.64</td>
			        							<td>36.90</td>
			        							<td>40.66</td>
			        							<td>52.35</td>
			        							<td>52.81</td>
			        							<td>37.14</td>
			        							<td>56.88</td>
			        							<td>54.27</td>
			        							<td>123.82</td>
			        						</tr>
			        						<tr>
			        							<td>10</td>
			        							<td>6.44</td>
			        							<td>25.84</td>
			        							<td>39.11</td>
			        							<td>43.20</td>
			        							<td>55.59</td>
			        							<td>56.15</td>
			        							<td>39.37</td>
			        							<td>60.43</td>
			        							<td>57.23</td>
			        							<td>132.91</td>
			        						</tr>
			        						<tr>
			        							<td>16</td>
			        							<td>9.69</td>
			        							<td>32.93</td>
			        							<td>48.32</td>
			        							<td>54.17</td>
			        							<td>72.58</td>
			        							<td>73.68</td>
			        							<td>49.14</td>
			        							<td>78.65</td>
			        							<td>78.31</td>
			        							<td>162.00</td>
			        						</tr>
			        						<tr>
			        							<td>20</td>
			        							<td>11.60</td>
			        							<td>36.86</td>
			        							<td>53.59</td>
			        							<td>59.94</td>
			        							<td>81.93</td>
			        							<td>83.06</td>
			        							<td>54.29</td>
			        							<td>88.65</td>
			        							<td>90.44</td>
			        							<td>176.74</td>
			        						</tr>
			        						<tr>
			        							<td>30</td>
			        							<td>16.18</td>
			        							<td>48.93</td>
			        							<td>70.41</td>
			        							<td>79.34</td>
			        							<td>104.10</td>
			        							<td>106.21</td>
			        							<td>69.93</td>
			        							<td>113.74</td>
			        							<td>117.48</td>
			        							<td>223.44</td>
			        						</tr>
			        						<tr>
			        							<td>50</td>
			        							<td>28.08</td>
			        							<td>95.81</td>
			        							<td>132.38</td>
			        							<td>152.42</td>
			        							<td>194.00</td>
			        							<td>197.39</td>
			        							<td>129.80</td>
			        							<td>212.90</td>
			        							<td>216.50</td>
			        							<td>409.25</td>
			        						</tr>
			        						<tr>
			        							<td>70</td>
			        							<td>32.94</td>
			        							<td>120.23</td>
			        							<td>162.41</td>
			        							<td>191.55</td>
			        							<td>239.55</td>
			        							<td>244.05</td>
			        							<td>159.68</td>
			        							<td>263.39</td>
			        							<td>265.05</td>
			        							<td>499.25</td>
			        						</tr>
			        						<tr>
			        							<td>70+ （重量超過分は1kgごとに追加料金）</td>
			        							<td>0.47</td>
			        							<td>1.72</td>
			        							<td>2.32</td>
			        							<td>2.74</td>
			        							<td>3.42</td>
			        							<td>3.49</td>
			        							<td>2.28</td>
			        							<td>3.76</td>
			        							<td>3.79</td>
			        							<td>7.13</td>
			        						</tr>
			        					</tbody>
			        				</table>
			        			</div>
			        			<p class="sd_txt note">ご注意：以上の全ての価格をご参考のみ利用してください。あなたは発注をする時、チェックアウトページには確認された送料が見つかります。各配送方式の費用はお客様のショッピングカートの商品の累積重量または商品の寸法に基づいて請求されます。FS.COMはお客様に隠された注文料金を請求しておりません。</p>
			        		</div>
			        		<div class="sd_tab_con" style="display: none;">
			        			<h2 class="sd_tit">ドイツ国内にむけて、「DHL Express Domestic」サービスで配送されます。</h2>
			        			<div class="sd_tab_con_table marginBottom40">
			        				<table cellpadding="0" cellspacing="0">
			        					<thead>
			        						<tr>
			        							<td width="50%">重量（kg）</td>
			        							<td width="50%">送料（ユーロ）</td>
			        						</tr>
			        					</thead>
			        					<tbody>
			        						<tr>
			        							<td>≤3.0</td>
			        							<td>7.50</td>
			        						</tr>
			        						<tr>
			        							<td>3.1-5.0</td>
			        							<td>8.60</td>
			        						</tr>
			        						<tr>
			        							<td>5.1-10.0</td>
			        							<td>10.20</td>
			        						</tr>
			        						<tr>
			        							<td>10.1-20</td>
			        							<td>12.30</td>
			        						</tr>
			        						<tr>
			        							<td>20.1-30.0</td>
			        							<td>18.30</td>
			        						</tr>
			        						<tr>
			        							<td>31.0</td>
			        							<td>19.50</td>
			        						</tr>
			        						<tr>
			        							<td>...</td>
			        							<td>...</td>
			        						</tr>
			        					</tbody>
			        				</table>
			        				<p class="sd_txt dot"><span></span><em>30.1 kgと99,999.0 kgの間に、重量超過分が1kgごとに追加料金は1.20ユーロです。</em></p>
			        			</div>
			        			<h2 class="sd_tit">他のサービスエリア内にむけて、「DHL Express Worldwide」サービスで配送されます。</h2>
			        			<div class="sd_tab_con_font">
			        				<p class="sd_tab_con_font_left">Zone 1- ベルギー、ルクセンブルク、オランダ</p>
			        				<p class="sd_tab_con_font_right">Zone 2- デンマーク、フランス、オーストリア、モナコ</p>
			        				
			        				<p class="sd_tab_con_font_left">Zone 3- 英国、イタリア、ポーランド、スペイン、チェコ共和国</p>
			        				<p class="sd_tab_con_font_right">Zone 4- ブルガリア、エストニア、フィンランド、ギリシャ、アイルランド、クロアチア、ラトビア、リトアニア</p>
			        				
			        				<p class="sd_tab_con_font_right other">マルタ、ポルトガル、スウェーデン、スロバキア、スロベニア、ハンガリー、キプロス</p>
									
									<p class="sd_tab_con_font_left">Zone 5- アンドラ、ジャージー、リヒテンシュタイン、ノルウェー、サンマリノ、スイス、フェロー諸島</p>
			        				<p class="sd_tab_con_font_right">Zone 6- アルバニア、ボスニア・ヘルツェゴビナ、マケドニア、モルドバ、モンテネグロ、セルビア</p>
									
									<p class="sd_tab_con_font_left">Zone 10- アルバ、マヨット島、レユニオン島、マルティニーク島、グアドループ、グリーンランド、フランス領ギアナ</p>
									
			        			</div>
			        			<div class="sd_tab_con_table">
			        				<table cellpadding="0" cellspacing="0">
			        					<thead>
			        						<tr>
			        							<td width="16%">重量（kg）</td>
			        							<td width="12%">Zone 1（ユーロ）</td>
			        							<td width="12%">Zone 2（ユーロ）</td>
			        							<td width="12%">Zone 3（ユーロ）</td>
			        							<td width="12%">Zone 4（ユーロ）</td>
			        							<td width="12%">Zone 5（ユーロ）</td>
			        							<td width="12%">Zone 6（ユーロ）</td>
			        							<td width="12%">Zone 10（ユーロ）</td>
			        						</tr>
			        					</thead>
			        					<tbody>
			        						<tr>
			        							<td>0.5</td>
			        							<td>12.74</td>
			        							<td>13.56</td>
			        							<td>14.89</td>
			        							<td>15.21</td>
			        							<td>16.37</td>
			        							<td>23.03</td>
			        							<td>28.17</td>
			        						</tr>
			        						<tr>
			        							<td>1.0</td>
			        							<td>14.07</td>
			        							<td>14.95</td>
			        							<td>16.80</td>
			        							<td>17.37</td>
			        							<td>18.53</td>
			        							<td>25.46</td>
			        							<td>34.72</td>
			        						</tr>
			        						<tr>
			        							<td>1.5</td>
			        							<td>15.13</td>
			        							<td>16.02</td>
			        							<td>18.19</td>
			        							<td>19.18</td>
			        							<td>20.34</td>
			        							<td>27.37</td>
			        							<td>40.40</td>
			        						</tr>
			        						<tr>
			        							<td>2.0</td>
			        							<td>16.19</td>
			        							<td>17.09</td>
			        							<td>19.58</td>
			        							<td>20.99</td>
			        							<td>22.15</td>
			        							<td>29.28</td>
			        							<td>46.08</td>
			        						</tr>
			        						<tr>
			        							<td>2.5</td>
			        							<td>16.83</td>
			        							<td>17.73</td>
			        							<td>20.80</td>
			        							<td>23.36</td>
			        							<td>23.36</td>
			        							<td>30.73</td>
			        							<td>57.39</td>
			        						</tr>
			        						<tr>
			        							<td>3.0</td>
			        							<td>17.35</td>
			        							<td>18.63</td>
			        							<td>21.96</td>
			        							<td>24.86</td>
			        							<td>24.86</td>
			        							<td>32.42</td>
			        							<td>63.76</td>
			        						</tr>
			        						<tr>
			        							<td>3.5</td>
			        							<td>17.87</td>
			        							<td>19.53</td>
			        							<td>23.12</td>
			        							<td>26.36</td>
			        							<td>26.36</td>
			        							<td>34.11</td>
			        							<td>70.13</td>
			        						</tr>
			        						<tr>
			        							<td>4.0</td>
			        							<td>18.39</td>
			        							<td>20.43</td>
			        							<td>24.28</td>
			        							<td>27.86</td>
			        							<td>27.86</td>
			        							<td>35.80</td>
			        							<td>76.50</td>
			        						</tr>
			        						<tr>
			        							<td>4.5</td>
			        							<td>18.91</td>
			        							<td>21.33</td>
			        							<td>25.44</td>
			        							<td>29.36</td>
			        							<td>29.36</td>
			        							<td>37.49</td>
			        							<td>82.87</td>
			        						</tr>
			        						<tr>
			        							<td>5.0</td>
			        							<td>19.43</td>
			        							<td>22.23</td>
			        							<td>26.60</td>
			        							<td>30.86</td>
			        							<td>30.86</td>
			        							<td>39.18</td>
			        							<td>89.24</td>
			        						</tr>
			        						<tr>
			        							<td>5.5</td>
			        							<td>20.00</td>
			        							<td>23.04</td>
			        							<td>27.77</td>
			        							<td>32.34</td>
			        							<td>32.34</td>
			        							<td>41.23</td>
			        							<td>94.86</td>
			        						</tr>
			        						<tr>
			        							<td>10</td>
			        							<td>25.13</td>
			        							<td>30.33</td>
			        							<td>38.30</td>
			        							<td>45.66</td>
			        							<td>45.66</td>
			        							<td>59.68</td>
			        							<td>145.44</td>
			        						</tr>
			        						<tr>
			        							<td>20</td>
			        							<td>38.33</td>
			        							<td>44.12</td>
			        							<td>54.34</td>
			        							<td>66.49</td>
			        							<td>66.49</td>
			        							<td>85.94</td>
			        							<td>201.50</td>
			        						</tr>
			        						<tr>
			        							<td>30</td>
			        							<td>49.73</td>
			        							<td>62.93</td>
			        							<td>70.30</td>
			        							<td>86.06</td>
			        							<td>86.06</td>
			        							<td>117.48</td>
			        							<td>240.64</td>
			        						</tr>
			        						<tr>
			        							<td>70</td>
			        							<td>151.33</td>
			        							<td>192.53</td>
			        							<td>211.90</td>
			        							<td>252.46</td>
			        							<td>252.46</td>
			        							<td>291.88</td>
			        							<td>581.44</td>
			        						</tr>
			        					</tbody>
			        				</table>
			        			</div>
			        			<p class="sd_txt note marginBottom10">重量超過分は1kgごとに追加料金：</p>
			        			<div class="sd_tab_con_table">
			        				<table cellpadding="0" cellspacing="0">
			        					<thead>
			        						<tr>
			        							<td width="20%">から（kg）</td>
			        							<td width="10%">まで（kg）</td>
			        							<td width="10%">Zone 1（ユーロ）</td>
			        							<td width="10%">Zone 2（ユーロ）</td>
			        							<td width="10%">Zone 3（ユーロ）</td>
			        							<td width="10%">Zone 4（ユーロ）</td>
			        							<td width="10%">Zone 5（ユーロ）</td>
			        							<td width="10%">Zone 6（ユーロ）</td>
			        							<td width="10%">Zone 10（ユーロ）</td>
			        						</tr>
			        					</thead>
			        					<tbody>
			        						<tr>
			        							<td>30.1</td>
			        							<td>70</td>
			        							<td>1.27</td>
			        							<td>1.62</td>
			        							<td>1.77</td>
			        							<td>2.08</td>
			        							<td>2.08</td>
			        							<td>2.18</td>
			        							<td>4.26</td>
			        						</tr>
			        						<tr>
			        							<td>70.1</td>
			        							<td>300</td>
			        							<td>5.67</td>
			        							<td>5.44</td>
			        							<td>7.29</td>
			        							<td>9.06</td>
			        							<td>9.06</td>
			        							<td>9.00</td>
			        							<td>19.29</td>
			        						</tr>
			        						<tr>
			        							<td>300.1</td>
			        							<td>99,999</td>
			        							<td>5.55</td>
			        							<td>5.53</td>
			        							<td>7.03</td>
			        							<td>8.75</td>
			        							<td>8.75</td>
			        							<td>8.52</td>
			        							<td>18.64</td>
			        						</tr>
			        					</tbody>
			        				</table>
			        			</div>
			        			<p class="sd_txt note">ご注意：以上の全ての価格をご参考のみ利用してください。あなたは発注をする時、チェックアウトページには確認された送料が見つかります。各配送方式の費用はお客様のショッピングカートの商品の累積重量または商品の寸法に基づいて請求されます。FS.COMはお客様に隠された注文料金を請求しておりません。</p>
			        		</div>
			        	</div>
			        </div>
			        <div class="sd_time">
			        	<div class="sd_time_bg"></div>
			        	<h2 class="sd_tit">配達時間 & 送料</h2>
			        	<div class="sd_time_tab">
			        		<div class="sd_time_tab_choose choose">処理時間</div>
			        		<div class="sd_time_tab_choose">配達時間</div>
			        		<div class="sd_time_tab_choose">配送する</div>
			        	</div>
			        	<div class="sd_time_show">
			        		<div class="sd_time_show_con" style="display: block;">
			        			<div class="sd_time_show_pic">
			        				<img src="/includes/templates/fiberstore/images/specials/shipping_delivery/Processing_time.jpg" />
			        			</div>
			        			<div class="sd_time_show_font">
			        				<p class="sd_txt">ご注文は金額受領した後通常24時間以内に処理されます。ご購入した商品は在庫になり、当日または1～2営業日以内出荷されます、残りの部分には中国倉庫または米国倉庫から欧州倉庫へ運送で成功した後欧州倉庫から配送されます。</p>
			        				<p class="sd_txt">カスタマイズ製品には、私たちは製造時間が必要です。その上、製造時間はご注文のアイテムによって異なり、例えば、ケーブルは通常に3営業日かかり、C/DWDM MUX DEMUXはほぼ2週間を利用可能です。</p>
			        				<p class="sd_txt">もしお客様は倉庫からピックアップしたい場合、私たちは製品が準備完了時あなたにメールで通知します。この場合は送料無料です。</p>
			        			</div>
			        		</div>
			        		<div class="sd_time_show_con">
			        			<div class="sd_time_show_font">
			        				<p class="sd_txt"><span></span><em>UPS標準サービスとDHLエクスプレスで配送するには、お客様の注文は倉庫が出荷された後、1-3営業日以内配達します。 </em></p>
			        				<p class="sd_txt"><span></span><em>「UPS EXPRESS SAVER」サービスで配送するには、お客様の注文は倉庫が出荷された後、翌日の午前5時前に配達します。</em></p>
			        				<p class="sd_txt"><span></span><em>「DHL EXPRESS」サービスで配送するには、お客様の注文は倉庫が出荷された後、翌日の午前9時～12時間に配達します。</em></p>
			        				<p class="sd_txt note">ご注意：スペイン、イタリアの国には、通関の原因なのでアイテムはこの指定された時間と相違する場合があります。</p>
			        			</div>
			        		</div>
			        		<div class="sd_time_show_con">
			        			<div class="sd_time_show_font">
			        				<p class="sd_txt">輸入関税、税および仲介手数料は商品価格と送料に含まれておりません。これらの費用は配達時の特定のパッケージにより生じ、これらの費用は買い手の責任です、ご了承ください。関税は商品価格に含まれておりません、買い手がこの費用を支払う必要があります。 <br>当社は重すぎや大すぎなアイテムには、より安い送料のために海上輸送を提供致します。どうぞ、お問い合わせてください <a href="mailto:legal@fs.com">legal@fs.com</a>.</p>
			        				<p class="sd_txt note">ご注意： <br>FS.COMはチェックアウト時"自分の配送口座を使用する" オプションも提供しています。お客様がDHL、Fedex、UPSまたは他の配送業者のアカウントやレートをお持ち、それにご自分のアカウントやレートを利用したい時、一つのキャリア、配送サービス、および対応の配送番号を入力するだけです。この状況には、FS.COMは手数料を受けておりません。 <br>各配送方法の送料はお客様のショッピングカートの商品の累積重量または商品の寸法に基づいて請求されます。FS.COMはお客様に隠された注文料金を請求しておりません。また、全ての注文は標準包装方法でパッケージされており、安全のために十分なパディングと丈夫なボックスを利用する際に、必要以上の重くはないようにします。 <br>ドイツ倉庫に在庫がないアイテムについて、当社の世界倉庫から国際DHLサービスで配送されます。全世界190か国以上の主要地域の国際拠点に向けてグローバル配送も提供致します。地元の情報と数年間の多国籍な物流経験を組み合わせて、FS.COMは一貫したサービス、プロフェッショナル商品履行度、迅速な配送と統合的なプロジェクト ソリューションが提供できます、お客様の目標達成に役立ち、全世界の技術調達、導入、統合に伴っての複雑性とコストも低減します。</p>
			        			</div>	
			        		</div>
			        	</div>
			        </div>
			        
		        </div>
		        <div class="shipping_way">
				    <ul>
				        <li><img src="http://www.fs.com/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon01.jpg" alt="Fs shipping_way_icon01.jpg"><p>1－3営業日以内</p></li>
				        <li><img src="http://www.fs.com/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon02.jpg" alt="Fs shipping_way_icon02.jpg"><p>1－3営業日以内</p></li>
				        <li><img src="http://www.fs.com/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon03.jpg" alt="Fs shipping_way_icon03.jpg"><p>1-4営業日以内</p></li>
				        <li><img src="http://www.fs.com/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon04.jpg" alt="Fs shipping_way_icon04.jpg"><p>2-5営業日以内</p></li>
				        <li><img src="http://www.fs.com/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon05.jpg" alt="Fs shipping_way_icon05.jpg"><p>3-7営業日以内</p></li>
				    </ul>
				</div>
</div>
</div>	
<script>
		setTimeout(function(){
			$('.sd_time_bg').height($('.sd_time').outerHeight());
		});
		$('.sd_tab_choose_con').click(function(){
			$(this).addClass('choose').siblings().removeClass('choose');
			var oIndex = $(this).index();
			$('.sd_tab_con').eq(oIndex).show().siblings().hide();
		});
		$('.sd_time_tab_choose').click(function(){
			$(this).addClass('choose').siblings().removeClass('choose');
			var oIndex = $(this).index();
			$('.sd_time_show_con').eq(oIndex).show().siblings().hide();
			setTimeout(function(){
				$('.sd_time_bg').height($('.sd_time').outerHeight());
			});
		})
	</script>