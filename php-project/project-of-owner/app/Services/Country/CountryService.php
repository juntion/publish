<?php


namespace App\Services\Country;

use App\Services\BaseService;
use App\Models\Country;
use App\Models\CountriesUsStates;
use App\Services\Common\Redis\RedisService;

class CountryService extends BaseService
{
    private $country_m;
    private $countriesCodeObj;
    public $currentCountry;
    protected $cachePrefix = 'globalCounties'; //redis 缓存 前缀
    protected $cacheKey = "counties"; // redis 缓存key
    protected $cachePrefixForStates = 'globalCountiesStates'; //redis 缓存 前缀
    protected $cacheKeyForStates = "countiesStates"; // redis 缓存key
    private $countries;
    private $countriesCode;

    // 查询国家语种对应的字段
    protected $countries_fields = [
        'countries_id',
        'tel_prefix',
        'countries_iso_code_2',
        'countries_name as en_countries_name',
    ];

    // 获取每个站点国家名称字段名,以便下面动态获取国家名称
    public $language_countries_name = [
        'de' => 'de_countries_name',
        'fr' => 'fr_countries_name',
        'ru' => 'ru_countries_name',
        'es' => 'es_countries_name',
        'jp' => 'jp_countries_name',
        'default' => 'countries_name',
        'it' => 'it_countries_name'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->country_m = new Country();
        $this->countriesCodeObj = new CountriesUsStates();
        //获取当前站点展示的国家名称站点
        $currentCountriesFields = $this->getCountriesNameFieldsBySite();
        array_push($this->countries_fields, $currentCountriesFields);
        $this->countries = $this->getCountries();
        $this->countriesCode = $this->getCountriesUsStates();
    }


    protected function get_default_countries()
    {
        //languages_code为语种的标识
        switch ($this->language_code) {
            case 'de':
            case 'dn':
                $default_countries = array(
                    81 => 'Germany',
                    14 => 'Austria',
                    204 => 'Switzerland',
                    124 => 'Luxembourg',
                    21 => 'Belgium',
                    105 => 'Italy',
                    122 => 'Liechtenstein',
                    150 => 'Netherlands',
                    57 => 'Denmark',
                );
                break;
            case 'fr':
                $default_countries = array(
                    73 => 'France',
                    38 => 'Canada',
                    21 => 'Belgium',
                    204 => 'Switzerland',
                    57 => 'Denmark',
                    141 => 'Monaco',
                    81 => 'Germany',
                    222 => 'United Kingdom',
                    195 => 'Spain',
                );
                break;
            case 'ru':
                $default_countries = array(
                    176 => 'Russian Federation',
                    220 => 'Ukraine',
                    109 => 'Kazakhstan',
                    117 => 'Latvia',
                    80 => 'Georgia',
                    123 => 'Lithuania',
                );
                break;
            case 'es':
            case 'mx':
                $default_countries = array(
                    195 => 'Spain',
                    250 => 'Canary Islands',
                    138 => 'Mexico',
                    223 => 'United States',
                    30 => 'Brazil',
                    47 => 'Colombia',
                    10 => 'Argentina',
                    43 => 'Chile',
                    167 => 'Peru',
                );
                break;
            case 'jp':
                $default_countries = array(
                    107 => 'Japan',
                    223 => 'United States',
                    222 => 'United Kingdom',
                    38 => 'Canada',
                    13 => 'Australia',
                    73 => 'France',
                    81 => 'Germany',
                    195 => 'Spain',
                    150 => 'Netherlands',
                    99 => 'India',
                    30 => 'Brazil',
                    204 => 'Switzerland',
                    105 => 'Italy',
                    176 => 'Russian Federation',
                );
                break;
            case 'sg':
                $default_countries = array(
                    188 => 'Singapore',
                    129 => 'Malaysia',
                    100 => 'Indonesia',
                    209 => 'Thailand',
                    168 => 'Philippines',
                    223 => 'United States',
                    222 => 'United Kingdom',
                    38 => 'Canada',
                    13 => 'Australia',
                    73 => 'France',
                    81 => 'Germany',
                    195 => 'Spain',
                    150 => 'Netherlands',
                    99 => 'India',
                    30 => 'Brazil',
                    204 => 'Switzerland',
                    105 => 'Italy',
                    176 => 'Russian Federation',
                );
                break;
            case 'au':
                $default_countries = array(
                    13 => 'Australia',
                    153 => 'New Zealand',
                );
                break;
            case 'uk':
                $default_countries = array(
                    222 => 'United Kingdom',
                    244 => 'Isle of Man',
                    243 => 'Guernsey',
                    245 => 'Jersey',
                    103 => 'Ireland',
                    21 => 'Belgium',
                    81 => 'Germany',
                    73 => 'France',
                    195 => 'Spain',
                    105 => 'Italy',
                    84 => 'Greece',
                    150 => 'Netherlands',
                    124 => 'Luxembourg',
                    57 => 'Denmark',
                    171 => 'Portugal',
                    14 => 'Austria',
                    203 => 'Sweden',

                );
                break;
            default:
                $default_countries = array(
                    223 => 'United States',
                    222 => 'United Kingdom',
                    38 => 'Canada',
                    13 => 'Australia',
                    73 => 'France',
                    81 => 'Germany',
                    195 => 'Spain',
                    150 => 'Netherlands',
                    99 => 'India',
                    30 => 'Brazil',
                    204 => 'Switzerland',
                    105 => 'Italy',
                    176 => 'Russian Federation',
                );
                break;
        }
        return $default_countries;
    }

