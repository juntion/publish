<?php


namespace App\Services\LiveChat;

use App\Services\BaseService;
use App\Models\LiveChatAdmin;
use App\Models\AllotSalesOperationLog;
use App\Models\LiveChatAdminAssignment;
use Illuminate\Database\Capsule\Manager as DB;

class LiveChatAdminService extends BaseService
{
    private $liveChatAdmin; // live_chat_admin
    private $allotSalesOperationLog;
    private $liveChatAdminAssignment;

    public function __construct()
    {
        parent::__construct();
        $this->liveChatAdmin = new LiveChatAdmin();
        $this->allotSalesOperationLog = new AllotSalesOperationLog();
        $this->liveChatAdminAssignment = new LiveChatAdminAssignment();
    }

    /**
     * @param $allot_register_info
     * @return mixed
     */
    public function getCommonFun($allot_register_info)
    {
        $now_loc = $this->getEnglishSaleId($allot_register_info['language_id']);
        if ($allot_register_info['language_id'] == 1) {
            // 重置分配销售
            $admin_id = $this->resetEnglishSale($now_loc);
        } else {
            // 重置分配销售
            $admin_id = $this->resetOtherLanguageSale($now_loc, $allot_register_info['language_id']);
        }
        return $admin_id;
    }

    /**
     * @param int $language_id
     * @return mixed
     */
    public function getEnglishSaleId($language_id = 1)
    {
        $now_loc = $this->liveChatAdmin
            ->join('admin', 'live_chat_admin.admin_id', '=', 'admin.admin_id')
            ->where('live_chat_admin.is_new', 1)
            ->where('live_chat_admin.language_id', $language_id)
            ->where('live_chat_admin.this_remain_num', '>', 0)
            ->limit(2)
            ->orderBy('live_chat_admin.group_sort', 'asc')
            ->orderBy('live_chat_admin.id', 'asc')
            ->get(['live_chat_admin.id', 'live_chat_admin.admin_id',
                'live_chat_admin.customer_ceiling', 'live_chat_admin.this_remain_num'])
            ->toArray();
        return $now_loc;
    }

    /**
     * @param string $now_loc
     * @return string
     */
    public function resetEnglishSale($now_loc = '')
    {
        if(!$now_loc){  //如果没有查询到对应的销售
            //重置分配序列
            $this->newCustomerAssignmentEn();
            //重新查询
            $now_loc = $this->getEnglishSaleId(1);
        }
        if ($now_loc) {
            $admin_id = $now_loc[0]['admin_id'];
            $this->liveChatAdmin
                ->where('id', $now_loc[0]['id'])
                ->increment('this_already_num', 1);
            $this->liveChatAdmin
                ->where('id', $now_loc[0]['id'])
                ->decrement('this_remain_num', 1);
        }
        if ($now_loc[0]['this_remain_num'] <= 1 && empty($now_loc[1])) {
            $this->newCustomerAssignmentEn();
        }
        return $admin_id ? $admin_id : '';
    }

