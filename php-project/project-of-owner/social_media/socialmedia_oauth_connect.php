<?php
ini_set("display_errors", "On");
error_reporting(E_ERROR);
class socialmedia_oauth_connect
{

  	public $socialmedia_oauth_connect_version = '1.0';

	public $client_id;
	public $client_secret;
	public $scope;
	public $responseType;
	public $nonce;
	public $state;
	public $redirect_uri;
	public $code;
	public $oauth_version;
	public $provider;
	public $accessToken;  
	
	protected $requestUrl;
  	protected $accessTokenUrl;
  	protected $dialogUrl;
	protected $userProfileUrl;
	protected $header;
	
  	public function Initialize(){
  		$this->nonce = time() . rand();
  		switch($this->provider)
		{
			case '';
				break;
				
			case 'Paypal':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?';
				$this->accessTokenUrl = 'https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/tokenservice?';
				$this->responseType="code";
				$this->state="";
				$this->userProfileUrl = "https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/userinfo?schema=openid&access_token=";
				$this->header="";
				break;
				
			case 'Google':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://accounts.google.com/o/oauth2/auth?';
				$this->accessTokenUrl = 'https://accounts.google.com/o/oauth2/token';
				$this->responseType="code";
				$this->userProfileUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=";
				$this->header="Authorization: Bearer ";	
				break;


			case 'Facebook':
				$this->oauth_version="2.0";
				$this->dialogUrl = 'https://www.facebook.com/v2.8/dialog/oauth?';
				$this->accessTokenUrl = 'https://graph.facebook.com/v2.8/oauth/access_token';
				$this->responseType="code";
				$this->userProfileUrl = "https://graph.facebook.com/v2.8/me?fields=email,birthday,name,last_name,first_name&access_token=";
				$this->header="";
				break;


			case 'Microsoft':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://login.live.com/oauth20_authorize.srf?';
				$this->accessTokenUrl = 'https://login.live.com/oauth20_token.srf';
				$this->responseType="code";
				$this->userProfileUrl = "https://apis.live.net/v5.0/me?access_token=";
				$this->header="";
				break;
			
			case 'LinkedIn':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://www.linkedin.com/uas/oauth2/authorization?';
				$this->accessTokenUrl = 'https://www.linkedin.com/uas/oauth2/accessToken';
				$this->responseType="code";
				$this->userProfileUrl = "https://api.linkedin.com/v2/me";
				break;

			default:
				return($this->provider.'is not yet a supported. We will release soon. Contact kayalshri@gmail.com!' );	
		}
  	}

	/**
	 * 获取授权码code
	 */
  	public function Authorize(){
  		if($this->oauth_version == "2.0"){
  			//todo:请求授权码code
  	    $dialog_url = $this->dialogUrl
  	    		."client_id=".$this->client_id	//客户端ID
			."&response_type=".$this->responseType   //授权类型
			."&scope=".$this->scope   //申请的权限范围
			/*."&nonce=".$this->nonce*/
			."&state=".$this->state   //状态码，客户端自己指定
        	."&redirect_uri=".urlencode($this->redirect_uri);
     		echo("<script> top.location.href='" . $dialog_url . "'</script>");		//请求服务器，服务器再重定向到redirect_uri 附上 code state
     		}else{
			$date = new DateTime();
     			$request_url = $this->requestUrl;
     			$postvals ="oauth_consumer_key=".$this->client_id	//
     					."&oauth_signature_method=HMAC-SHA1"
     					."&oauth_timestamp=".$date->getTimestamp()
     					."&oauth_nonce=".$this->nonce
     					."&oauth_callback=".$this->redirect_uri
     					."&oauth_signature=".$this->client_secret
     					."&oauth_version=1.0";
     			$redirect_url = $request_url."".$postvals;
			//todo:accesstoken
     			$oauth_redirect_value= $this->curl_request($redirect_url,'GET','');
			//登陆页面
  			$dialog_url = $this->dialogUrl.$oauth_redirect_value;
			echo("<script> top.location.href='" . $dialog_url . "'</script>");
     		}

  	}

