<?php
define('KEY', 'AWQBhRCal-xSrqQ78Y_MikISpXF-ajVhAWYbZxK8qeyg85eMj1Wpa7jOdWqw');
define('SECRET', 'ENlY7RAK8DEEtjoGyxDq30bz7TGu2GBuubVXg7chd0BxOFmIRPp7AcsbqXrJ');

define('CALLBACK_URL', 'www.fiberstore.us/test/paypal/complete.php');
define('AUTHORIZATION_ENDPOINT', 'https://identity.x.com/xidentity/resources/authorize');
define('ACCESS_TOKEN_ENDPOINT', 'https://identity.x.com/xidentity/oauthtokenservice');
define('PROFILE_ENDPOINT', 'https://identity.x.com/xidentity/resources/profile/me');

/***************************************************************************
 * Function: Run CURL
 * Description: Executes a CURL request
 * Parameters: url (string) - URL to make request to
 *             method (string) - HTTP transfer method
 *             headers - HTTP transfer headers
 *             postvals - post values
 **************************************************************************/
function run_curl($url, $method = 'GET', $postvals = null){
    $ch = curl_init($url);
    
    //GET request: send headers and return data transfer
    if ($method == 'GET'){
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSLVERSION => 3
        );
        curl_setopt_array($ch, $options);
    //POST / PUT request: send post object and return data transfer
    } else {
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_POSTFIELDS => $postvals,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSLVERSION => 3
        );
        curl_setopt_array($ch, $options);
    }
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}
?>