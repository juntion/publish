<?php
// 服务器端的验证
if(sizeof($current_valide)){
    foreach ($current_valide['rules'] as $key => $val){
        if( strpos($key,'agree') === false && $val['required']){ // 服务器端不需要判断是否勾选协议
            if(!$$key){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['required'],'data'=>'')));
            }
        }
        if( $val['fs_depend_required']){ // /当其他元素为某个值时候必填
            $depend_input = $$val['fs_depend_required'][0];
            if($depend_input==$val['fs_depend_required'][1]){
                if($$key==''){
                    exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['fs_depend_required'],'data'=>'')));
                }
            }
        }
        if( $val['fs_visible_required']){ // /当元素可见时候必填
            $visible_input = $key.'_visible';
            if($$visible_input && $$key==''){
                if($$key==''){
                    exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['fs_visible_required'],'data'=>'')));
                }
            }
        }

        if( $val['minlength']){
            if($$key && strlen($$key)<$val['minlength']){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['minlength'],'data'=>'')));
            }
        }
        if( $val['maxlength']){
            if($$key && strlen($$key)>$val['maxlength']){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['maxlength'],'data'=>'')));
            }
        }
        if( $val['digits']){
            $reg_digits = '/^\d+$/';
            if($$key && !preg_match($reg_digits,$$key) ){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['digits'],'data'=>'')));
            }
        }
        // 正整数
        if( $val['positiveinteger']){
            $reg_positiveinteger = '/^\d+$/';
            if($$key && (!preg_match($reg_positiveinteger,$$key) || $$key<=0) ){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['positiveinteger'],'data'=>'')));
            }
        }
        if( $val['FSemail']){
            $reg_email = '/^[ \w\.\-\+]+\@[\w\.\-\+]+\.[\w\.\-]+$/';
            if($$key && !preg_match($reg_email,$$key) ){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['FSemail'],'data'=>'')));
            }
        }
        if( $val['FSpwd']){
            $reg_pwd = '/^(?![0-9_\.\?\@\!\#\$\%\^\&\*]+$)(?![a-zA-Z_\.\?\@\!\#\$\%\^\&\*]+$)[0-9A-Za-z_\.\?\@\!\#\$\%\^\&\*]{6,}$/';
            if($$key && !preg_match($reg_pwd,$$key) ){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['FSpwd'],'data'=>'')));
            }
        }
        if( $val['FSphone']){
            $phone_pwd = '/^[0-9]{6,32}$/';
            if($$key && !preg_match($phone_pwd,$$key) ){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['FSphone'],'data'=>'')));
            }
        }

        if( $val['equalTo']){
            $equal_to_input = substr($val['equalTo'],1,strlen($val['equalTo'])-1); //去掉前面的#
            if($$key && $$key != $$equal_to_input){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['equalTo'],'data'=>'')));
            }
        }

        if($val['orderNumber']){
            $reg_order = '/^FS\d{12}$/';
            if($$key && !preg_match($reg_order,$$key)){
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['orderNumber'],'data'=>$$key)));
            }
        }

        if ($val['fsVerify']) {
            $verifyPreg = '/^[0-9A-Z]+$/';
            if ($$key && !preg_match($verifyPreg,$$key)) {
                exit(json_encode(array('status'=>'0','info'=>$current_valide['messages'][$key]['fsVerify'],'data'=>'')));
            }
        }
    }
}
