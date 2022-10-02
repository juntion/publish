<?php

/**
 * by rebirth 2019/10/10
 * sfpOpticalModule 专题页面速度优化
 *
 * Class sfpOpticalModule
 */
class sfpOpticalModule
{
    /**
     * @var 仓库
     */
    private $warehouse;

    /**
     * @var 页面上的第几个表格
     */
    private $table = 0;

    public function __construct()
    {
        $this->warehouse = strtoupper(get_warehouse_by_code($_SESSION['countries_iso_code']));
        require_once(DIR_WS_CLASSES . 'shipping_info.php');
    }

    public function getAllHtml()
    {
        if (!$this->checkTable()) {
            return '';
        }
        $num = 0;
        $table = $this->getTableData();
        $all_qty = ['all_qty' => 0, 'us_qty' => 0, 'au_qty' => 0, 'eu_qty' => 0, 'cn_qty' => 0];
        $set = $this->getSet();
        $type = $set["type"];
        $class = $set["class"];
        $title = $set["title"];
        $leftTable = $center = $rightTable = '<table cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="20%">' . FS_SFP_OPTICAL8 . '</th>
                                            <th width="50%">' . FS_SFP_OPTICAL9 . '</th>
                                            <th width="30%">' . FS_SFP_OPTICAL11 . '</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        foreach ($table as $key => $item) {
            $num = $key;
            $display = '';
            if ($num > 23 && !is_mobile_request()){
                $display = 'class="btn_hide"';
            }
            $href = zen_href_link('product_info', 'products_id=' . (int)$item['id']);
            if (isset($item["channel"])) {
                $length = $item["length"] . '(' . $item["channel"] . ')';
            } else {
                $length = $item["length"];
            }

            $shippingInfo = new ShippingInfo(array('pid' => $item['id']));
            $country_qty = $shippingInfo->get_all_country_qty();
            if ($shippingInfo->get_qty() == 0) {
                $stock = zen_get_products_channel_number_qty($country_qty['6']);
                $stockHide = $shippingInfo->get_10g_sfp_optical_qty(1,false);
            } else {
                $stock = zen_get_products_channel_number_qty($shippingInfo->get_qty());
                $stockHide = $shippingInfo->get_10g_sfp_optical_qty(2);
            }
            $all_qty['all_qty'] += $country_qty['0'];
            $all_qty['us_qty'] += $country_qty['3'];
            $all_qty['eu_qty'] += $country_qty['2'];
            $all_qty['au_qty'] += $country_qty['37'];
            $all_qty['cn_qty'] += $country_qty['6'];
            $all_qty['sg_qty'] += $country_qty['71'];
            $content = '<tr '.$display.'>
                        <td>
                            <a href="' . $href . '">' . (int)$item['id'] . '</a>
                        </td>
                        <td>
                            ' . $length . '
                        </td>
                        <td class="stock">
                            <div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                                <span></span>
                                <em>
                                    ' . $stock . '
                                </em>
                                <div class="new_m_bg1"></div>
						        <div class="new_m_bg_wap">
                                ' . $stockHide . '
                                </div>
                            </div>
                        </td>
                   </tr>';
            if ($key % 3 == 0) {
                $leftTable .= $content;
            } else if ($key % 3 == 1) {
                $center .= $content;
            } else{
                $rightTable .= $content;
            }
        }
        if ($key % 3 == 1) {
            $rightTable .= '<tr style="height: 41px;">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
        }

        $leftTable .= "</tbody></table>";
        $rightTable .= "</tbody></table>";
        $show_html =  '';
        if ($num > 23) {
            $show_html = '<div class="new10gSfp-more-box show_btn">
						    	<div class="new10gSfp-more-btn"><span>'.FS_SFP_OPTICAL91.'</span><i class="iconfont icon">&#xf087;</i></div>
						    </div>
						    <div class="new10gSfp-more-box hide_btn" style="display:none;">
						    	<div class="new10gSfp-more-btn"><span>'.FS_SFP_OPTICAL92.'</span><i class="iconfont icon">&#xf088;</i></div>
						    </div>';
        }
        return '<div id="table' . $this->table . '" class="new_10g_table_main_table_main after">
                <div class="new_10g_table_main_table_main_overflow">
                    <div class="new_10g_table_main_table_tit ' . $class . '">
                         ' . $title . $this->getWarehouseStockHtml($all_qty) . '
                    </div> 
                    <div class="new10gSfp-table-mainBox">
                    <div class="new10gSfp-table-main after">
                    <div class="new10gSfp-copyHead">
                        <span width="20%">ID</span>
                        <span width="50%">Wavelength (nm)</span>
                        <span width="30%">Stock</span>
                    </div>
                    ' . $leftTable .$center . $rightTable . ' 
                    </div>
                    </div>'.$show_html.'
                </div> 
             </div>';

    }