    /**
     * $Notes: 获取国家列表数据
     *
     * @author: Aron
     * @Date: 2021/3/16
     * @Time: 15:29
     * @param bool $is_cn_limit
     * @return array
     */
    public function getCountryListData($is_cn_limit = false)
    {
        $defaultCountries = array_keys($this->get_default_countries());
        $countries = $this->countries;
        if($is_cn_limit) {
            unset($countries[40]);//删除中国
        }
        $countries = array_map(function ($item) {
            return [
                'countries_id' => $item['countries_id'],
                'countries_name' => $item[$this->getCountryMap()] ? $item[$this->getCountryMap()] : 'countries_name',
                'tel_prefix' => $item['tel_prefix'],
                'countries_iso_code_2' => $item['countries_iso_code_2']
            ];
        }, $countries);
        $defaultCountryInfo = array_filter($countries, function ($v) use ($defaultCountries) {
            return in_array($v['countries_id'], $defaultCountries);
        });
        $otherCountriesInfo = array_filter($countries, function ($v) use ($defaultCountries) {
            return !in_array($v['countries_id'], $defaultCountries);
        });
        $defaultCountryInfo = array_pluck($defaultCountryInfo, null, 'countries_id');

        $filterDefault = [];
        foreach ($defaultCountries as $vv) {
            if (!empty($defaultCountryInfo[$vv])) {
                $filterDefault[] = $defaultCountryInfo[$vv];
            }
        }
        $data = array_merge($filterDefault, $otherCountriesInfo);
        return array_values($data);
    }

    public function getCountryMap(){
        $language_code = $this->language_code;
        $data = [
            'de' => 'de_countries_name',
            'fr' => 'fr_countries_name',
            'ru' => 'ru_countries_name',
            'es' => 'es_countries_name',
            'jp' => 'jp_countries_name',
            'it' => 'it_countries_name'
        ];
        return isset($data[$language_code]) ? $data[$language_code] : 'countries_name';
    }
    /**
     * 根据站点获取国家名称要展示的具体字段
     * @return string
     */
    public function getCountriesNameFieldsBySite()
    {
        switch ($this->language_code) {
            case 'de':
                $fieldsName = 'de_countries_name as countries_name';
                break;
            case 'fr':
                $fieldsName = 'fr_countries_name as countries_name';
                break;
            case 'ru':
                $fieldsName = 'ru_countries_name as countries_name';
                break;
            case 'es':
                $fieldsName = 'es_countries_name as countries_name';
                break;
            case 'jp':
                $fieldsName = 'jp_countries_name as countries_name';
                break;
            case 'it':
                $fieldsName = 'it_countries_name as countries_name';
                break;
            default:
                $fieldsName = 'countries_name';
                break;
        }
        return $fieldsName;
    }

    /**
     * 设置查询字段
     *
     * @param array $field
     * @return $this
     */
    public function setField($field = [])
    {
        if (!is_array($field)) {
            $field = [$field];
        }
        $this->countries_fields = array_merge($this->countries_fields, $field);
        return $this;
    }

