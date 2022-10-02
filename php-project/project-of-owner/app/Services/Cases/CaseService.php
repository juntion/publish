<?php


namespace App\Services\Cases;

use App\Models\ProductThumbImage;
use App\Services\BaseService;
use App\Models\CaseNumber;
use App\Models\ServiceProcess;
use App\Models\ServiceProcessFile;
use App\Models\ServiceProcessSolution;
use App\Models\ServiceProcessSolutionFile;
use App\Models\ServiceProcessProduct;
use App\Models\ServiceProcessAssignAdmin;
use App\Models\ServiceProcessAssignNode;
use App\Models\CaseNumberBind;
use App\Models\CustomersBroker;
use App\Models\CustomersBrokerSolution;
use App\Models\PublicMailSuffix;
use App\Models\ServiceProcessNode;
use App\Models\ServiceProcessRecord;
use App\Services\Common\Upload\UploadService;
use App\Services\Orders\OrderService;
use App\Models\ServiceProcessRj;
use App\Models\ServiceProcessRequestDemo;
use Illuminate\Database\Capsule\Manager as DB;

class CaseService extends BaseService
{
    private $CaseNumber;                //case_number对象
    private $ServiceProcess;            //service_process对象
    private $ServiceProcessFile;        //service_process_file对象
    private $ServiceProcessSolution;    //service_process_solution对象
    private $ServiceProcessSolutionFile;//service_process_solution_file对象
    private $ServiceProcessAssignAdmin; //service_process_assign_admin对象
    private $ServiceProcessProduct;     //service_process_product对象
    private $ServiceProcessAssignNode;  //service_process_assign_node对象
    private $CustomersBroker;           //customers_broker对象
    private $PublicMailSuffix;          //public_mail_suffix对象
    private $CaseNumberBind;            //case_number_bind对象
    private $CustomersBrokerSolution;   //customers_broker_solution对象
    private $ServiceProcessNode;        //service_process_node对象
    private $ServiceProcessRecord;      //service_process_record对象
    private $ServiceProcessRj;            //service_process_rj对象
    private $ServiceProcessRequestDemo;   //service_process_request_demo对象
    private $productThumbImage;
    //默认产品图片尺寸
    private $defaultImageZie = ['size_w' => 100, 'size_h' => 100];
    public $broker_id;
    public $number;
    public $solution_id;

    public function __construct()
    {
        parent::__construct();

        $this->CaseNumber = new CaseNumber();
        $this->ServiceProcess = new ServiceProcess();
        $this->ServiceProcessFile = new ServiceProcessFile();
        $this->ServiceProcessSolution = new ServiceProcessSolution();
        $this->ServiceProcessSolutionFile = new ServiceProcessSolutionFile();
        $this->ServiceProcessAssignAdmin = new ServiceProcessAssignAdmin();
        $this->ServiceProcessProduct = new ServiceProcessProduct();
        $this->CustomersBroker = new CustomersBroker();
        $this->CustomersBrokerSolution = new CustomersBrokerSolution();
        $this->productThumbImage = new ProductThumbImage();
        $this->ServiceProcessAssignNode = new ServiceProcessAssignNode();
        $this->ServiceProcessNode = new ServiceProcessNode();
        $this->ServiceProcessRecord = new ServiceProcessRecord();
        $this->ServiceProcessRj = new ServiceProcessRj();
        $this->ServiceProcessRequestDemo = new ServiceProcessRequestDemo();
    }