    /**
     * 设置要获取的第几个表格
     *
     * @param $num
     */
    public function setTable($num)
    {
        $this->table = $num;
    }

    /**
     * 检测是否在获取的数据范围内
     *
     * @return bool
     */
    public function checkTable()
    {
        return in_array($this->table, [1, 2, 3, 4, 5, 6]);
    }

    /**
     * by rebirth   2019/09/24
     * 获取要查询的数据
     *
     * @param $whichTable
     * @return array
     */
    private function getTableData()
    {
        switch ($this->table) {
            case 1:
                return array(
                    array('id' => 45567, 'length' => 1563.86, 'channel' => 'C17'), array('id' => 31227, 'length' => 1551.72, 'channel' => 'C32'), array('id' => 31212, 'length' => 1539.77, 'channel' => 'C47'),
                    array('id' => 45566, 'length' => 1563.05, 'channel' => 'C18'), array('id' => 31226, 'length' => 1550.92, 'channel' => 'C33'), array('id' => 31211, 'length' => 1538.98, 'channel' => 'C48'),
                    array('id' => 45565, 'length' => 1562.23, 'channel' => 'C19'), array('id' => 31225, 'length' => 1550.12, 'channel' => 'C34'), array('id' => 31210, 'length' => 1538.19, 'channel' => 'C49'),
                    array('id' => 31239, 'length' => 1561.41, 'channel' => 'C20'), array('id' => 31224, 'length' => 1549.32, 'channel' => 'C35'), array('id' => 31209, 'length' => 1537.40, 'channel' => 'C50'),
                    array('id' => 31238, 'length' => 1560.61, 'channel' => 'C21'), array('id' => 31223, 'length' => 1548.51, 'channel' => 'C36'), array('id' => 31208, 'length' => 1536.61, 'channel' => 'C51'),
                    array('id' => 31237, 'length' => 1559.79, 'channel' => 'C22'), array('id' => 31222, 'length' => 1547.72, 'channel' => 'C37'), array('id' => 31202, 'length' => 1535.82, 'channel' => 'C52'),
                    array('id' => 31236, 'length' => 1558.98, 'channel' => 'C23'), array('id' => 31221, 'length' => 1546.92, 'channel' => 'C38'), array('id' => 31203, 'length' => 1535.04, 'channel' => 'C53'),
                    array('id' => 31235, 'length' => 1558.17, 'channel' => 'C24'), array('id' => 31220, 'length' => 1546.12, 'channel' => 'C39'), array('id' => 31201, 'length' => 1534.25, 'channel' => 'C54'),
                    array('id' => 31234, 'length' => 1557.36, 'channel' => 'C25'), array('id' => 31219, 'length' => 1545.32, 'channel' => 'C40'), array('id' => 31207, 'length' => 1533.47, 'channel' => 'C55'),
                    array('id' => 31233, 'length' => 1556.55, 'channel' => 'C26'), array('id' => 31218, 'length' => 1544.53, 'channel' => 'C41'), array('id' => 31206, 'length' => 1532.68, 'channel' => 'C56'),
                    array('id' => 31232, 'length' => 1555.75, 'channel' => 'C27'), array('id' => 31217, 'length' => 1543.73, 'channel' => 'C42'), array('id' => 31205, 'length' => 1531.90, 'channel' => 'C57'),
                    array('id' => 31231, 'length' => 1554.94, 'channel' => 'C28'), array('id' => 31216, 'length' => 1542.94, 'channel' => 'C43'), array('id' => 31204, 'length' => 1531.12, 'channel' => 'C58'),
                    array('id' => 31230, 'length' => 1554.13, 'channel' => 'C29'), array('id' => 31215, 'length' => 1542.14, 'channel' => 'C44'), array('id' => 31199, 'length' => 1530.33, 'channel' => 'C59'),
                    array('id' => 31229, 'length' => 1553.33, 'channel' => 'C30'), array('id' => 31214, 'length' => 1541.35, 'channel' => 'C45'), array('id' => 45564, 'length' => 1529.55, 'channel' => 'C60'),
                    array('id' => 31228, 'length' => 1552.52, 'channel' => 'C31'), array('id' => 31213, 'length' => 1540.56, 'channel' => 'C46'), array('id' => 45563, 'length' => 1528.77, 'channel' => 'C61'),
                );
                break;
            case 2:
                return array(
                    array('id' => 48344, 'length' => 1563.86, 'channel' => 'C17'), array('id' => 38767, 'length' => 1551.72, 'channel' => 'C32'), array('id' => 38764, 'length' => 1539.77, 'channel' => 'C47'),
                    array('id' => 48343, 'length' => 1563.05, 'channel' => 'C18'), array('id' => 38743, 'length' => 1550.92, 'channel' => 'C33'), array('id' => 38736, 'length' => 1538.98, 'channel' => 'C48'),
                    array('id' => 48342, 'length' => 1562.23, 'channel' => 'C19'), array('id' => 38756, 'length' => 1550.12, 'channel' => 'C34'), array('id' => 38753, 'length' => 1538.19, 'channel' => 'C49'),
                    array('id' => 38755, 'length' => 1561.41, 'channel' => 'C20'), array('id' => 38740, 'length' => 1549.32, 'channel' => 'C35'), array('id' => 38745, 'length' => '1537.40', 'channel' => 'C50'),
                    array('id' => 38731, 'length' => 1560.61, 'channel' => 'C21'), array('id' => 38759, 'length' => 1548.51, 'channel' => 'C36'), array('id' => 38761, 'length' => 1536.61, 'channel' => 'C51'),
                    array('id' => 38747, 'length' => 1559.79, 'channel' => 'C22'), array('id' => 38735, 'length' => 1547.72, 'channel' => 'C37'), array('id' => 38757, 'length' => 1535.82, 'channel' => 'C52'),
                    array('id' => 38739, 'length' => 1558.98, 'channel' => 'C23'), array('id' => 38732, 'length' => 1546.92, 'channel' => 'C38'), array('id' => 38746, 'length' => 1535.04, 'channel' => 'C53'),
                    array('id' => 38763, 'length' => 1558.17, 'channel' => 'C24'), array('id' => 38751, 'length' => 1546.12, 'channel' => 'C39'), array('id' => 38738, 'length' => 1534.25, 'channel' => 'C54'),
                    array('id' => 38749, 'length' => 1557.36, 'channel' => 'C25'), array('id' => 38733, 'length' => 1545.32, 'channel' => 'C40'), array('id' => 38769, 'length' => 1533.47, 'channel' => 'C55'),
                    array('id' => 38734, 'length' => 1556.55, 'channel' => 'C26'), array('id' => 38752, 'length' => 1544.53, 'channel' => 'C41'), array('id' => 38737, 'length' => 1532.68, 'channel' => 'C56'),
                    array('id' => 38750, 'length' => 1555.75, 'channel' => 'C27'), array('id' => 38765, 'length' => 1543.73, 'channel' => 'C42'), array('id' => 38762, 'length' => '1531.90', 'channel' => 'C57'),
                    array('id' => 38766, 'length' => 1554.94, 'channel' => 'C28'), array('id' => 38768, 'length' => 1542.94, 'channel' => 'C43'), array('id' => 38770, 'length' => 1531.12, 'channel' => 'C58'),
                    array('id' => 38742, 'length' => 1554.13, 'channel' => 'C29'), array('id' => 38744, 'length' => 1542.14, 'channel' => 'C44'), array('id' => 38754, 'length' => 1530.33, 'channel' => 'C59'),
                    array('id' => 38748, 'length' => 1553.33, 'channel' => 'C30'), array('id' => 38760, 'length' => 1541.35, 'channel' => 'C45'), array('id' => 48341, 'length' => 1529.55, 'channel' => 'C60'),
                    array('id' => 38758, 'length' => 1552.52, 'channel' => 'C31'), array('id' => 38741, 'length' => 1540.56, 'channel' => 'C46'), array('id' => 48340, 'length' => 1528.77, 'channel' => 'C61'),
                );
                break;
            case 3:
                return array(
                    array('id' => 19367, 'length' => 1470), array('id' => 19370, 'length' => 1530), array('id' => 19373, 'length' => 1590),
                    array('id' => 19368, 'length' => 1490), array('id' => 19371, 'length' => 1550), array('id' => 19374, 'length' => 1610),
                    array('id' => 19369, 'length' => 1510), array('id' => 19372, 'length' => 1570),
                );
                break;
            case 4:
                return array(
                    array('id' => 22168, 'length' => 1270), array('id' => 31295, 'length' => 1390), array('id' => 15383, 'length' => 1510),
                    array('id' => 31290, 'length' => 1290), array('id' => 31296, 'length' => 1410), array('id' => 15378, 'length' => 1530),
                    array('id' => 31291, 'length' => 1310), array('id' => 31297, 'length' => 1430), array('id' => 15382, 'length' => 1550),
                    array('id' => 31292, 'length' => 1330), array('id' => 31298, 'length' => 1450), array('id' => 19362, 'length' => 1570),
                    array('id' => 31293, 'length' => 1350), array('id' => 15385, 'length' => 1470), array('id' => 15380, 'length' => 1590),
                    array('id' => 31294, 'length' => 1370), array('id' => 15379, 'length' => 1490), array('id' => 15384, 'length' => 1610)
                );
                break;
            case 5:
                return array(
                    array('id' => 38699, 'length' => 1270), array('id' => 38705, 'length' => 1390), array('id' => 44999 , 'length' => 1510),
                    array('id' => 38701, 'length' => 1290), array('id' => 38704, 'length' => 1410), array('id' => 45000, 'length' => 1530),
                    array('id' => 38700, 'length' => 1310), array('id' => 38703, 'length' => 1430), array('id' => 45001, 'length' => 1550),
                    array('id' => 38702, 'length' => 1330), array('id' => 38707, 'length' => 1450), array('id' => 45002, 'length' => 1570),
                    array('id' => 38706, 'length' => 1350), array('id' => 44997, 'length' => 1470), array('id' => 45003, 'length' => 1590),
                    array('id' => 38708, 'length' => 1370), array('id' => 44998 , 'length' => 1490), array('id' => 45004, 'length' => 1610)
                );
                break;
            case 6:
                return array(
                    array('id' => 64476, 'length' => 1270), array('id' => 64482, 'length' => 1390), array('id' => 64488, 'length' => 1510),
                    array('id' => 64477, 'length' => 1290), array('id' => 64483, 'length' => 1410), array('id' => 64489, 'length' => 1530),
                    array('id' => 64478, 'length' => 1310), array('id' => 64484, 'length' => 1430), array('id' => 64490, 'length' => 1550),
                    array('id' => 64479, 'length' => 1330), array('id' => 64485, 'length' => 1450), array('id' => 64491, 'length' => 1570),
                    array('id' => 64480, 'length' => 1350), array('id' => 64486, 'length' => 1470), array('id' => 64492, 'length' => 1590),
                    array('id' => 64481, 'length' => 1370), array('id' => 64487, 'length' => 1490), array('id' => 64493, 'length' => 1610)
                );
                break;
            default:
                return array();
        }
    }