	/**
	 * curl-1
	 * 从给定的url，远程获取数据
	 * @param string $url  要请求的url
	 * @param string $method   请求的方法get/post
	 * @param mix $data     参数（跟在url后面的参数，可以是数组）
	 * @return string   返回请求的数据
	 */
	public function http_request($url, $method = 'get', $data = '')
	{
		//parse_url — 解析 URL，返回其组成部分
		$urlArr = parse_url($url);
		//$urlArr['scheme'] = 'http',见手册
		$scheme = $urlArr['scheme'];

		//拼接url参数
		$arr = '';
		if(is_array($data)){
			foreach ($data as $key => $val){
				$arr .= $key."=".$val."&";
			}
			//trim() 函数移除字符串两侧的空白字符或其他预定义字符
			$arr = trim($arr, '&');
		}else{
			$arr = $data;
		}
		//url地址
		if($arr){
			$requested_url = $url."?".$arr;
		}else{
			$requested_url = $url;
		}

		/**
		 * 把curl看做一个服务器，它可以对一个网页进行访问
		 * 因此：curl就可以在访问的同时传递参数；同时也能获得访问页面的响应
		 * 传参方式可以使get，也可以是post（有点像ajax请求数据）
		 */
		//curl 获取数据
		$ch = curl_init();

		//get提交数据
		if(strtolower($method) == 'get'){
			//get :通过get方式，把数据提交到向指定地址，（数据放在url后面）
			curl_setopt($ch, CURLOPT_URL, $requested_url );
		}
		//post提交
		if(strtolower($method) == 'post'){
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST,1);
			//通过post把$arr，传到指定的url
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
		}
		//是否检查证书,如果是安全程度高的方式
		if($scheme == 'https'){
			//检查证书设置
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//采集数据
		$relust = curl_exec($ch);
		//错误处理
		if(curl_errno($ch)){
			return curl_error($ch);
		}
		//关闭
		curl_close($ch);
		return $relust;
	}

	/**
	 * curl-2
	 * @param $url
	 * @param string $method
	 * @param string $data
	 * @param array $headers
	 * @param bool $debug
	 * @return mixed
	 */
	public function curlPort($url, $method = 'GET', $data = '', $headers = array(),$debug = false){
		if($method === false){
			$method = 1;
		}elseif($method === true){
			$method = 2;
		}
		$method = strtoupper($method);
		switch ($method){
			case 1:
				$method = 'GET';
				break;
			case 2:
				$method = 'POST';
				break;
			case 3:
				$method = 'DELETE';
				break;
			default:
				$methodArray = array('GET','POST','DELETE');
				if(!in_array($method,$methodArray)){
					$method = 'GET';
				}
				break;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);//超时时间
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//忽略证书验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);// 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置头文件
		curl_setopt($ch, CURLOPT_HEADER, 0);// 是否显示返回的Header区域内容
		//curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);// ipv4

		switch($method) {
			case 'GET':
				break;
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置请求体，提交数据包
				break;
			case 'PUT':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置请求体，提交数据包
				break;
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}

		$result = curl_exec($ch);
		if($debug){
			$errno = curl_errno($ch);
			$error = curl_error($ch);
			$info = curl_getinfo($ch);
			$info['errno'] = $errno;
			$info['error'] = $error;
			$info['result'] = $result;
			$result = $info;
		}
		curl_close($ch);
		return $result;
	}
	/**
	 * curl-3
	 * curl 获取数据
	 * @param $url
	 * @param $method
	 * @param $postvals
	 * @return mixed
	 */
	public function curl_request($url,$method,$postvals){

		$ch = curl_init($url);
		if ($method == "POST"){
			$options = array(
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $postvals,
				CURLOPT_RETURNTRANSFER => 1,
			);

		}else{

			$options = array(
				CURLOPT_RETURNTRANSFER => 1,
			);

		}
		curl_setopt_array( $ch, $options );
		if($this->header){

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( $this->header . $postvals) );
		}

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	/**
	 * @return mixed
	 * 拼接accessToken url 获取  accessToken
	 */
	public function getAccessToken(){
		//todo:获取令牌
		$postvals = "client_id=".$this->client_id	//客户端ID
			."&client_secret=".$this->client_secret   //客户端密码
			."&grant_type=authorization_code"   //授权模式
			."&redirect_uri=".urlencode($this->redirect_uri)   //重定向URI
			."&code=".$this->code;  //授权码
		return $this->http_request($this->accessTokenUrl,'POST',$postvals);
	}

