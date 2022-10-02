<?php

return [
    "parentUuidRequiredIf"            => "非母公司时必须选择父级公司",
    "codeRegex"                       => "主体标识只能是英文字符",
    "foreignNameMustNotChinese"       => "外语名称不能为中文",
    "timeZoneRequired"                => "时差不能为空",
    "motherCompanyCantSetParent"      => "公司类型为母公司时 不能设置父级公司",
    "childCompanyOnlyBeChildOrMother" => "公司类型为子公司时 父级公司类型只能为母公司或子公司",
    'branchCompanyNotBranch'          => '公司类型为分公司时 父级公司不能也为分公司',
    'companyHasRegistrationAddress'   => '公司已编辑注册地址无法再次添加',
    'inOperation'                     => '运营中',
    'hasBeenCancelled'                => '已注销',
    'unknowStatus'                    => '未知状态',
    'existSeamBankAccountInfo'        => '存在相同支付方式和币制的数据',
];