    /**
     * 获取表格里的type值
     * @return array
     */
    private function getSet()
    {
        $types = [
            1 => [
                'title' => FS_SFP_OPTICAL50,
                'type'  => FS_SFP_OPTICAL55,
                'class' => 'first',
            ],
            2 => [
                'title' => FS_SFP_OPTICAL51,
                'type'  => FS_SFP_OPTICAL56,
                'class' => 'second',
            ],
            3 => [
                'title' => FS_SFP_OPTICAL52,
                'type'  => FS_SFP_OPTICAL57,
                'class' => 'third',
            ],
            4 => [
                'title' => FS_SFP_OPTICAL53,
                'type'  => FS_SFP_OPTICAL58,
                'class' => 'fourth',
            ],
            5 => [
                'title' => FS_SFP_OPTICAL108,
                'type'  => FS_SFP_OPTICAL107,
                'class' => 'fifth',
            ],
            6 => [
                'title' => FS_SFP_OPTICAL54,
                'type'  => FS_SFP_OPTICAL59,
                'class' => 'sixth',
            ],

        ];
        return $types[$this->table];
    }

    /**
     * by rebirth 2019/09/24
     * 获取总库存
     * @param $all_qty array
     * @return string
     */
    private function getWarehouseStockHtml($all_qty)
    {
        switch ($this->warehouse) {
            case 'US':
                $sort = ['us_qty','cn_qty',];
                break;
            case 'DE':
                $sort = ['eu_qty','cn_qty'];
                break;
            case 'AU':
                $sort = ['au_qty', 'cn_qty'];
                break;
            case 'CN':
                $sort = ['cn_qty'];
                break;
            case 'SG':
                $sort = ['sg_qty', 'cn_qty'];
                break;
            default :
                return "";
                break;
        }
        foreach ($sort as $item) {
            $all_qty[$item] = (isset($all_qty[$item]) && $all_qty[$item] > 0) ? $all_qty[$item] : '';
        }
        $data = [
            "us_qty" => [
                "num"       => $all_qty['us_qty'],
                "detail"    => zen_get_products_channel_number_qty($all_qty['us_qty'], 2),
                "warehouse" => FS_WAREHOUSE_US
            ],
            "au_qty" => [
                "num"       => $all_qty['au_qty'],
                "detail"    => zen_get_products_channel_number_qty($all_qty['au_qty'], 2),
                "warehouse" => FS_WAREHOUSE_AU
            ],
            "eu_qty" => [
                "num"       => $all_qty['eu_qty'],
                "detail"    => zen_get_products_channel_number_qty($all_qty['eu_qty'], 2),
                "warehouse" => FS_WAREHOUSE_EU
            ],
            "cn_qty" => [
                "num"       => $all_qty['cn_qty'],
                "detail"    => zen_get_products_channel_number_qty($all_qty['cn_qty'], 2),
                "warehouse" => FS_CN_APAC
            ],
            "sg_qty" => [
                "num"       => $all_qty['sg_qty'],
                "detail"    => zen_get_products_channel_number_qty($all_qty['sg_qty'], 2),
                "warehouse" => FS_WAREHOUSE_SG
            ],
        ];
        $stock_html = '';

        $stock_html .='<div class="track_orders_wenhao m_track_orders_wenhao">
                    <div class="question_bg_icon iconfont icon"></div>
                    <div class="new_m_bg1"></div>
                    <div class="new_m_bg_wap">
                        <div class="question_text_01 leftjt">
                            <a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon"></i></a>
                            <div class="arrow"></div>
                            <div class="popover-content">';
        if ($data[$sort[1]]['num'] && $data[$sort[0]]['num'] > $data[$sort[1]]['num']) {
            $stock_html .= '<div class="arr_top">
                                        <i>·</i>
                                        <strong>' . $data[$sort[0]]['num'] . '</strong>
                                        <p>' . $data[$sort[0]]['detail'] . FS_EMAIL_PAUSE . $data[$sort[0]]['warehouse'] . '</p>
                                    </div>';
            $stock_html .= '<div class="arr_top">
                                        <i>·</i>
                                        <strong>' . $data[$sort[1]]['num'] . '</strong>
                                        <p>' . $data[$sort[1]]['detail'] . FS_EMAIL_PAUSE . $data[$sort[1]]['warehouse'] . '</p>
                                    </div>';
        } else if ($data[$sort[1]]['num'] && $data[$sort[0]]['num'] < $data[$sort[1]]['num']) {
            $stock_html .= '<div class="arr_top">
                                        <i>·</i>
                                        <strong>' . $data[$sort[1]]['num'] . '</strong>
                                        <p>' . $data[$sort[1]]['detail'] . FS_EMAIL_PAUSE . $data[$sort[1]]['warehouse'] . '</p>
                                    </div>';
            $stock_html .= '<div class="arr_top">
                                        <i>·</i>
                                        <strong>' . $data[$sort[0]]['num'] . '</strong>
                                        <p>' . $data[$sort[0]]['detail'] . FS_EMAIL_PAUSE . $data[$sort[0]]['warehouse'] . '</p>
                                    </div>';
        } else {
            $stock_html .= '<div class="arr_top">
                                        <i>·</i>
                                        <strong>' . $data[$sort[0]]['num'] . '</strong>
                                        <p>' . $data[$sort[0]]['detail'] . FS_EMAIL_PAUSE . $data[$sort[0]]['warehouse'] . '</p>
                                    </div>';
        }
        $stock_html .='</div>
                        </div>
                    </div>
                </div>';
        return $stock_html;
    }

}