    /**
     * 获取case列表
     * @param $get_list : true 获取列表；false 获取个数
     * @param $search : 查询条件
     * @param $page : 当前页码
     * @param $number : 每页多少条
     * @param $new_old_data : 新旧数据 (新增2021)
     * @param $type : 6为上传的PO 7为锐捷方案
     * @param $statues : 状态
     * @return mixed
     */
    public function getCaseList(
        $get_list = true,
        $search = '',
        $page = 'all',
        $number = '',
        $new_old_data = 1,
        $type = [1, 2, 3, 4, 5, 7],
        $statues = 0
    ) {
        if ($new_old_data == 1) {
            $caseDate = $this->ServiceProcess
                //->join('customers_broker as cu', 'cu.case_number', '=', 'case_number.case_number')
                ->where('customer_email', $this->customer_email)
                ->where('is_deleted', 0)
                ->whereIn('service_type', $type)
                ->where('status', '<>', 5);
            //查询条件：case编号
            if ($search) {
//                $caseDate = $caseDate->whereRaw(
//                    "(number = ? or order_number = ? or po_number = ?)",
//                    [$search, $search, $search]
//                );
                $caseDate = $caseDate->where(function ($query) use ($search) {
                    $query->orWhere('number', $search);
                    $query->orWhere('order_number', $search);
                    $query->orWhere('po_number', $search);
                    $query->orWhere('customer_describe', 'like', "%{$search}%");
                });
            }
            //筛选条件 状态
            if ($statues) {
                switch ($statues) {
                    case 1:
                        //submitted
                        $caseDate = $caseDate->where('status', 0)
                            ->where('sale_id', 0);
                        break;
                    case 2:
                        //Processing
                        $caseDate = $caseDate->whereIn('status', [0,1,2,3])
                            ->where('sale_id', '!=', 0);
                        break;
                    case 3:
                        //Solved
                        $caseDate = $caseDate->where('status', 4);
                        break;
                    case 4:
                        $caseDate = $caseDate->where('credit_status', 5);
                        //Rejected
                        break;
                }
            }
            if ($get_list) {
                $caseDate = $caseDate
                    ->select(
                        [
                            'number',
                            'status',
                            'is_que',
                            'order_number',
                            'service_type',
                            'created_at',
                            'service_id',
                            'po_audit_status',
                            'created_type',
                            'po_number',
                            'credit_status', //专用于created_type为17    1申请中  3审核中 4审核通过 5审核驳回
                            'credit_remarks',
                            'customer_describe',
                            'sale_id',
                            'type_id'
                        ]
                    )
                    ->orderBy('created_at', 'DESC');
                //分页数据
                if (!$page && $number) {
                    $caseDate = $caseDate->limit($number);
                } elseif ($page && $number) {
                    $begin_page = ($page - 1) * $number;
                    $caseDate = $caseDate->offset($begin_page)->limit($number);
                }
                $result = $caseDate->get()->toArray();
                if ($result) {
                    foreach ($result as $key => $val) {
                        if ($val['created_type'] == 17) {
                            $result[$key]['service_type_str'] = self::trans('FS_NET_30_06');
                            $result[$key]['status_str'] = $this->getPurchaseApplyStatusStr($val['credit_status']);
                        } else {
                            $result[$key]['service_type_str'] = $this->getServiceType($val['service_type']);
                            $result[$key]['status_str'] =
                                $this->getCasesStatus($val['status'], $val['sale_id'])['text'];
                            if ($val['type_id'] == 14) { //request_demo
                                $request_demo_info = $this->getRequestDemoInfo($val['number']);
                                $product_model = self::trans('FS_CASE_REQUEST_DEMO_01').'&nbsp;'.
                                    $request_demo_info['product_info']['products_model'];
                                $functions = self::trans('FS_CASE_REQUEST_DEMO_02').'&nbsp;'.
                                    implode(', ', $request_demo_info['functions']);
                                $dateTime = self::trans('FS_CASE_REQUEST_DEMO_03').'&nbsp;'.
                                    $request_demo_info['choose_datetime'];
                                if ($val['customer_describe'] != 'none') {
                                    $val['customer_describe'] = $product_model.'; '.$functions.'; '.$dateTime.'; '.
                                        self::trans('FS_CASE_REQUEST_DEMO_04').'&nbsp;'.$val['customer_describe'];
                                } else {
                                    $val['customer_describe'] = $product_model.'; '.$functions.'; '.$dateTime;
                                }
                            }
                        }
                        $result[$key]['po_status_str'] =
                            $this->getPoStatus($val['po_audit_status'])['text'];
                        //查询绑定的订单信息
                        if ($result[$key]['order_number']) {
                            $result[$key]['orders'] = $this->getServiceOrders($result[$key]['order_number']);
                        }
                        $result[$key]['customer_describe'] = $val['customer_describe'] == 'none' ? '--' :
                            self::autoLink(self::autoNextLine($val['customer_describe']));
                    }
                }
            } else {
                $result = $caseDate->count();
            }
        } else {
            $caseDate = $this->CaseNumber
                ->join('customers_broker as cu', 'cu.case_number', '=', 'case_number.case_number')
                ->where('customer_id', $this->customer_id)
                ->where('case_number.is_del', 0)
                ->whereIn('cu.service_type', [1, 2, 3, 4, 5, 7])
                //临时添加 前后台不完善 故第一阶段 从 美国时间2019-11-28 00:00:00 之后的都不展示
                ->where('cu.add_time', '<', '2019-11-28 00:00:00');
            //查询条件：case编号
            if ($search) {
//                $caseDate = $caseDate->where('case_number.case_number', $search);
                $caseDate = $caseDate->where(function ($query) use ($search) {
                    $query->orWhere('case_number.case_number', $search);
                    $query->orWhere('case_number.content', 'like', "%{$search}%");
                });
            }
            //筛选条件 状态
            if ($statues) {
                switch ($statues) {
                    case 1:
                        //submitted
                        $caseDate = $caseDate->whereIn('status', [0,1]);
                        break;
                    case 2:
                        //Processing
                        $caseDate = $caseDate->where('status', 2);
                        break;
                    case 3:
                        //Solved
                        $caseDate = $caseDate->whereIn('status', [3,4,5]);
                        break;
                    case 4:
                        //旧版不存在这个状态 直接给个不包含的值 让查询为空
                        $caseDate = $caseDate->where('status', 100);
                        //Rejected
                        break;
                }
            }
            if ($get_list) {
                $caseDate = $caseDate
                    ->select(
                        [
                            'case_number.case_number',
                            'case_number.content',
                            'status',
                            'is_que',
                            'cu.broker_id',
                            'cu.service_type',
                            'cu.add_time'
                        ]
                    )
                    ->orderBy('add_time', 'DESC');
                //分页数据
                if (!$page && $number) {
                    $caseDate = $caseDate->limit($number);
                } elseif ($page && $number) {
                    $begin_page = ($page - 1) * $number;
                    $caseDate = $caseDate->offset($begin_page)->limit($number);
                }
                $result = $caseDate->get()->toArray();
                if ($result) {
                    foreach ($result as $key => $val) {
                        $result[$key]['service_type_str'] = $this->getServiceType($val['service_type']);
                        $this->broker_id = $val['broker_id'];
                        $result[$key]['status_str'] = $this->getStatus($val['status'])['text'];
                        $result[$key]['content'] = $val['content']  ?  self::autoLink(self::autoNextLine($val['content'])) : '';
                    }
                }
            } else {
                $result = $caseDate->count();
            }
        }
        return $result;
    }