	/**
	 * 获取facebook   accessToken
	 * @return string
	 */
	public function getFacebookAccessToken(){
		//todo:获取令牌
		$token =  $this->curlPort($this->tokenUrl(), $method = 'GET', $data = '', $headers = array(),$debug = false);
		$ret = json_decode($token);	//解码之后仍然是对象
		return $ret->access_token;
	}

	/**
	 * 获取拼接的url
	 * @return string
	 */
	public function tokenUrl(){
		$postvals = "client_id=".$this->client_id	//客户端ID
			."&client_secret=".$this->client_secret   //客户端密码
			."&grant_type=authorization_code"   //授权模式
			."&redirect_uri=".urlencode($this->redirect_uri)   //重定向URI
			."&code=".$this->code;  //授权码
		$url = $this->accessTokenUrl.'?'.$postvals;
		return $url;
	}

	/**
	 * 用accesstoken  访问api获取用户数据
	 * @return mixed
	 */
	public function getUserProfile(){
		$getAccessToken_value = $this->getAccessToken();
		$getatoken = json_decode( stripslashes($getAccessToken_value) );

		if( $getatoken === NULL ){
			$atoken=$getAccessToken_value;
		}else{
			$atoken = $getatoken->access_token;
		}

		if($this->provider=="Yammer"){
			$atoken = $getatoken->access_token->token;
		}
		if ($this->userProfileUrl){
			$profile_url = $this->userProfileUrl."".$atoken;
			$result = $this->http_request($profile_url,"GET");
			return $result;
		}else{
			return $getAccessToken_value;
		}

	}

	/**
	 * 获取
	 * @param $atoken
	 * @return mixed
	 */
	public function getFacebookInfo($atoken){
		$url = $this->userProfileUrl.$atoken;
		return $this->$this->curlPort($url, $method = 'GET', $data = '', $headers = array(),$debug = true);
	}
	/**
	 * 请求自定义api
	 * @param $url
	 * @return mixed
	 */
	public function APIcall($url){
		return $this->curl_request($url,"GET",$_SESSION['atoken']);
	}

	/**
	 * 调试google
	 * @param $data
	 */
	public function debugGoogleJson($data){
		//print_r($data);
		$id  = $data->id; $email = $data->email; $gName = $data->given_name; $fName = $data->family_name; $gender = $data->gender;
		echo "<script type=\"text/javascript\">
		$.ajax({
			url: '../ajax_customers_social_media_login.php?ajax_request_action=google',
			data: 'gid='+'".$id."'+'&email='+'".$email."'+'&gName='+'".$gName."'+'&fName='+'".$fName."'+'&gender='+'".$gender."', 
			type: 'POST',
		  	success: function(data){
				if('ok' == data) window.location.href ='http://www.fs.com';
			}
		})
		</script>";
	}
	public function login_other_Json($data,$type){
		//print_r($data);
		$pink = "";
		if($type=="google"){
			$id  = $data->id; $email = $data->email; $gName = $data->given_name; $fName = $data->family_name; $gender = $data->gender;
		}elseif($type=="Linkedin"){
			$email = $data->emailAddress; $gName = $data->lastName; $fName = $data->firstName;$id = $data->id;
			$gender = "";
		}elseif ($type=="facebook"){
			$email = $data->email; $gName = $data->last_name; $fName = $data->first_name;$id = $data->id;
			$gender = "";
		}elseif ($type=="paypal"){
			$name = explode(" ",$data->name);
			$email = $data->email;
			$gName = $name[1] ? $name[1]:"";
			$fName = $name[0] ? $name[0]:"";
			$zoneinfo = $data->zoneinfo;
			$id = $data->user_id;
			$gender = "";
			$pink = "&zoneinfo=".$zoneinfo;
		}
		echo "<script type=\"text/javascript\">
		$.ajax({
			url: '../ajax_customers_social_media_login.php?ajax_request_action={$type}',
			data: 'gid='+'".$id."'+'&email='+'".$email."'+'&gName='+'".$gName."'+'&fName='+'".$fName."'+'&gender='+'".$gender."'+'".$pink."', 
			type: 'POST',
			dataType:'json',
		  	success: function(data){
				if('ok' == data.msg){
					 window.location.href = data.url;
				}
			}
		})
		</script>";
	}
	/**
	 * 调试paypal
	 * @param $data
	 */
	public function debugPaypalJson($data){
		//print_r($data);
		$email = $data->email; $gName = $data->given_name; $fName = $data->family_name; $zoneinfo = $data->zoneinfo;
		echo "<script type=\"text/javascript\">
		$.ajax({
			url: '../ajax_customers_social_media_login.php?ajax_request_action=paypal',
			data: 'email='+'".$email."'+'&gName='+'".$gName."'+'&fName='+'".$fName."'+'&zoneinfo='+'".$zoneinfo."', 
			type: 'POST',
		  	success: function(data){
				if('ok' == data) window.location.href ='http://www.fs.com';
			}
		})
		</script>";
		
	}

