<?php

namespace App\Services\Address;

use App\Services\BaseService;
use App\Models\AddressBook;
use App\Models\Customer;
use App\Services\Country\CountryService;
use Illuminate\Database\Capsule\Manager;
use App\Models\CountriesToZipNew;
use App\Models\ShippingAuCode;
use App\Models\FsShippingSamedayPost;

class AddressBookService extends BaseService
{

    private $addressObj; // address_book

    private $customerObj; // customers

    protected $countryObj; // country service

    protected $countriesZip;

    protected $shippingAuCode;

    protected $shippingPost;

    // 地址列表需要查询的字段
    protected $address_fields = [
        'address_book_id', 'address_type', 'company_type', 'entry_company', 'entry_firstname', 'entry_lastname',
        'entry_street_address', 'entry_suburb', 'entry_postcode', 'entry_city', 'entry_telephone', 'entry_state',
        'entry_tax_number', 'entry_country_id', 'ticket_number'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->addressObj = new AddressBook();
        $this->customerObj = new Customer();
        $this->countryObj = new CountryService();
    }

    /**
     * @param string $order_by 排序规则
     * @return mixed
     * @author potato
     * @time 2019-11-11
     *  获取所有地址列表
     */
    public function getAddressBook($order_by = '')
    {
        $id = $this->customer_id;
        // 默认地址对应的id
        $default_address_ids = $this->getDefaultAddress();
        $shipping_addresses_ids = isset($default_address_ids) ? array_values($default_address_ids) : [];
        $arr = $this->getAddressList($order_by);
        // 没有地址的时候返回空
        if (!$arr) {
            return [];
        }
        // 查询国家相对应的名称tel_prefix、countries_name
        $country_ids = $this->arrayColumnNew($arr, 'entry_country_id');
        $countries_ids = array_unique($country_ids);
        // 查询所需要的tel_prefix、countries_iso_code_2、countries_name
        $code_name = $this->countryObj->countriesTelCode($countries_ids);
        $address_default = [];
        $shipping_default = '';
        $shipping_default_arr = [];
        // 获取数组的key进行分类
        foreach ($arr as $k => $v) {
            if ($v['address_type'] !== 2) {
                $address_default['shipping'][$k]['address_book_id'] = $v['address_book_id'];
                $address_default['shipping'][$k]['address_type'] = $v['address_type'];
                $address_default['shipping'][$k]['company_type'] = $v['company_type'];
                $address_default['shipping'][$k]['entry_company'] = $v['entry_company'] ? $v['entry_company'] : '';
                $address_default['shipping'][$k]['entry_firstname'] = $v['entry_firstname'];
                $address_default['shipping'][$k]['entry_lastname'] = $v['entry_lastname'];
                $address_default['shipping'][$k]['entry_street_address'] = $v['entry_street_address'];
                $address_default['shipping'][$k]['entry_suburb'] = $v['entry_suburb'] ? $v['entry_suburb'] : '';
                $address_default['shipping'][$k]['entry_postcode'] = $v['entry_postcode'];
                $address_default['shipping'][$k]['entry_city'] = $v['entry_city'];
                $address_default['shipping'][$k]['entry_telephone'] = $v['entry_telephone'];
                $address_default['shipping'][$k]['entry_tax_number'] = $v['entry_tax_number'];
                $address_default['shipping'][$k]['entry_country_id'] = $v['entry_country_id'];
                $address_default['shipping'][$k]['tel_prefix'] =
                    $code_name['countries_id_tel'][$v['entry_country_id']];
                $address_default['shipping'][$k]['entry_country_name'] =
                    $code_name['countries_id_name'][$v['entry_country_id']];
                $address_default['shipping'][$k]['country_code'] =
                    strtolower($code_name['countries_id_code'][$v['entry_country_id']]);
                $address_default['shipping'][$k]['entry_state'] = $v['entry_state'];
//                $address_default['shipping'][$k]['ticket_number'] = $v['ticket_number'];
//                if ($v['entry_country_id'] == 223 && $v['entry_state']) {
//                    $address_default['shipping'][$k]['entry_state'] =
// $code_name['countries_code_state'][$v['entry_state']];
//                }
                // 添加默认地址标记
                if ($v['address_book_id'] == $default_address_ids['customers_default_address_id']) {
                    $address_default['shipping'][$k]['default_address'] = 1;
                    $shipping_default = $k;
                    $shipping_default_arr = $address_default['shipping'][$k];
                }
            } else {
                $address_default['billing'][$k]['address_book_id'] = $v['address_book_id'];
                $address_default['billing'][$k]['address_type'] = $v['address_type'];
                $address_default['billing'][$k]['company_type'] = $v['company_type'];
                $address_default['billing'][$k]['entry_company'] = $v['entry_company'] ? $v['entry_company'] : '';
                $address_default['billing'][$k]['entry_firstname'] = $v['entry_firstname'];
                $address_default['billing'][$k]['entry_lastname'] = $v['entry_lastname'];
                $address_default['billing'][$k]['entry_street_address'] = $v['entry_street_address'];
                $address_default['billing'][$k]['entry_suburb'] = $v['entry_suburb'] ? $v['entry_suburb'] : '';
                $address_default['billing'][$k]['entry_postcode'] = $v['entry_postcode'];
                $address_default['billing'][$k]['entry_city'] = $v['entry_city'];
                $address_default['billing'][$k]['entry_telephone'] = $v['entry_telephone'];
                $address_default['billing'][$k]['entry_tax_number'] = $v['entry_tax_number'];
                $address_default['billing'][$k]['entry_country_id'] = $v['entry_country_id'];
                $address_default['billing'][$k]['tel_prefix'] =
                    $code_name['countries_id_tel'][$v['entry_country_id']];
                $address_default['billing'][$k]['entry_country_name'] =
                    $code_name['countries_id_name'][$v['entry_country_id']];
                $address_default['billing'][$k]['country_code'] =
                    strtolower($code_name['countries_id_code'][$v['entry_country_id']]);
                $address_default['billing'][$k]['entry_state'] = $v['entry_state'];
//                $address_default['billing'][$k]['ticket_number'] = $v['ticket_number'];
//                if ($v['entry_country_id'] == 223) {
//                    $address_default['billing'][$k]['entry_state'] =
// $code_name['countries_code_state'][$v['entry_state']];
//                }
                // 添加默认地址标记
                if ($v['address_book_id'] == $default_address_ids['customers_default_billing_address_id']) {
                    $address_default['billing'][$k]['default_address'] = 1;
                    $billing_default = $k;
                    $billing_default_arr = $address_default['billing'][$k];
                }
            }
        }
        // 对数组进行排序
        if ($address_default['shipping'] && $shipping_default) {
            unset($address_default['shipping'][$shipping_default]);
            array_unshift($address_default['shipping'], $shipping_default_arr);
        }
//        if ($address_default['billing']){
//            unset($address_default['billing'][$billing_default]);
//            array_unshift($address_default['billing'], $billing_default_arr);
//        }
        return $address_default;
    }