    public function setCountry($countries_id = 0, $countries_code = "")
    {
        if (!$countries_code) {
            $countries_code = $this->countries_iso_code;
        }
        if ($countries_id) {
            $country_arr = $this->countries;
            $data = array();
            if (!empty($country_arr)) {
                foreach ($country_arr as $key => $country) {
                    if (strstr($country['countries_id'], $countries_id) !== false) {
                        $data['countries_id'] = $country['countries_id'];
                        $data['tel_prefix'] = $country['tel_prefix'];
                        $data['countries_iso_code_2'] = $country['countries_iso_code_2'];
                        $data['en_countries_name'] = $country['countries_name'];
                        break;
                    }
                }
            }
//            $this->currentCountry = $data;
            $this->currentCountry = $this->country_m->select($this->countries_fields)
                ->where('countries_id', $countries_id)
                ->first();
        } else {
            $country_arr = $this->countries;
            $data = array();
            if (!empty($country_arr)) {
                foreach ($country_arr as $key => $country) {
                    if (strstr(strtoupper($country['countries_iso_code_2']), strtoupper($countries_code)) !== false) {
                        $data['countries_id'] = $country['countries_id'];
                        $data['tel_prefix'] = $country['tel_prefix'];
                        $data['countries_iso_code_2'] = $country['countries_iso_code_2'];
                        $data['en_countries_name'] = $country['countries_name'];
                        break;
                    }
                }
            }
//            $this->currentCountry = $data;
            $this->currentCountry = $this->country_m->select($this->countries_fields)
                ->where('countries_iso_code_2', $countries_code)
                ->first();
        }
        return $this;
    }


    /**
     * 获取缓存Countries数据
     * @return array|string
     */
    public function getCountries()
    {
        $countries = RedisService::getRedisKeyValue($this->cacheKey, $this->cachePrefix);
        if (empty($countries)) {
            $countries = $this->country_m->where('status', 1)->select('*')->get()->toArray();
            RedisService::setRedisKeyValue($this->cacheKey, $countries, 0, $this->cachePrefix);
        }
        return $countries;
    }

    /**
     * 获取缓存countries_us_states数据
     * @return array|string
     */
    public function getCountriesUsStates()
    {
        $countriesCode = RedisService::getRedisKeyValue($this->cacheKeyForStates, $this->cachePrefixForStates);
        if (empty($countriesCode)) {
            $countriesCode = $this->countriesCodeObj->select('*')->orderBy('states_code', 'asc')->get()->toArray();
            RedisService::setRedisKeyValue($this->cacheKeyForStates, $countriesCode, 0, $this->cachePrefixForStates);
        }
        return $countriesCode;
    }