    /**
     * @param string $now_loc
     * @param $language_id
     * @return mixed|string
     */
    public function resetOtherLanguageSale($now_loc = '', $language_id)
    {
        if (!$now_loc) {    //如果该语种未查询出可以分配的销售
            //重置分配序列
            $this->newCustomerAssignmentOther($language_id);
            //重新获取分配销售
            $now_loc = $this->getEnglishSaleId($language_id);
        }
        //客户分配处理
        if ($now_loc) {
            $admin_id = $now_loc[0]['admin_id'];
            //查询该销售的客户数(以公司为单位)
            $total_customers = DB::connection()->select('select count(distinct mcc.company_number) as num
                                                        from manage_customer_company as mcc
                                                        left join manage_customer_company_to_customers as
                                                         mcctc on mcc.company_number = mcctc.company_number
                                                        where mcctc.admin_id = ' . $admin_id);

            $total_customers_num = $total_customers[0]['num'];
            //如果分配此客户后，达到分配数上限，重置该销售数据，并关闭分配状态
            if ($total_customers_num + 1 >= $now_loc[0]['customer_ceiling']) {
                DB::update('update live_chat_admin set this_total_num = 0,
                        this_already_num = 0,this_remain_num = 0,next_total_num = 0,
                        all_total_num = all_total_num+1,stop_auto = 1 
                        where id = ' . $now_loc[0]['id']);
            } else {
                DB::update(
                    'update live_chat_admin set this_already_num = this_already_num+1,
                        this_remain_num = this_remain_num-1,all_total_num = all_total_num+1 
                        where id = ' . $now_loc[0]['id']
                );
            }
        }
        if ($now_loc[0]['this_remain_num'] <= 1 && empty($now_loc[1])) {
            //如果不存在下一个可分配销售，代表此轮分配已结束，重置分配数据
            $this->newCustomerAssignmentOther($language_id);
        }
        return $admin_id ? $admin_id : '';
    }

    /**
     * @Notes:重置英文销售分配序列
     *
     * @auther: Dylan
     * @Date: 2020/11/20
     * @Time: 18:31
     */
    public function newCustomerAssignmentEn()
    {
        //查询所有的英文销售leader
        $leaders = DB::connection()->select('select l.id,a.admin_id,l.customer_dist_num 
        from live_chat_admin as l left join admin as a on a.admin_id = l.admin_id 
        where a.admin_level in (2,5,13) AND l.language_id = 1 AND a.is_leader = 1 AND l.is_new = 1');
        $leaderToSale = $saleToAss = [];
        if($leaders){
            //查询所有leader绑定的sale
            $sales = DB::connection()->select('select asta.sales,asta.assistant,lca.id,lca.stop_dist_time,lca.stop_auto,lca.next_total_num, 
            lca.insert_dist_num from admin_sales_to_assistant as asta 
            left join live_chat_admin as lca on asta.assistant = lca.admin_id 
            where asta.assistant_tag = 1 AND asta.sales in ('.implode(',',array_column($leaders,'admin_id')).') 
            AND lca.is_new = 1');
            if($sales){
                //查询所有sale绑定的assistant
                $assistants = DB::connection()->select('select asta.sales,asta.assistant,lca.id,lca.stop_dist_time,lca.stop_auto,lca.next_total_num, 
                lca.insert_dist_num from admin_sales_to_assistant as asta 
                left join live_chat_admin as lca on asta.assistant = lca.admin_id 
                where asta.assistant_tag = 2 AND asta.sales in ('.implode(',',array_column($sales,'assistant')).') 
                AND lca.is_new = 1');
                foreach ($assistants as $v){
                    $saleToAss[$v['sales']][] = [
                        'assistant' => $v['assistant'],
                        'liveChatId' => $v['id'],
                        'stop_dist_time' => $v['stop_dist_time'],
                        'stop_auto' => $v['stop_auto'],
                        'next_total_num' => $v['next_total_num'],
                        'insert_dist_num' => $v['insert_dist_num'],
                    ];
                }
            }
            foreach ($sales as $v){
                $leaderToSale[$v['sales']][] = [
                    'assistant' => $v['assistant'],
                    'liveChatId' => $v['id'],
                    'stop_dist_time' => $v['stop_dist_time'],
                    'stop_auto' => $v['stop_auto'],
                    'next_total_num' => $v['next_total_num'],
                    'insert_dist_num' => $v['insert_dist_num'],
                ];
            }
        }

        $nowTime = time();  //当前的时间戳
        $noDistData = [];   //下轮不参与分配的数据
        $distData = [];     //成功分配的数据
        $logData = [];      //分配数据记录
        foreach ($leaders as $v){
            $stopNum = 0;   //停分的数量
            $myGroupAdmin = [];     //自己小组的所有组员
            $mySale = !empty($leaderToSale[$v['admin_id']]) ? $leaderToSale[$v['admin_id']] : [];  //自己的销售
            foreach ($mySale as $saleInfo){
                $myGroupAdmin[] = $saleInfo;
                if($saleInfo['stop_dist_time'] > $nowTime){
                    $stopNum ++;
                }
                $logData[$saleInfo['assistant']] = [
                    'admin_id' => $saleInfo['assistant'],
                    'leader_id' => $v['admin_id'],
                    'language_id' => 1,
                    'group_dist_num' => $v['customer_dist_num'],
                    'dist_num' => $saleInfo['next_total_num'],
                    'insert_num' => $saleInfo['insert_dist_num'],
                    'is_stop' => 0,
                    'total_dist_num' => 0
                ];
                if(!empty($saleToAss[$saleInfo['assistant']])){
                    foreach ($saleToAss[$saleInfo['assistant']] as $assistantInfo){
                        $myGroupAdmin[] = $assistantInfo;
                        if($assistantInfo['stop_dist_time'] > time()){
                            $stopNum ++;
                        }
                        $logData[$assistantInfo['assistant']] = [
                            'admin_id' => $assistantInfo['assistant'],
                            'leader_id' => $v['admin_id'],
                            'language_id' => 1,
                            'group_dist_num' => $v['customer_dist_num'],
                            'dist_num' => $assistantInfo['next_total_num'],
                            'insert_num' => $assistantInfo['insert_dist_num'],
                            'is_stop' => 0,
                            'total_dist_num' => 0
                        ];
                    }
                }
            }
            $actualBaseNum = $v['customer_dist_num'] - $stopNum;   //该小组剩余可分配的数量（不计入新增数量）
            //开始处理小组分配
            foreach ($myGroupAdmin as $groupAdminInfo){
                $next_total_num = $groupAdminInfo['next_total_num'];
                //如果是停分状态，下轮分配数-1
                if($groupAdminInfo['stop_dist_time'] > time()){
                    $next_total_num -- ;
                    $logData[$groupAdminInfo['assistant']]['is_stop'] = 1;
                }

                //如果销售的下一轮分配数为0，或者还处于停分期限内，不进行分配
                if($next_total_num <= 0 && ($next_total_num + $groupAdminInfo['insert_dist_num']) <= 0){
                    $noDistData[] = $groupAdminInfo['liveChatId'];
                    continue;
                }
                if($actualBaseNum > 0 || $groupAdminInfo['insert_dist_num'] > 0){   //如果还有剩余分配数或额外新增分配数
                    if($actualBaseNum - $next_total_num >= 0){  //如果剩余分配数足够分配
                        $actualBaseNum -= $next_total_num;      //剩余分配数减去当前分配数
                        $nowDistNum = $next_total_num + $groupAdminInfo['insert_dist_num'];
                    }else{   //如果剩余分配数不够
                        $nowDistNum = $actualBaseNum + $groupAdminInfo['insert_dist_num'];
                        $actualBaseNum = 0;      //剩余分配数已分配完
                    }
                    $distData[$groupAdminInfo['liveChatId']] = $nowDistNum;
                    $logData[$groupAdminInfo['assistant']]['total_dist_num'] = $nowDistNum;
                }else{  //如果剩余分配数为0
                    $noDistData[] = $groupAdminInfo['liveChatId'];
                }
            }
        }
        if($noDistData || $distData){
            $paramSql = [];
            $sqlWhere = [];
            if($noDistData){
                $paramSql[] = ' WHEN `id` in ('.implode(',',$noDistData).') THEN 0 ';
                $sqlWhere[] = '`id` in ('.implode(',',$noDistData).')';
            }
            if($distData){
                foreach ($distData as $id=>$distNum){
                    $paramSql[] = ' WHEN `id` = '.$id.' THEN '.$distNum;
                }
                $sqlWhere[] = ' `id` in ('.implode(',',array_keys($distData)).')';
            }
            if($paramSql){
                $updateSql = implode(' ',$paramSql);
                DB::connection()->update('UPDATE `live_chat_admin` SET `this_already_num` = 0,
            `this_total_num` = CASE '.$updateSql.' END,`this_remain_num` = CASE '.$updateSql.' END 
            WHERE '.implode(' || ',$sqlWhere));
            }
        }
        //记录当前轮次的分配数据
        if($logData){
            try {
                $a = $this->liveChatAdminAssignment
                    ->insert($logData);
            } catch (\Exception $e) {}

        }
    }

    /**
     * @Notes:多语言新客户分配重置分配序列
     *
     * @param $language_id
     * @auther: Dylan
     * @Date: 2020/11/20
     * @Time: 18:31
     */
    public function newCustomerAssignmentOther($language_id)
    {
        $saleList = DB::connection()->select('select l.id,l.admin_id,l.stop_auto,l.next_total_num,l.insert_dist_num,l.stop_dist_time,l.customer_ceiling 
        from live_chat_admin as l right join admin as a on l.admin_id = a.admin_id where l.is_new = 1 AND l.language_id = ?', [$language_id]);
        $saleCustomerNum = [];
        if($saleList){
            $total_customers = DB::connection()->select('select count(distinct mcc.company_number) as num,mcctc.admin_id 
                                                        from manage_customer_company as mcc
                                                        left join manage_customer_company_to_customers as mcctc on mcc.company_number = mcctc.company_number
                                                        where mcctc.admin_id in ('.implode(',', array_column($saleList,'admin_id')).') 
                                                        group by mcctc.admin_id');
            $saleCustomerNum = array_column($total_customers,'num','admin_id');
        }

        $noDistData = [];       //下轮不参与分配的数据
        $stopDistData = [];     //停分数据
        $stopDistLog = [];      //停分日志数据
        $logData = [];      //分配记录
        foreach ($saleList as $saleData){
            $logData[$saleData['admin_id']] = [
                'admin_id' => $saleData['admin_id'],
                'language_id' => $language_id,
                'dist_num' => $saleData['next_total_num'],
                'dist_ceiling' => $saleData['customer_ceiling'],
                'now_customers_num' => 0,
                'is_stop' => 0,
                'total_dist_num' => 0
            ];
            $next_total_num = $saleData['next_total_num'];
            //如果是停分状态，下轮分配数-1
            if($saleData['stop_dist_time'] > time()){
                $next_total_num -- ;
                $logData[$saleData['admin_id']]['is_stop'] = 1;
            }
            $customerNum = isset($saleCustomerNum[$saleData['admin_id']]) ? $saleCustomerNum[$saleData['admin_id']] : 0;
            $logData[$saleData['admin_id']]['now_customers_num'] = $customerNum;
            //如果销售的下一轮分配数为0
            if($next_total_num <= 0){
                $noDistData[] = $saleData['id'];
                continue;
            }
            //如果该销售的当前客户数已经大于客户数上限，则停止分配
            if($customerNum > $saleData['customer_ceiling']){
                $info = '重置分配序列，销售当前客户数('.$customerNum.')大于设置的客户数上限('.$saleData['customer_ceiling'].')，停止分配';
                $stopDistData[] = $saleData['id'];
                $stopDistLog[] = ['info' => $info, 'admin_id' => $saleData['admin_id'], 'who_do_this' => 0, 'do_time' => date('Y-m-d H:i:s'), 'do_table' => 'live_chat_admin'];
                continue;
            }
            $updateData = [
                'this_total_num' => $next_total_num,
                'this_already_num' => 0,
                'this_remain_num' => $next_total_num
            ];
            $logData[$saleData['admin_id']]['total_dist_num'] = $next_total_num;
            $this->liveChatAdmin
                ->where('id', $saleData['id'])
                ->update($updateData);
        }
        if($noDistData){
            $this->liveChatAdmin
                ->whereIn('id', $noDistData)
                ->update([
                    'this_total_num'=>0,
                    'this_already_num'=>0,
                    'this_remain_num'=>0
                ]);
        }
        if($stopDistData){
            $this->liveChatAdmin
                ->whereIn('id', $stopDistData)
                ->update([
                    'stop_auto'=>1,
                    'this_total_num'=>0,
                    'this_already_num'=>0,
                    'this_remain_num'=>0
                ]);
        }
        if($stopDistLog){
            $this->allotSalesOperationLog
                ->insert($stopDistLog);
        }
        if($logData){
            //记录当前轮次的分配数据
            if($logData){
                try {
                    $this->liveChatAdminAssignment
                        ->insert($logData);
                } catch (\Exception $e) {}
            }
        }
    }
}