    /**
     * @param $address_book_id 地址id
     * @param $address_type 地址类型
     * @return bool
     * 删除地址
     * @author potato
     */
    public function deleteAddressBook($address_book_id)
    {
        // 是否是默认地址
        $default_ids = $this->getDefaultAddress();
        $field = '';
        if ($address_book_id == $default_ids['customers_default_address_id']) {
            $field = 'customers_default_address_id';
        }
        if ($address_book_id == $default_ids['customers_default_billing_address_id']) {
            $field = 'customers_default_billing_address_id';
        }
        // $field用于判断是否需要修改customer表的默认地址id
        if ($field) {
            // 删除默认地址
            Manager::connection()->beginTransaction();
            try {
                // 修改默认地址
                $this->customerObj->where('customers_id', $this->customer_id)->update([$field => 0]);
                // 删除地址
                $this->addressObj->where([
                    'address_book_id' => $address_book_id,
                ])->delete();
                Manager::connection()->commit();
            } catch (\Exception $e) {
                Manager::connection()->rollBack();
                return false;
            }
        } else {
            // 删除普通地址
            $res = $this->addressObj->where([
                'address_book_id' => $address_book_id,
            ])->delete();
            if (!$res) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $address_id
     * @param $address_type
     * @param $customer_id
     * @return bool
     * 设为默认地址
     * @author potato
     */
    public function selectAddressBook($address_id, $address_type, $customer_id)
    {
        if ($address_type !== 2) {
            $field = 'customers_default_address_id';
        } else {
            $field = 'customers_default_billing_address_id';
        }
        $result = $this->customerObj->where([
            'customers_id' => $this->customer_id
        ])->update([$field => $address_id]);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * 新增地址
     * @return bool
     * @throws \Exception
     * @author potato
     */
    public function createNewAddress($data)
    {
        // 查询是否存在地址，不存在地址把插入的设置为默认地址
        $default_address = $this->getDefaultAddress();
        if ($data['address_type'] != 2) {
            $default_address_id = $default_address['customers_default_address_id'];
        } else {
            $default_address_id = $default_address['customers_default_billing_address_id'];
        }
        // 有地址则新增即可，没有地址设为默认地址
        if ($default_address_id) {
            $res = $this->createNewAdds($data);
        } else {
            $res = $this->createNewDefaultAdds($data);
        }
        if ($res) {
            return $res;
        }
        return false;
    }

    /**
     * 修改地址
     * @param $data
     * @param $address_id
     * @return bool
     * @author potato
     */
    public function updateAddress($data, $address_id)
    {
        $res = $this->addressObj->where([
            'address_book_id' => $address_id,
            'customers_id' => $this->customer_id,
        ])->update($data);
        $new_res = $this->getAddressInfo([
            'address_book_id' => $address_id,
            'customers_id' => $this->customer_id,
        ], $this->address_fields);
        if ($res) {
            $code_name = $this->countryObj->countriesTelCode([$new_res[0]['entry_country_id']]);
            $res = [
                'address_book_id' => $address_id,
                'address_type' => $new_res[0]['address_type'],
                'company_type' => $new_res[0]['company_type'],
                'entry_company' => $new_res[0]['entry_company'],
                'entry_firstname' => $new_res[0]['entry_firstname'],
                'entry_lastname' => $new_res[0]['entry_lastname'],
                'entry_street_address' => $new_res[0]['entry_street_address'],
                'entry_suburb' => $new_res[0]['entry_suburb'],
                'entry_postcode' => $new_res[0]['entry_postcode'],
                'entry_city' => $new_res[0]['entry_city'],
                'entry_telephone' => $new_res[0]['entry_telephone'],
                'entry_state' => $new_res[0]['entry_state'],
                'entry_tax_number' => $new_res[0]['entry_tax_number'],
                'entry_country_id' => $new_res[0]['entry_country_id'],
                'customers_id' => $new_res[0]['address_book_id'],
                'tel_prefix' => $code_name['countries_id_tel'][$new_res[0]['entry_country_id']],
                'entry_country_name' => $code_name['countries_id_name'][$new_res[0]['entry_country_id']],
                'country_code' => strtolower($code_name['countries_id_code'][$new_res[0]['entry_country_id']])
                //'ticket_number' => $new_res[0]['ticket_number']
            ];
            return $res;
        }
        return false;
    }

    /**
     * @param $data
     * 插入新地址
     * @return bool
     * @author
     */
    public function createNewAdds($data)
    {
        // 直接插入一个新地址
        $res1 = $this->addressObj->create($data);
        if ($res1) {
            $code_name = $this->countryObj->countriesTelCode([$res1->entry_country_id]);
            $res = [
                'address_book_id' => $res1->address_book_id,
                'address_type' => $res1->address_type,
                'company_type' => $res1->company_type,
                'entry_company' => $res1->entry_company,
                'entry_firstname' => $res1->entry_firstname,
                'entry_lastname' => $res1->entry_lastname,
                'entry_street_address' => $res1->entry_street_address,
                'entry_suburb' => $res1->entry_suburb,
                'entry_postcode' => $res1->entry_postcode,
                'entry_city' => $res1->entry_city,
                'entry_telephone' => $res1->entry_telephone,
                'entry_state' => $res1->entry_state,
                'entry_tax_number' => $res1->entry_tax_number,
                'entry_country_id' => $res1->entry_country_id,
                'customers_id' => $res1->customers_id,
                'tel_prefix' => $code_name['countries_id_tel'][$res1->entry_country_id],
                'entry_country_name' => $code_name['countries_id_name'][$res1->entry_country_id],
                'country_code' => strtolower($code_name['countries_id_code'][$res1->entry_country_id])
                //'ticket_number' => $res1->ticket_number
            ];
//            if ($res1->entry_country_id == 223) {
//                $res['entry_state'] = $code_name['countries_code_state'][$res1->entry_country_id];
//            }
            return $res;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     * 插入并设为默认地址
     * @throws \Exception
     */
    public function createNewDefaultAdds($data)
    {
        if ($data['address_type'] != 2) {
            $field = 'customers_default_address_id';
        } else {
            $field = 'customers_default_billing_address_id';
        }
        $res1 = '';
        Manager::connection()->beginTransaction();
        try {
            $res1 = $this->addressObj->create($data);
            $res2 = $this->customerObj->where('customers_id', $this->customer_id)
                ->update([
                    $field => $res1['address_book_id'],
                ]);
        } catch (\Exception $e) {
            Manager::connection()->rollBack();
            return '';
        }
        Manager::connection()->commit();
        $code_name = $this->countryObj->countriesTelCode([$res1->entry_country_id]);
        $data = [
            'address_book_id' => $res1->address_book_id,
            'address_type' => $res1->address_type,
            'company_type' => $res1->company_type,
            'entry_company' => $res1->entry_company,
            'entry_firstname' => $res1->entry_firstname,
            'entry_lastname' => $res1->entry_lastname,
            'entry_street_address' => $res1->entry_street_address,
            'entry_suburb' => $res1->entry_suburb,
            'entry_postcode' => $res1->entry_postcode,
            'entry_city' => $res1->entry_city,
            'entry_telephone' => $res1->entry_telephone,
            'entry_state' => $res1->entry_state,
            'entry_tax_number' => $res1->entry_tax_number,
            'entry_country_id' => $res1->entry_country_id,
            'customers_id' => $this->customer_id,
            'is_default' => 1,
            'tel_prefix' => $code_name['countries_id_tel'][$res1->entry_country_id],
            'entry_country_name' => $code_name['countries_id_name'][$res1->entry_country_id],
            'country_code' => strtolower($code_name['countries_id_code'][$res1->entry_country_id])
            //'ticket_number' => $res1->ticket_number
        ];
        if ($res1->entry_country_id == 223) {
            $res['entry_state'] = $code_name['countries_code_state'][$res1->entry_country_id];
        }
        return $data;
    }

    /**
     * @return mixed
     * @author potato
     *  默认填写的地址
     */
    public function getDefaultAddress()
    {
        $default_address_info = [];
        $default_address = $this->customerObj->where('customers_id', $this->customer_id)->first(
            ['customers_default_address_id',
            'customers_default_billing_address_id']
        );
        $default_address_info = [
            'customers_default_address_id' => $default_address->customers_default_address_id,
            'customers_default_billing_address_id' => $default_address->customers_default_billing_address_id,
        ];
        return $default_address_info;
    }

    /**
     * @param $where
     * @param array $fields
     * @param string $limit  Yoyo 2019.12.30 新增  添加limit 限制  默认为空
     * @return mixed
     * 获取 address_book 表中的数据
     * @author potato
     */
    public function getAddressInfo($where, $fields = ['*'], $limit = '')
    {
        $address_info = [];
        $address_data = $this->addressObj
                        ->where($where);
        if ($limit) {
            $address_data = $address_data->limit($limit)
                            ->orderBy('address_book_id', 'desc');
        }
        $address_data = $address_data->get($fields);
        if ($address_data) {
            $address_info =  $address_data->toArray();
        }
        return $address_info;
    }

    /**
     * @return mixed
     * 查询所有的地址
     * @author
     */
    public function getAddressList($order_by = '')
    {
        $order_by = empty($order_by) ? 'desc' : 'asc';
        $arr = $this->addressObj->onWriteConnection()
            ->where('customers_id', $this->customer_id)
            ->whereNotIn('entry_country_id', $this->not_countries)
            ->orderBy('address_book_id', $order_by)
            ->get([
                'address_book_id', 'address_type', 'company_type', 'entry_company', 'entry_firstname', 'entry_lastname',
                'entry_street_address', 'entry_suburb', 'entry_postcode', 'entry_city', 'entry_telephone',
                'entry_state', 'entry_tax_number', 'entry_country_id', 'ticket_number'
            ])->toArray();
        return $arr;
    }

    /**
     * @param $data
     * @param string $default
     * @return string
     * 新增地址html
     * @author
     */
    public function addressHtml($data, $default = '')
    {
        $html = '';
        if ($data['address_type'] !== '2') {
            $class = ' address-book-shipping_' . $data['address_book_id'];
            $type = 0;
        } else {
            $class = ' address-book-billing_' . $data['address_book_id'];
            $type = 2;
        }
        if ($default) {
            $class_span = 'alone_a address-default default-address-click';
            $default_name = self::trans('FS_ADDRESS_DEFAULT');
        } else {
            $class_span = 'alone_a default-address-click';
            $default_name = self::trans('FS_CHECKOUT_NEW6');
        }
        $html .= '<dd class="address-book-taMain ' . $class . '">';

        $entry_company = $this->getCompany($data['entry_company']);
        $html .= '<div class="address-div-two">
                                    <p>' . $data['entry_firstname'] . ' ' . $data['entry_lastname'] . '</p>
                                    <p '.(strlen($data['entry_company'])>50 ? 'title="'.$data['entry_company'].'"' : '').'>' . $entry_company . '</p>
                                    <p>' . $data['entry_street_address'] . ', ' . $data['entry_suburb'] .
            ' ' . $data['entry_city'] . ' ' . $data['entry_state'] . ' ' . $data['entry_postcode'] .
            ' ' . $data['entry_country_name'] . '</p>
                                    <p>' . $data['tel_prefix'] . ' ' . $data['entry_telephone'] . '</p>
                                    <p>' . $data['entry_tax_number'] . '</p>
                                </div>
                                <div class="address-div-three">
                                    <div class="address-book-btnBox after">
                                        <a href="javascript:;"
                                         onclick="update_address(this, ' . $type . ',' . $data['address_book_id'] . ')"
                                          class="alone_a">
                                            '.self::trans('FS_EDIT').'
                                        </a>
                                        <a href="javascript:;" 
                                 onclick="delete_address_window(this, ' . $type . ',' . $data['address_book_id'] . ')"
                                         class="alone_a">
                                            '.self::trans('FS_REMOVE').'
                                        </a>
                                    </div>
                                </div>';
        if ($data['address_type'] !== '2') {
            $html .= '<div class="address-div-four">
                          <div class="address-book-btnBox after">
                                 <a href="javascript:void(0);" class="'.$class_span.'" onclick="select_default_address(this, ' . $data['address_book_id'] .')">'.$default_name.'</a>        
                          </div>
                      </div>';
        }
        $html .= '</dd>';
        return $html;
    }

    /**
     * Note: 公司超过50字符，展示50字符+...
     * @author: Dylan
     * @Date: 2020/7/21
     *
     * @param string $company
     * @return string
     */
    public function getCompany($company = '')
    {
        if (strlen($company) > 50) {
            $company = substr($company, 0, 50) . '...';
        }
        return $company;
    }

    /**
     * @param $data
     * @return string
     * 修改地址html
     * @author
     */
    public function addressHtmlUpdate($data)
    {
        $html = '';
        $html .= '<div class="address-div-two">
                                    <p>' . $data['entry_firstname'] . ' ' . $data['entry_lastname'] . '</p>
                                    <p '.(strlen($data['entry_company'])>50 ? 'title="'.$data['entry_company'].'"' : '').'>' . $this->getCompany($data['entry_company']) . '</p>
                                    <p>' . $data['entry_street_address'] . ', ' . $data['entry_suburb'] .
            ' ' . $data['entry_city'] . ' ' . $data['entry_state'] . ' ' .
            $data['entry_postcode'] . ' ' . $data['entry_country_name'] . '</p>
                                    <p>' . $data['tel_prefix'] . '' . $data['entry_telephone'] . '</p>
                                    <p>' . $data['entry_tax_number'] . '</p>
                                </div>';
        return $html;
    }

    /**
     * 新增一条地址数据
     * @param $data
     * @return mixed
     */
    public function insertOneAddress($data)
    {
        $obj = $this->addressObj->create($data);
        return $obj->address_book_id;
    }

    /**
     * 检验邮编
     * @param $country_id
     * @param $zip_code
     * @return array
     */
    public function isValidZipCode($country_id, $zip_code)
    {
        $this->countriesZip = new CountriesToZipNew();
        $this->shippingAuCode = new ShippingAuCode();
        $this->shippingPost = new FsShippingSamedayPost();
        $zip_data = $au_zip_data = [];
        $message = '';;
        $data = '';
        if ($country_id && $zip_code) {
            switch ($country_id) {
                case 223: //美国
                    $zip_info =  $this->countriesZip
                        ->select('zip','city','states')
                        ->where('zip', $zip_code)
                        ->first();
                    if (empty($zip_info)) {
                        $message = self::trans('FS_CHECKOUT_ERROR28');
                    }else{
                        $data = $zip_info;
                    }
                    break;
                case 13: //澳大利亚
                    $zip_info =  $this->shippingAuCode
                        ->select('id')
                        ->where('value', $zip_code)
                        ->where('type', 2)
                        ->first();
                    $check_flag = empty($zip_info) ? false : true;
                    if (!$check_flag) {
                        $zip_info =  $this->shippingAuCode
                            ->select('value')
                            ->where('type', 0)
                            ->get();
                        if (!empty($zip_info)) {
                            foreach ($zip_info->toArray() as $key => $value) {
                                $zip_data[][] = $value['value'];
                            }
                            $check_flag = self::checkAuZipCode($zip_code, $zip_data, ',');
                        }
                        if (!$check_flag) {
                            $zip_info =  $this->shippingAuCode->select('value')
                                ->where('type', 1)
                                ->get();
                            if (!empty($zip_info)) {
                                foreach ($zip_info->toArray() as $key => $value) {
                                    $au_zip_data[][] = $value['value'];
                                }
                                $check_flag = self::checkAuZipCode($zip_code, $au_zip_data, ':');
                            }
                        }
                    }
                    if (!$check_flag) {
                        $message = self::trans('FS_CHECKOUT_ERROR28_AU');
                    }
                    break;

                case 129:  //马来西亚
                    $zip_info =  $this->shippingPost
                        ->select('post_zip')
                        ->where('shipping_type', 4)
                        ->where('post_zip', $zip_code)
                        ->first();
                    if (empty($zip_info)) {
                        $message = self::trans('FS_CHECKOUT_ERROR28');
                    }
                    break;
            }
        }
        return $result = ['message'=>$message, 'data' => $data];
    }

    /**
     * Notes: 查询单条数据
     * User: LiYi
     * Date: 2020/6/30 0030
     * Time: 10:35
     * @param $addressId
     * @param string[] $fields
     * @param array $where
     * @return array
     */
    public function firstAddressBook($addressId, $fields = ["*"], $where = [])
    {
        try {
            $result = $this->addressObj->where('address_book_id', $addressId)
                ->where(function ($query) use ($where) {
                    if (!empty($where)) {
                        $query->where($where);
                    }
                })
                ->first($fields);
            if (empty($result)) {
                throw new \Exception("result is null!");
            }

            $result = $result->toArray();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    /**
     * $Notes: 检测用户操作地址权限
     *
     * $author: Quest
     * $Date: 2021/2/6
     * $Time: 11:26
     * @param $customers_id
     * @param $address_id
     * @return bool
     */
    public function checkPermissionAddress($customers_id, $address_id)
    {
        $res = $this->addressObj
            ->select('address_book_id')
            ->where('address_book_id', $address_id)
            ->where('customers_id', $customers_id)
            ->get();

        if($res->isEmpty()){
            return false;
        }else{
            return true;
        }
    }
}
