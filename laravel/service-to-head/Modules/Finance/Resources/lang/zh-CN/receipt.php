<?php

return [
    'statusNotAllowUpdate' => '当前状态无法更新到款信息',
    'statusNotAllowDelete' => '当前状态无法删除到款信息',
    'activeSuccess'        => '操作成功，到款已可用',
    'statusNotAllowActive' => '当前状态不可恢复软删除',
    'statusAllowClaim'     => '当前状态不可创建到款认领审请',
    'storeClaimSuccess'    => '创建认领申请成功',
    'deleteClaimSuccess'   => '删除申请成功',
    'storeFailed'          => '创建认领申请失败',
    'notAllowDelete'       => '当前状态不允许删除',
    'deleteClaimFailed'    => '删除申请失败',
    'verifySuccess'        => '操作成功',
    'verifyFailed'         => '操作失败',
    'storeClaimFailed'     => '创建申请失败',
    'claimNotAllowVerify'  => '申请无法审核',
    'fileNotOneReceipt'    => '附件不属于同一个到款信息',
    'notFound'                      => '未找到对应的到款信息',
    'fileError'                     => '文件表头未找的对应的模板，请检查附件是否正确',
    'paymentError'                  => '支付方式错误',
    'dataIsBad'                     => '数据不符合要求',
    'uploadSuccess'                 => '上传成功',
    'receiptNotFound'               => '未找到指定单号的到款',
    'accountNotFound'               => '未找到指定到款公司信息',
    'customerNumberError'           => '客户编号错误！未找到对应的公司信息',
    'notAllowVerify'                => '当前状态禁止审核',
    'createClaimFailed'             => '创建到款失败',
    'validatorFailed'               => '参数校验失败',
    'invalidPaymentMethod'          => '无效的到款方式',
    'fileTypeNotAllow'              => '不支持该格式的上传,请上传xls 或者xlsx 格式的excel 表格',
    'applyMustHasCustomer'          => '认领申请必须有客户信息',
    'verifyClaimFailed'             => '审核失败',
    'voucherDataError'              => '凭证数据有误',
    'detailOrderDataError'          => '凭证详情订单数据有误',
    'uploadFailed'                  => '存在导入失败数据，请查看下载的附件',
    'downloadInQueue'               => '由于数据量太大，系统已在后台运行生成表格，完成之后将发送至你的邮箱.',
    'userNotFound'                  => '未找到指定adminId 的用户',
    'transactionSerialNumberUnique' => '银行流水号已存在',
    'receiptCanUseNotEnough'        => 'DK剩余可用不足',
    'receiptNotUseTooMany'          => '退还金额不能大于DK实际使用金额',
    'orderUseMoreThanReceipt'       => '订单使用金额大于DK可用金额',
    'orderCurrencyError'            => '提交的订单币值有误',
    'DKCurrencyError'               => '提交的DK币值有误',
    'exchangeError'                 => '币值转换金额有误',
    'DKUseNoteEqualOrder'           => 'DK使用总金额不等于订单金额',
    'apiStoreFailed'                => '应付申请创建DK失败',
    'notFoundApplyIdUser'           => '未找到指定id的认领人信息',
    'advanceNotAllowDeleteFromList' => '该到款为款项申请产生的DK，请到款项申请中，申请撤销',
    'advanceHasUsed'                => '款项申请产生的DK已被使用无法删除',
];