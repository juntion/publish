<?php

return [
    "parentUuidRequiredIf"      => "must set parent company",
    "codeRegex"                 => "code only is charset",
    "foreignNameMustNotChinese" => "foreign name Must Not Chinese",
    "timeZoneRequired"          => "timeZone required",

    "motherCompanyCantSetParent"      => "mother company cont set parent company",
    "childCompanyOnlyBeChildOrMother" => "child company's parent company only been child or mother",
    'branchCompanyNotBranch'          => 'batch company\'s parent company must not branch',
    'companyHasRegistrationAddress'   => 'this company has set registration address',
    'inOperation'                     => 'in operation',
    'hasBeenCancelled'                => 'has been cancelled',
    'unknowStatus'                    => 'unknow status',
    'existSeamBankAccountInfo'        => 'exists seam payment and currency data',
];