    /**
     * 获取一个case的answer列表
     * @param $get_list : true 获取列表；false 获取个数
     * @param $customers_broker_id
     * @param $page : 当前页码
     * @param $number : 每页多少条
     * @return array
     */
    public function getCaseAnswerList($customers_broker_id, $get_list = true, $page = 'all', $number = '')
    {
        $listData = $this->CustomersBrokerSolution
            ->join('customers_broker as cu', 'customers_broker_solution.broker_id', '=', 'cu.broker_id')
            ->where('customers_broker_solution.broker_id', $customers_broker_id)
            ->where('customers_broker_solution.draft', 0);
        if ($get_list) {
            $listData = $listData
                ->select(
                    [
                        'customer_question_id',
                        'solution_content',
                        'admin_name',
                        'solution_time',
                        'is_append',
                        'customers_broker_solution.file',
                        'file_name',
                        'draft',
                        'answer_type',
                        'case_number'
                    ]
                )
                ->orderBy('customer_question_id', 'ASC');
            //分页数据
            if (!$page && $number) {
                $listData = $listData->limit($number);
            } elseif ($page && $number) {
                $begin_page = ($page - 1) * $number;
                $listData = $listData->offset($begin_page)->limit($number);
            }
            $result = $listData->get()->toArray();
            if ($result) {
                foreach ($result as $key => $val) {
                    $result[$key]['service_type_str'] = $this->getServiceType($val['service_type']);
                    $result[$key]['solution_content'] = self::autoLink(self::autoNextLine($val['solution_content']));
                }
            }
        } else {
            $result = $listData->count();
        }
        return $result;
    }


    /**
     * 获取一个case的服务流程answer列表
     * @param $get_list : true 获取列表；false 获取个数
     * @param $number 查询条件
     * @param $page : 当前页码
     * @param $page_count : 每页多少条
     * @return array
     */
    public function getServiceProcessCaseAnswerList($number, $get_list = true, $page = 'all', $page_count = '')
    {
        $listData = $this->ServiceProcessSolution
            ->with(
                [
                    'solutionFile' => function ($query) {
                        $query->select(
                            [
                                'file_name',
                                'storage_path',
                                'storage_name',
                                'solution_id'
                            ]
                        );
                        //->where('solution_id');
                    },
                ]
            )
            ->where('number', $number)
            ->where('is_del', 0)
            ->where('is_draft', 0);
        if ($get_list) {
            $listData = $listData
                ->select(
                    [
                        'id',
                        'number',
                        'is_append',
                        'is_draft',
                        'is_del',
                        'answer_type',
                        'content',
                        'created_at',
                    ]
                )
                ->orderBy('id', 'ASC');
            //分页数据
            if (!$page && $page_count) {
                $listData = $listData->limit($page_count);
            } elseif ($page && $page_count) {
                $begin_page = ($page - 1) * $page_count;
                $listData = $listData->offset($begin_page)->limit($page_count);
            }
            $result = $listData->get()->toArray();
        } else {
            $result = $listData->count();
        }
        return $result;
    }