    /**
     * 根据国家名称获取国家id
     * @param $country_name
     * @return mixed
     */
    public function getCountryidByName($country_name)
    {
        $country_arr = $this->countries;
        $data = array();
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if (strstr(strtoupper($country['countries_name']), strtoupper($country_name)) !== false) {
                    $data['countries_id'] = $country['countries_id'];
//                    $data['tel_prefix'] = $country['tel_prefix'];
//                    $data['countries_iso_code_2'] = $country['countries_iso_code_2'];
//                    $data['en_countries_name'] = $country['countries_name'];
                    break;
                }
            }
        }
        return $data['countries_id'];
    }

    /**
     * @param $countries_ids 国家的id,一维数组
     * @return array
     * @author potato
     */
    public function countriesTelCode($countries_ids)
    {
        // $this->language_countries_name[$this->session['languages_code']]是组装需要查询countries_name的字段
        $countries_name = isset($this->language_countries_name[$this->session['languages_code']]) ?
            $this->language_countries_name[$this->session['languages_code']] :
            $this->language_countries_name['default'];
        // 补充对应语种查询的字段
        array_push($this->countries_fields, $countries_name);
        // 查询所需要的tel_prefix、countries_iso_code_2、countries_name
        $code_name = [];
        $countries_name_prefix = $this->
        getCountriesNamePrefix($countries_ids, $this->countries_fields);
        // 获取国家州的简称
        $countries_code = $this->getCountryStatesCode(['states_code', 'states'], 'US');
        $countries_code_state = $this->arrayColumnNew($countries_code, 'states_code', 'states');

        // 将国家、电话前缀名称组装进数组中
        $countries_id_name = $this->arrayColumnNew($countries_name_prefix, $countries_name, 'countries_id');
        $countries_id_tel = $this->arrayColumnNew(
            $countries_name_prefix,
            'tel_prefix',
            'countries_id'
        );
        $countries_id_code = $this->arrayColumnNew(
            $countries_name_prefix,
            'countries_iso_code_2',
            'countries_id'
        );
        $code_name = [
            'countries_code_state' => $countries_code_state,
            'countries_id_tel' => $countries_id_tel,
            'countries_id_name' => $countries_id_name,
            'countries_id_code' => $countries_id_code,
        ];
        return $code_name;
    }

    /**
     * @param $countries_ids 国家id所组成的数组
     * @param array $fields 所要查询的字段组成的数组，最好是一维数组
     * @return mixed
     * @author potato
     */
    public function getCountriesNamePrefix($countries_ids, $fields = ['*'], $is_return_num_arr = false)
    {
        $country_arr = $this->countries;
        $countries_info = array();
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if ($countries_ids && is_array($countries_ids)) {
                    foreach ($countries_ids as $key2 => $countries_id) {
                        if (is_array($fields) && sizeof($fields) > 0) {
                            foreach ($fields as $field) {
                                if ($field == '*') {
                                    if ($country['countries_id'] == $countries_id) {
                                        $countries_info[] = $country;
                                    }
                                } else {
                                    if ($country['countries_id'] == $countries_id) {
                                        if ($is_return_num_arr) {
                                            $countries_info[$key2][] = $country[$field];
                                        } else {
                                            $countries_info[$key2][$field] = $country[$field];
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($country['countries_id'] == $countries_ids) {
                        $countries_info[$fields] = $country[$fields];
                    }
                }
            }
        }
        return $countries_info;
    }

    /**
     * @param string $country_code 国家的code
     *  获取国家州的简称
     * @param $fields 获取的字段，一维数组
     * @return
     * @author potato
     */
    public function getCountryStatesCode($fields, $country_code = 'US')
    {
        $where = '';
        $country_code = strtoupper($country_code);
        switch ($country_code) {
            case 'US':   //获取美国州的
                $where = ['status' => 1, 'type' => 1];
                break;
            case 'CA':   //获取加拿大的省份
                $where = ['status' => 1, 'type' => 2];
                break;
            case 'MX':   //获取墨西哥的省份
                $where = ['status' => 1, 'type' => 3];
                break;
            case 'AU':
                $states = array(
                    array(
                        'states_code' => 'ACT',
                        'states' => 'ACT'
                    ),
                    array(
                        'states_code' => 'NSW',
                        'states' => 'NSW'
                    ),
                    array(
                        'states_code' => 'NT',
                        'states' => "NT"
                    ),
                    array(
                        'states_code' => 'QLD',
                        'states' => 'QLD'
                    ),
                    array(
                        'states_code' => 'SA',
                        'states' => 'SA'
                    ),
                    array(
                        'states_code' => 'TAS',
                        'states' => 'TAS'
                    ),
                    array(
                        'states_code' => 'VIC',
                        'states' => 'VIC'
                    ),
                    array(
                        'states_code' => 'WA',
                        'states' => 'WA'
                    )
                );
                return $states;
                break;
        }
        if ($where) {
            $Country_us_states_arr = $this->countriesCode;
            $Country_us_states_info = array();
            if (!empty($Country_us_states_arr)) {
                foreach ($Country_us_states_arr as $key => $Country_us_state) {
                    if ($Country_us_state['status'] == $where['status'] && $Country_us_state['type'] == $where['type']) {
                        if ($fields && is_array($fields) && sizeof($fields) > 0) {
                            foreach ($fields as $field) {
                                if ($field == '*') {
                                    $Country_us_states_info[] = $Country_us_state;
                                } else {
                                    $Country_us_states_info[$key][$field] = $Country_us_state[$field];
                                    $Country_us_states_info[$key][$field] = $Country_us_state[$field];
                                }
                            }
                        } else {
                            $Country_us_states_info[] = $Country_us_state;
                        }
                    }
                }
            }
            return $Country_us_states_info;
        }
    }

    /**
     * @param string $country_code 国家的code
     *  获取国家州的简称
     * @param $fields 获取的字段，一维数组
     * @return
     * @author potato
     */
    public function getCaCountryStatesCode($field, $type = 1)
    {
        $Country_us_states_arr = $this->countriesCode;
        $Country_us_states_info = array();
        if (!empty($Country_us_states_arr)) {
            foreach ($Country_us_states_arr as $key => $Country_us_state) {
                if ($Country_us_state[array_keys($field)[0]] == $field[array_keys($field)[0]] && $Country_us_state['status'] == 1 && $Country_us_state['type'] == $type) {
                    $Country_us_states_info = $Country_us_state;
                }
            }
        }
        return $Country_us_states_info;
    }

    /**
     * 根据国家id 获取code
     *
     * @param int $country_id
     * //* @return string
     * @return array
     */
    public function getCountryCodeById($country_id = 0)
    {
        $country_arr = $this->countries;
        $data = array();
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if ($country['countries_id'] == $country_id) {
                    $data['countries_iso_code_2'] = $country['countries_iso_code_2'];
                }
            }
        }
        return $data;
    }

    /**
     * @Notes: 根据国家code 查询国家
     *
     * @param string $code
     * @return array|mixed
     * @author: aron
     * @Date: 2020-12-11
     * @Time: 00:25
     */
    public function getCountryIdByCode($code = '')
    {
        $country_arr = $this->countries;
        $data = [];
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if (strtoupper($country['countries_iso_code_2']) == strtoupper($code)) {
                    $data = $country;
                }
            }
        }
        return $data;
    }

    /**
     * 根据国家名称 获取code
     *
     * @param int $country_id
     * @return array
     */
    public function getCountryCodeByName($countries_name)
    {
        $country_arr = $this->countries;
        $data = array();
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if (strtoupper($country['countries_name']) == strtoupper($countries_name)) {
                    $data['countries_iso_code_2'] = $country['countries_iso_code_2'];
                }
            }
        }
        return $data;
    }

    /**
     * 根据国家id 获取名称
     *
     * @param int $country_id
     * @return array
     */
    public function getCountryNameById($country_id = 0, $fields = 'countries_name')
    {
        $country_arr = $this->countries;
        $data = array();
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if ($country['countries_id'] == $country_id) {
                    if (is_array($fields)) {
                        foreach ($fields as $field) {
                            $data[$field] = $country[$field];
                            $data[$field] = $country[$field];
                        }
                    } else {
                        $data[$fields] = $country[$fields];
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 获得国家号码前缀和country_id
     * @return array
     */
    public function getCountryIdTel($fields = ['countries_id', 'countries_iso_code_2', 'tel_prefix'], $return_ids = false)
    {
        $country_arr = $this->countries;
        $country_ids = array();
        if (!empty($country_arr)) {
            foreach ($country_arr as $key => $country) {
                if ($country['status'] == 1) {
                    foreach ($fields as $field) {
                        $country_ids[$key][$field] = $country[$field];
                    }
                }
            }
        }
        if ($return_ids) {
            return $country_ids;
        }
//        $country_ids = $this->country_m->where([
//            'status' => 1
//        ])->get(['countries_id', 'countries_iso_code_2', 'tel_prefix'])->toArray();
        $country_tel_id = [];
        $country_code_tel = [];
        $country_tel_id['id'] = $this->
        arrayColumnNew($country_ids, 'countries_id', 'countries_iso_code_2');
        $country_tel_id['tel'] = $this->
        arrayColumnNew($country_ids, 'tel_prefix', 'countries_id');
        $country_code_id = strtoupper($this->countries_iso_code);
        $country_code_tel['id'] = $country_tel_id['id'][$country_code_id];
        $country_code_tel['tel'] = $country_tel_id['tel'][$country_code_tel['id']];
        return $country_code_tel;
    }

    public function getCountry($countryId, $fields = '')
    {
        try {
            $countries = $this->countries;
            $result = [];
            array_map(function ($item) use ($countryId, &$result, $fields) {
                if ($item['countries_id'] === $countryId) {
                    if (empty($fields)) {
                        return $result = $item;
                    } else {
                        return $result = $item[$fields];
                    }
                }
            }, $countries);
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}
