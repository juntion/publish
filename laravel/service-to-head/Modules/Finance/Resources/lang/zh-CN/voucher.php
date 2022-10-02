<?php

return [
    'onlyOneDataIsTwo'           => '到款信息和订单信息只能有一个是多条',
    'DKNotSeamCompanyNumber'     => '多条DK支出凭证，所有DK必须认领到同一个公司',
    'DKNotSeamCustomer'          => '多条到款必须时同一个客户编码',
    'DKAndOrderMustSeamCompany'  => '到款必须和订单是同一个公司编码',
    'orderNotExists'             => '订单不存在',
    'DKPriceNotEnough'           => 'DK 总可用金额不足，无法支出',
    'createVoucherFailed'        => '创建用款凭证失败',
    'DKCanUsedZero'              => 'DK 无可用金额',
    'revokeSuccess'              => '返还成功',
    'voucherNotFound'            => '凭证未找到',
    'splitSuccess'               => '明细拆分成功',
    'splitFailed'                => '明细拆分失败',
    'orderNotFound'              => '未找到对应的订单信息',
    'voucherPriceNotEnough'      => '凭证可使用金额不足',
    'revokeFailed'               => '返还失败',
    'orderPriceNotRight'         => '订单金额有误',
    'mustAllHasParentId'         => '所有订单必须都有parent_id 参数',
    'NotFoundParentDetail'       => '未找到指定的父级凭证使用详情',
    'parentDetailsPriceNotEnough'=> '父级金额不足小于订单金额，无法拆分',
    'receiptNotYoursOrUsed'      => '无权使用该凭证或凭证可使用金额为0',
    'russianPaymentOnlyUsedRussian' => '俄罗斯对公支付到款只能用于支出俄罗斯对公支付订单'
];