	/**
	 * 调试facebook
	 * @param $data
	 */
	public function debugFacebookJson($data){
		$email = $data->email; $name = $data->name; $id = $data->id;
		echo "<script type=\"text/javascript\">
		$.ajax({
			url: '../ajax_customers_social_media_login.php?ajax_request_action=facebook',
			data: 'email='+'".$email."'+'&name='+'".$name."'+'&id='+'".$id."', 
			type: 'POST',
			dataType: 'json',
		  	success: function(data){
		  	//alert(data)
				if('ok' == data) window.location.href ='http://www.fs.com';
			}
		})
		</script>";

	}

	/**
	 * 打印一个变量
	 * @param $var mixed 变量
	 */
	public function E($var){
		if(is_bool($var)){
			var_dump($var);
		}elseif(is_null($var)){
			var_dump(NULL);
		}else{
			echo "<pre style='position:relative; z-Index: 1000; padding: 10px; border-radius: 5px;background: #F5F5F5;
                border: 1px solid #8d8d8f; font-size: 20px; line-height: 18px; opacity: 0.9;'>"
				.print_r($var, true).'</pre>';
		}
	}
	
	public function getLinkedinUserProfile(){
		$postvals = "client_id=".$this->client_id	//客户端ID
			."&client_secret=".$this->client_secret   //客户端密码
			."&grant_type=authorization_code"   //授权模式
			."&redirect_uri=".$this->redirect_uri   //重定向URI
			."&code=".$this->code;  //授权码
		//获取accessToken
		$getatoken = json_decode($this->http_request($this->accessTokenUrl,'post',$postvals)); 
		
		$atoken = $getatoken->access_token;
		$data = "oauth2_access_token=".$atoken."&projection=(id,firstName,lastName,email-address)";
		//获取用户信息
		$userprofile = json_decode($this->http_request($this->userProfileUrl,"GET",$data));

		$email_url = 'https://api.linkedin.com/v2/emailAddress';
		$info = "oauth2_access_token=".$atoken."&q=members&projection=(elements*(handle~))";
		$data = json_decode($this->http_request($email_url,'GET',$info),true);
		$userprofile->emailAddress = isset($data['elements'][0]['handle~']['emailAddress']) ? $data['elements'][0]['handle~']['emailAddress']:"";
		$email_prefix = isset($userprofile->emailAddress) ? explode("@",$userprofile->emailAddress)[0]:"";
		$userprofile->firstName = isset($userprofile->firstName->localized->en_US) ? $userprofile->firstName->localized->en_US:$email_prefix ;
		$userprofile->lastName = isset($userprofile->lastName->localized->en_US) ? $userprofile->lastName->localized->en_US:$email_prefix ;
		return $userprofile;
	}
	public function debugLinkedinJson($data){
		$email = $data->emailAddress; $firstname = urlencode($data->firstName); $lastname = urlencode($data->lastName);$id = $data->id;
		$str = "<script type=\"text/javascript\">
		$.ajax({
			url: '../ajax_customers_social_media_login.php?ajax_request_action=Linkedin',
			data: 'email='+'".$email."'+'&firstname='+'".$firstname."'+'&id='+'".$id."'+'&lastname='+'".$lastname."', 
			type: 'POST',
			dataType: 'html',
		  	success: function(data){
				if('ok' == data) window.location.href ='http://www.fs.com/';
			}
		})
		</script>";
		echo $str;
	}

}
?>

<script src="../includes/templates/fiberstore/jscript/jquery.min.js"></script>