    /**
     * 获取最后一条后台回复的数据
     * @param $number
     * @return array
     */
    public function getServiceProcessSolutionInfo($number)
    {
        if ($number) {
            $solution_arr = $this->ServiceProcessSolution
                ->where('number', $number)
                ->where('is_append', 0)
                ->where('is_del', 0)
                ->where('is_draft', 0)
                ->select(
                    [
                        'admin_id',
                        'admin_name',
                        'answer_type',
                        'content',
                    ]
                )
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get()
                ->toArray();
            if (sizeof($solution_arr)) {
                return $solution_arr;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }


    /**
     * 获取一个case的信息
     * @param $case_number
     * @return array
     */
    public function getOneCase($case_number)
    {
        $customers_broker = $this->CaseNumber
            ->join('customers_broker as cu', 'cu.case_number', '=', 'case_number.case_number')
            ->where('case_number.case_number', $case_number)
            ->select(
                [
                    'case_number.*',
                    'cu.file',
                    'cu.origin_file_name',
                    'cu.broker_id',
                    'cu.service_type',
                    'cu.customers_id',
                    'cu.labels',
                    'cu.classification',
                    'cu.add_time'
                ]
            )
            ->limit(1)
            ->get()
            ->toArray();
        $customers_broker = $customers_broker[0];
        $name_classification = $this->getClassificationStr($customers_broker['classification']);
        $customers_broker['name_classification'] = $name_classification['name_classification'];
        $customers_broker['content'] = self::autoLink(self::autoNextLine($customers_broker['content']));
        $customers_broker['name_engineer'] = $name_classification['name_engineer'];
        $customers_broker['service_type_str'] = $this->getServiceType($customers_broker['service_type']);
        $this->broker_id = $customers_broker['broker_id'];
        $customers_broker['status_str'] = $this
            ->getStatus($customers_broker['status'])['text'];
        if ($customers_broker['labels']) {
            $customers_broker['labels_arr'] = explode(",", $customers_broker['labels']);
            $customers_broker['labels_count'] = count($customers_broker['labels_arr']);
        }
        return $customers_broker;
    }


    /**
     * 根据number获取服务流程表中一条的信息
     * @param $number
     * @return array
     */
    public function getOneServiceProcess($number)
    {
        $service_data = $this->ServiceProcess
            ->with(
                [
                    'file' => function ($query) {
                        $query->select(
                            [
                                'file_name',
                                'storage_path',
                                'storage_name',
                                'service_process_number'
                            ]
                        );
                    },
                ]
            )
            ->with(
                [
                    'solution' => function ($query) {
                        $query->select(
                            [
                                'plan_type',
                                'industry',
                                'bandwidth_requirement',
                                'backup_needs',
                                'option_params',
                                'number'
                            ]
                        );
                    },
                ]
            )
            ->where('number', $number)
            ->where('customer_email', $this->customer_email)
            ->select(
                [
                    'service_process.*'
                ]
            )
            ->limit(1)
            ->get()
            ->toArray();
        $service_data = $service_data[0];

        if (!$service_data) {
            return [];
        }

        $service_data['content'] = $service_data['customer_describe'] == 'none' ? '' :
            self::autoLink(self::autoNextLine($service_data['customer_describe']));
        if (isset($service_data['created_type']) &&  $service_data['created_type'] == 17) {
            $service_data['service_type_str'] = self::trans('FS_NET_30_06');
            $service_data['status_str'] = $this->getPurchaseApplyStatusStr($service_data['credit_status']);
        } else {
            $service_data['service_type_str'] = $this->getServiceType($service_data['service_type']);
            $service_data['status_str'] = $this->getCasesStatus(
                $service_data['status'],
                $service_data['sale_id']
            )['text'];
        }
        $service_data['service_product_arr'] = $this->getServiceProduct($number);
        $service_data['service_product_img_arr'] = [];
        if ($service_data['service_product_arr']) {
            foreach ($service_data['service_product_arr'] as $val) {
                $service_data['service_product_img_arr'][] = $this->productThumbImage
                    ->setThumbImage($this->defaultImageZie)
                    ->getResourceImage((int)$val['products_id']);
            }
        }
        $service_data['po_status_str'] = $this->getPoStatus($service_data['po_audit_status']);
        //查询绑定的订单信息
        if ($service_data['order_number']) {
            $service_data['orders'] = $this->getServiceOrders($service_data['order_number']);
        }
        if ($service_data['solution']) {
            $service_data['solution']['info'] = $this->solutionPlanArr($service_data['solution']['plan_type']);
            $option_params = explode(';',$service_data['solution']['option_params']);
            $service_data['solution']['option_params'] =
                'industry='.$option_params[0].'&bandwidth='.$option_params[1].'&backup='.$option_params[2];
        }

        if ($service_data['type_id'] == 14) {
            $service_data['request_demo_info'] = $this->getRequestDemoInfo($service_data['number']);
        }
        return $service_data;
    }


    /**
     * 根据case_number查询相关数据
     * @param $field
     * @param $case_number
     * @return array
     */
    public function getBrokerInfo($case_number)
    {
        if ($case_number) {
            $customers_broker_id = $this->CustomersBroker
                ->where('case_number', $case_number)
                ->pluck('broker_id');
            $solution_arr = $this->CustomersBrokerSolution
                ->where('broker_id', $customers_broker_id)
                ->get(
                    [
                        'broker_id',
                        'customer_question_id',
                        'admin_name',
                        'answer_type',
                        'solution_content'
                    ]
                )
                ->toArray();
            if (sizeof($solution_arr)) {
                return $solution_arr;
            } else {
                return [['broker_id' => $customers_broker_id]];
            }
        } else {
            return [];
        }
    }

    /**
     * 创建CaseNumber
     * 前台从CN------000001 开始 每次创建加2
     * @param $data
     * @param caseNumberFrom  '1.客服信息录入，2.客户后台提问，3.在线留言管理，4.线上产品询价，5. 定制记录,',
     * @param email  '客户邮箱'
     * @param adminID  '分配的销售'
     * @param content  '客户咨询的内容'
     * @return string
     */
    public function createCaseNumber($data)
    {
        $caseNumberFrom = $data['case_from'];
        $email = $data['customer_email'];
        $adminID = $data['admin_id'];
        $content = $data['question_content'];
        $service_ids = $data['service_admin'] ? $data['service_admin'] : '';
        $area = $data['area'] ? $data['area'] : '';
        $time = strtotime(date("Y-m-d"));
        //获取年月日 171212
        $date = mb_substr(date("Ymd"), -6);
        $caseNumber = $this->CaseNumber;
        $result = $caseNumber
            ->where('stage_from', 1)
            ->where('created_at', '>=', $time)
            ->orderBy('case_number', 'desc')
            ->limit(1)
            ->get(['case_number'])
            ->toArray();
        if ($result[0]['case_number']) {
            $lastCaseNumber = mb_substr($result[0]['case_number'], -4);
            $newCaseNumber = (int)$lastCaseNumber + 2;
            $newCaseNumber = 'CN' . $date . str_pad($newCaseNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $newCaseNumber = 'CN' . $date . '0001';
        }
        $pretreatment_status = $service_ids ? 0 : 1;
        $insertArray = [
            'case_number' => $newCaseNumber,
            'case_number_from' => $caseNumberFrom,
            'status' => 0,
            'stage_from' => 1,
            'created_at' => time(),
            'email' => $email,
            'admin_id' => $adminID,
            'content' => $content,
            'customer_id' => $this->customer_id,
            'language_id' => $this->language_id,
            'language_code' => $this->session['languages_code'],
            'service_admin' => $service_ids,
            'area' => $area,
            'pretreatment_status' => $pretreatment_status,
        ];

        $arrEmail = explode('@', $email);
        $domain = '@' . $arrEmail[1];
        $this->PublicMailSuffix = new PublicMailSuffix();
        $commonDomain = $this->PublicMailSuffix
            ->where('mail_suffix', $domain)
            ->limit(1)
            ->get(['mail_suffix'])
            ->toArray();
        if ($email && $newCaseNumber && $caseNumberFrom == 2 && !$commonDomain[0]['mail_suffix']) {
            $last = explode('@', $email);
            $time = time() - 12 * 3600;
            $resOffline = $caseNumber
                ->where('case_number_from', 2)
                ->where('is_del', 0)
                ->where('created_at', '>', $time)
                ->where('email', 'like', '%@' . $last[1])
                ->get(['case_number'])
                ->toArray();
            if (sizeof($resOffline)) {
                $this->CaseNumberBind = new CaseNumberBind();
                foreach ($resOffline as $v) {
                    $arr = [
                        'case_number' => $newCaseNumber,
                        'bind_number' => $v['case_number'],
                        'type' => 2,
                        'created_at' => date("Y-m-d H:i:s", time()),
                    ];
                    $this->CaseNumberBind->create($arr);
                }
            }
        }
        $caseNumber->create($insertArray);
        return $newCaseNumber;
    }

    /**
     * 新增一个Case的图片
     * @param $data array
     */
    public function createServiceFile($data)
    {
        if (!empty($data)) {
            foreach ($data as $v) {
                $this->ServiceProcessFile->create($v);
            }
        }
    }

    /**
     * 新增一个Case回复的图片
     * @param $data array
     */
    public function createServiceSolutionFile($data)
    {
        if ($data) {
            $this->ServiceProcessSolutionFile->create($data);
        }
    }

    /**
     * 新增一个Case到新的服务流程表
     * @param $data array
     */
    public function createService($data)
    {
        if ($data) {
            $this->ServiceProcess->create($data);
        }
        return true;
    }

    /**
     * 更新case信息
     * @param $number
     * @param $fields
     * @return bool
     */
    public function updateService($number, $fields) {
        if (!$number || empty($fields)) {
            return false;
        }
        $this->ServiceProcess->where(['number' => $number])->update($fields);
        return true;
    }

    /**
     * 新增一个Case到新的服务流程产品表
     * @param $data array
     */
    public function createServiceProcessProduct($data)
    {
        if (!empty($data)) {
            foreach ($data as $v) {
                $this->ServiceProcessProduct->create($v);
            }
        }
    }

    /**
     * 新增Case服务流程操作表 默认3018客服
     * @param $admin_id int
     * @param $number string
     */
    public function createServiceAssignAdmin($admin_id, $number)
    {
        if ($admin_id) {
            $editAssignId = $admin_id.','.'3018';
            $admin_ids_arr = explode(',', $editAssignId);
            foreach ($admin_ids_arr as $service_val) {
                $admin_assign_arr = [
                    'number' => $number,
                    'admin_id' => $service_val
                ];
                //  新增前判断记录是否存在
                $res = $this->ServiceProcessAssignAdmin->where($admin_assign_arr)->first();
                if (!$res) {
                    $this->ServiceProcessAssignAdmin->create($admin_assign_arr);
                }
            }
        }
    }

    /**
     * 服务流程节点表
     * @param $data array
     */
    public function createServiceAssignNode($data = [])
    {
        if (!empty($data)) {
            foreach ($data as $v) {
                $this->ServiceProcessAssignNode->create($v);
            }
        }
    }

    /**
     * 服务流程节点表
     * @param $data array
     */
    public function createServiceProcessRecord($data = [])
    {
        if (!empty($data)) {
            foreach ($data as $v) {
                $this->ServiceProcessRecord->create($v);
            }
        }
    }

    /**
     * 新增一个Case
     * @param $data array
     */
    public function createCase($data)
    {
        if ($data) {
            $this->CustomersBroker->create($data);
        }
    }


    /**
     * 新增broker solution
     * * @param $data array
     */
    public function createBrokerSolution($data)
    {
        if ($data) {
            $this->CustomersBrokerSolution->create($data);
        }
    }

    /**
     * 新增broker solution
     * * @param $data array
     */
    public function createServiceSolution($data)
    {
        if ($data) {
            return $this->ServiceProcessSolution->create($data);
        }
    }

    /**
     * 根据case_number更新数据
     * @param $fields
     * @param $caseNumber
     * @param $is_del bool 删除操作
     */
    public function updateCase($fields, $caseNumber, $is_del = false)
    {
        if ($caseNumber) {
            $this->CaseNumber
                ->where('case_number', $caseNumber)
                ->update(array_merge(['updated_at' => time()], $fields));
            if ($is_del) {
                $this->updateBroker(['is_del' => 1, 'who_del' => $this->customer_id], $caseNumber);
            }
        }
    }

    /**
     * 根据number更新数据
     * @param $fields
     * @param $number
     */
    public function updateServiceProcess($fields, $number)
    {
        if ($number) {
            $this->ServiceProcess
                ->where('number', $number)
                ->update($fields);
        }
    }

    /**
     * 根据case_number更新数据
     * @param $fields
     * @param $caseNumber
     */
    public function updateBroker($fields = [], $caseNumber = 0)
    {
        if ($fields && $caseNumber) {
            $this->CustomersBroker
                ->where('case_number', $caseNumber)
                ->update($fields);
        }
    }

    /**
     * 验证自己的Case number
     * @param $case_number
     * @param $new_old_data int 新旧数据判断
     * @return bool
     */
    public function checkCaseNumber($case_number, $new_old_data = 1)
    {
        if ($new_old_data == 1) {
            $result = $this->ServiceProcess
                ->where('number', $case_number)
                ->where('customer_email', $this->customer_email)
                ->count();
        } else {
            $result = $this->CaseNumber
                ->where('case_number', $case_number)
                ->where('customer_id', $this->customer_id)
                ->count();
        }
        return $result > 0 ? true : false;
    }

    /**
     * 增加点击
     * @param $case_number
     * @return bool
     */
    public function clickBroker($case_number)
    {
        $this->CustomersBroker->where('case_number', $case_number)->increment('is_click');
    }

    /**
     * 上传多个文件
     *
     * @param array $fileInput $_FILES变量名组成的数组
     * @param string $case_dir 上传图片路径
     * @param array $allowedTypes 文件的可上传格式
     * @param array $extension 可上传文件后缀
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadFiles($fileInput = [], $case_dir = 'myCase', $allowedTypes = [], $extension = [])
    {
        if ($case_dir == 'myCase') {
            $changeName = 1;
        } else {
            $changeName = 2;
        }
        if (!is_array($allowedTypes) || !count($allowedTypes)) {
            $allowedTypes = ['application/pdf', 'image/jpg', 'image/png', 'image/jpeg'];
        }
        $upload = new UploadService();
        $upload->setConfig(
            [
                'fileSize' => '5M',
                'savePath' => $case_dir,
                'changeName' => $changeName,
                'fileExtension' => $allowedTypes,
                'extension' => $extension
            ]
        );
        if (is_array($fileInput)) {
            $paths = $upload->uploads($fileInput);
            //批量上传成功
            $path = [];
            if (!empty($paths)) {
                foreach ($paths as $k => $v) {
                    $path[] = $v['path'];
                }
                return ['code' => 1, 'path' => $path];
            } else {
                return ['code' => 0];
            }
        } else {
            return ['code' => 0];
        }
    }

    /**
     * 服务类型描述文字
     * @param $type
     * @return string
     */
    public function getServiceType($type)
    {
        switch ($type) {
            case 1:
                $str = self::trans('FS_SERVICE_TYPE_CHOOSE1');
                break;
            case 2:
                $str = self::trans('FS_SERVICE_TYPE_CHOOSE2');
                break;
            case 3:
                $str = self::trans('FS_SERVICE_TYPE_CHOOSE3');
                break;
            case 4:
                $str = self::trans('FS_SERVICE_TYPE_CHOOSE4');
                break;
            case 5:
                $str = self::trans('FS_OTHERS');
                break;
            case 7:
                $str = self::trans('MY_CASE_UPLOAD_19');
                break;
            default:
                $str = '--';
                break;
        }
        return $str;
    }

    /**
     * 服务类型获取对应产品
     * @param $number
     * @return array
     */
    public function getServiceProduct($number)
    {
        $result = [];
        if ($number) {
            $result = $this->ServiceProcessProduct
                ->where('number', $number)
                ->select(
                    [
                        'products_id'
                    ]
                )
                ->get()
                ->toArray();
        }
        return $result;
    }

    /**
     * 获取后台回复状态，有数据为已回复过至少一条
     */
    public function getSolution()
    {
        if ($this->broker_id) {
            return $this->CustomersBrokerSolution
                ->where('broker_id', $this->broker_id)
                ->where('is_append', 0)
                ->count();
        } else {
            return 0;
        }
    }

    /**
     * 0.未处理,1.预处理，2.已处理，3.已解决
     * @param $type : 处理状态
     * @return array
     */
    public function getStatus($type)
    {
        $result = array('type' => 0, 'text' => '');
        if ($type == 2) {
            $result['type'] = 2;
            $result['text'] = self::trans('FS_CASE_PROCESSING');
        } elseif(in_array($type, [3,4,5])) {
            $result['type'] = 3;
            $result['text'] = self::trans('FS_SOLVED1');
        } else {
            $result['type'] = 1;
            $result['text'] = self::trans('FS_SUBMITTED');
        }
        return $result;
    }

    /**
     * 获取后台回复状态，有数据为已回复过至少一条
     */
    public function getServiceSolution()
    {
        if ($this->number) {
            return $this->ServiceProcessSolution
                ->where('number', $this->number)
                ->where('is_append', 0)
                ->count();
        } else {
            return 0;
        }
    }

    /**
     * 1.客户提交 2.处理中 3.已完结
     * @param $type : 处理状态
     * @param $sale_id : 客服id
     * @return array
     */
    public function getCasesStatus($type, $sale_id = 0)
    {
        $result = array('type' => 0, 'text' => '');

        if ($type == 4) {
            $result['type'] = 3;
            $result['text'] = self::trans('FS_SOLVED1');
        } else {
            if ($sale_id != 0) {
                $result['type'] = 2;
                $result['text'] = self::trans('FS_CASE_PROCESSING');
            } else {
                $result['type'] = 1;
                $result['text'] = self::trans('FS_SUBMITTED');
            }
        }
        return $result;
    }

    /**
     * 0.客户提交 1.PO审核通过 2.已下单
     * @param $status : 处理状态
     * @return array
     */
    public function getPoStatus($status)
    {
        $content = array();
        switch ($status) {
            case 0:
                $content['text'] = self::trans('PURCHASE_LIST_07');
                $content['tip'] = self::trans('PURCHASE_LIST_07_TIP');
                break;
            case 1:
                $content['text'] = self::trans('PURCHASE_LIST_08');
                $content['tip'] = self::trans('PURCHASE_LIST_08_TIP');
                break;
            case 2:
                $content['text'] = self::trans('PURCHASE_LIST_09');
                $content['tip'] = self::trans('PURCHASE_LIST_09_TIP');
                break;
        }
        return $content;
    }

    /**
     * 1.客户提交的文件
     * @param $number : 查询条件
     * @return array
     */
    public function getServiceFile($number)
    {
        $result = [];
        if ($number) {
            $result = $this->ServiceProcessFile
                ->where('service_process_number', $number)
                ->select(
                    [
                        'file_name',
                        'storage_path',
                        'storage_name'
                    ]
                )
                ->get()
                ->toArray();
        }
        return $result;
    }

    /**
     * 获取绑定的订单信息
     * @param $order_number : 订单编号
     * @return array
     */
    public function getServiceOrders($order_number)
    {
        $orders = [];
        $orderService = new OrderService();
        $orderObj = $orderService->setField(['payment_module_code'])->setOrder(0, $order_number)->currentOrder;
        if ($orderObj) {
            $orderInfo = $orderObj->toArray();
            if (!in_array($orderInfo['main_order_id'], [0, 1])) {
                $ordersData = $orderService->getOrderInfoByOrderId($orderInfo['main_order_id']);
            } else {
                //其他状态下都只展示当前分单的产品信息
                $ordersData = $orderService->getOrderInfoByOrderId($orderInfo['orders_id']);
            }
            $orders = $ordersData;
        }
        return $orders;
    }


    /**
     *
     * @param $type
     * @return array
     */
    public function getClassificationStr($type)
    {
        $arr = array();
        switch ($type) {
            case 1:
                $arr = array(
                    'name_classification' => self::trans('FS_OPTICAL_TRANSPORT_NETWORK'),
                    'name_engineer' => self::trans('FS_STEVEN_ENGINEER'),
                    'customer' => self::trans('FS_STEVEN_ENGINEER_EXPERIENCE'),
                );
                break;
            case 2:
                $arr = array(
                    'name_classification' => self::trans('FS_ENTERPRISE_NETWORK'),
                    'name_engineer' => self::trans('FS_FREDDY_ENGINEER'),
                    'customer' => self::trans('FS_FREDDY_ENGINEER_EXPERIENCE'),
                );
                break;
            case 3:
                $arr = array(
                    'name_classification' => self::trans('FS_DATA_CENTER_CABLING'),
                    'name_engineer' => self::trans('FS_ARCHER_ENGINEER'),
                    'customer' => self::trans('FS_ARCHER_ENGINEER_EXPERIENCE'),
                );
                break;
            case 4:
                $arr = array(
                    'name_classification' => self::trans('FS_OPTIC_OEM_SOLUTION'),
                    'name_engineer' => self::trans('FS_KAREN_ENGINEER'),
                    'customer' => self::trans('FS_KAREN_ENGINEER_EXPERIENCE'),
                );
                break;
            case 5:
                $arr = array(
                    'name_classification' => self::trans('FS_CLOUD_NETWORK'),
                    'name_engineer' => self::trans('FS_CLOUD_ENGINEER'),
                    'customer' => self::trans('FS_CLOUD_ENGINEER_EXPERIENCE'),
                );
                break;
            case 6:
                $arr = array(
                    'name_classification' => self::trans('FS_FTTX'),
                    'name_engineer' => self::trans('FS_HILTON_ENGINEER'),
                    'customer' => self::trans('FS_HILTON_ENGINEER_EXPERIENCE'),
                );
                break;
            default:
                break;
        }
        return $arr;
    }

    /**
     * by rebirth 2020.05.22
     *
     * @param int $status 申请状态
     * @return string
     */
    public function getPurchaseApplyStatusStr($status = 1)
    {
        $statuesStrs = [
            '1' => self::trans('FS_NET_30_07'),
            '3' => self::trans('FS_NET_30_08'),
            '4' => self::trans('FS_NET_30_09'),
            '5' => self::trans('FS_NET_30_10'),
        ];
        return isset($statuesStrs[$status]) ? $statuesStrs[$status] : '--';
    }

    /**
     *
     * @param int $type_id 服务类型
     * @param int $step 服务节点
     * @return string
     */
    public function getSaleNodeId($type_id, $step)
    {
        $saleNodeId = 0;
        if ($type_id) {
            $info = $this->ServiceProcessNode
                ->select('id')
                ->where('type_id', $type_id)
                ->where('step', $step)
                ->first();
            if ($info) {
                $data = $info->toArray();
                $saleNodeId = $data['id'];
            }
        }
        return $saleNodeId;
    }

    /**
     * 新增一个Case到新的服务流程产品表
     * @param $data array
     */
    public function createServiceProcessSolution($data)
    {
        if ($data) {
            $this->ServiceProcessRj->create($data);
        }
        return true;
    }

    /**
     * 更新新的服务流程产品表
     * @param $number   int     服务流程编号
     * @param $fields   array   更新的数组
     * @return false
     */
    public function updateServiceProcessSolution($number, $fields)
    {
        if (empty($number) || empty($fields)) {
            return false;
        }
        $this->ServiceProcessRj->where(['number' => $number])->update($fields);

        return true;
    }

    /**
     * 获取服务流程产品表信息
     * @param $number
     * @return mixed
     */
    public function getServiceProcessInfo($number) {
        return $this->ServiceProcessRj->where('number', $number)
                                      ->first();
    }

    /**
     * 服务流程数据插入
     * @param $serviceArray
     * @return bool
     */
    public function insertServiceProcess($serviceArray, $type = '')
    {
        DB::connection()->beginTransaction();
        try {
            foreach ($serviceArray as $serviceK => $serviceV) {
                switch ($serviceK) {
                    case 'service_process':
                        if ($type == 'ruijie') {
                            $this->updateService($serviceV['number'], $serviceV);
                        } else {
                            $this->createService($serviceV);
                        }
                        break;
                    case 'service_process_assign_admin':
                        $this->createServiceAssignAdmin($serviceV['admin_id'], $serviceV['number']);
                        break;
                    case 'service_process_assign_node':
                        $this->createServiceAssignNode($serviceV);
                        break;
                    case 'service_process_record':
                        $this->createServiceProcessRecord($serviceV);
                        break;
                    case 'service_process_file':
                        $this->createServiceFile($serviceV);
                        break;
                    case 'service_process_product':
                        $this->createServiceProcessProduct($serviceV);
                        break;
                    case 'service_request_demo':
                        $this->createServiceProcessRequestDemo($serviceV);
                        break;
                    case 'service_ruijie_solution':
                        if ($type == 'ruijie') {
                            $this->updateServiceProcessSolution($serviceV['number'], $serviceV);
                        } else {
                            $this->createServiceProcessSolution($serviceV);
                        }
                        break;
                }
            }
            DB::connection()->commit();
            return true;
        } catch (\Exception $e) {
            DB::connection()->rollBack();
            return false;
        }
    }

    public function solutionIndustryArr($key = 0)
    {
        $result = array(
            1 => array(
                'name' => 'Education',
                'val' => 1,
                'des' => self::trans('NETWORK_SOLUTION_EDUCATION'),
                'img_with' => 62
            ),
            2 => array(
                'name' => 'Manufacturing',
                'val' => 2,
                'des' => self::trans('NETWORK_SOLUTION_MANUFACTURING'),
                'img_with' => 60
            ),
            3 => array(
                'name' => 'Hotel',
                'val' => 3,
                'des' => self::trans('NETWORK_SOLUTION_HOTEL'),
                'img_with' => 62
            ),
            4 => array(
                'name' => 'Retail',
                'val' => 4,
                'des' => self::trans('NETWORK_SOLUTION_RETAIL'),
                'img_with' => 54
            ),
            5 => array(
                'name' => 'Internet',
                'val' => 5,
                'des' => self::trans('NETWORK_SOLUTION_INTERNET'),
                'img_with' => 50
            ),
            6 => array(
                'name' => 'Other',
                'val' => 6,
                'des' => self::trans('NETWORK_SOLUTION_OTHER'),
                'img_with' => 56
            )
        );
        if ($key > 0) {
            $result = $result[$key];
        }
        return $result;
    }

    public function solutionBandwidthArr($key = 0)
    {
        $result = array(
            1 => array(
                'name' => 'Lower',
                'val' => 1,
                'title' => self::trans('NETWORK_SOLUTION_STEP_2_02'),
                'des' => self::trans('NETWORK_SOLUTION_STEP_2_03')
            ),
            2 => array(
                'name' => 'Higher',
                'val' => 2,
                'title' => self::trans('NETWORK_SOLUTION_STEP_2_04'),
                'des' => self::trans('NETWORK_SOLUTION_STEP_2_05')
            )
        );
        if ($key > 0) {
            $result = $result[$key];
        }
        return $result;
    }

    public function solutionBackupArr($key = 0)
    {
        $result = array(
            1 => array(
                'name' => 'yes',
                'val' => 1,
                'title' => self::trans('NETWORK_SOLUTION_STEP_3_02'),
                'des' => self::trans('NETWORK_SOLUTION_STEP_3_03')
            ),
            2 => array(
                'name' => 'no',
                'val' => 2,
                'title' => self::trans('NETWORK_SOLUTION_STEP_3_04'),
                'des' => self::trans('NETWORK_SOLUTION_STEP_3_05')
            )
        );
        if ($key > 0) {
            $result = $result[$key];
        }
        return $result;
    }

    public function solutionPlanArr($key = 0)
    {
        $result = array(
            1 => array(
                'title' => self::trans('NETWORK_SOLUTION_TITLE_02'),
                'img_name' => 'rp_screening3.jpg',
                'number_text' => self::trans('NETWORK_SOLUTION_LIST_02_01')
            ),
            2 => array(
                'title' => self::trans('NETWORK_SOLUTION_TITLE_02'),
                'img_name' => 'rp_screening4.jpg',
                'number_text' => self::trans('NETWORK_SOLUTION_LIST_02_01')
            ),
            3 => array(
                'title' => self::trans('NETWORK_SOLUTION_TITLE_01'),
                'img_name' => 'rp_screening.jpg',
                'number_text' => self::trans('NETWORK_SOLUTION_LIST_02')
            ),
            4 => array(
                'title' => self::trans('NETWORK_SOLUTION_TITLE_01'),
                'img_name' => 'rp_screening2.jpg',
                'number_text' => self::trans('NETWORK_SOLUTION_LIST_02')
            ),
        );
        if ($key > 0) {
            $result = $result[$key];
        }
        return $result;
    }

    /**
     * 新增一个Case到新的服务流程产品表
     * @param $data array
     */
    public function createServiceProcessRequestDemo($data)
    {
        if (is_array($data)) {
            $this->ServiceProcessRequestDemo->create($data);
        }
    }

    /**
     * @param string $number
     * @return array
     */
    public function getRequestDemoInfo($number)
    {
        $result = [];
        if ($number) {
            $result = $this->ServiceProcessRequestDemo
                ->select(
                    [
                        'product_id',
                        'functions',
                        'time_zone',
                        'choose_date',
                        'choose_time'
                    ]
                )
                ->where('number', $number)
                ->first();
            if($result){
                $result = $result->toArray();
                $result['product_info'] = $this->getRequestDemoProductInfo($result['product_id']);
                $result['functions'] = array_filter(explode(';', $result['functions']));
                $result['choose_datetime'] = get_all_languages_date_display(
                    strtotime($result['choose_date']),
                    'default1'
                    ).' '.$result['choose_time'];
            }

        }
        return $result;
    }

    /**
     * @param int $product_id
     * @return array
     */
    public function getRequestDemoProductInfo($product_id = 0){
        $switches_products_arr = array(
            array(
                'products_id' => 108710,
                'products_model' => 'S5860-20SQ',
                'delay_days' => 2,
                'products_description' => '20x SFP+, 25G/40G Uplink',
                'not_include_functions' => [32]
            ),
            array(
                'products_id' => 108716,
                'products_model' => 'S5860-24XB-U',
                'delay_days' => 2,
                'products_description' => '24x 10G-T, 25G Uplink',
                'not_include_functions' => [32]
            ),
            array(
                'products_id' => 108712,
                'products_model' => 'S3910-24TS',
                'delay_days' => 0,
                'products_description' => '24x RJ45, 10G Uplink',
                'not_include_functions' => [9, 34, 35, 37, 38, 39, 40, 42, 43, 54]
            ),
            array(
                'products_id' => 108714,
                'products_model' => 'S3910-48TS',
                'delay_days' => 0,
                'products_description' => '48x RJ45, 10G Uplink',
                'not_include_functions' => [9, 34, 35, 37, 38, 39, 40, 42, 43, 54]
            ),
            array(
                'products_id' => 108718,
                'products_model' => 'S3410-24TS-P',
                'delay_days' => 2,
                'products_description' => '24x POE+ 740W, 10G Uplink',
                'not_include_functions' => [9, 34, 35, 37, 38, 39, 40, 42, 43, 54]
            ),
        );
        if ($product_id) {
            foreach ($switches_products_arr as $product){
                if ($product_id == $product['products_id']) {
                    return $product;
                }
            }
        }
        return $switches_products_arr;
    }
}
