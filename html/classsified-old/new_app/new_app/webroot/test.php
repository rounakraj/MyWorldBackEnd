<?php
error_reporting(E_ALL);
$adhar_card_no = "592383793120";

function buildUrl($adhar_card_no)
{
    $host = "http://auth.uidai.gov.in";
    $version = 1.6;
    $aua = "";
    $asalk = "";
    $uid = str_split($adhar_card_no);
    $url =  $host."/".$version."/".$aua."/".$uid[0]."/".$uid[1]."/".$asalk;
    return $url;
}

function requestDataBuilder($uid)
{
    $encrypted_encoded_session_key = "";
    $encrypted_pid_block = "";
    $sha256_pid_bloc_encrypted_encoded= "";
    $digital_aua_signatrure= "";
    /**
     * Authentication data to send request --Mandatory
     */
    $auth_data = [
        "uid" => $uid, //Adhaar Card No.
        "tid" => "", //Terminal Id for registered device else public
        "ac" => "", //10 char unique code, public for testing
        "sa" => "", //max length 10, same as ac possible
        "ver" => 1.6, //Current version
        "txn" => "", //AUA transaction  identifier. max length 50, not U*
        "lk" => "", //Valid License Key, max length 64
    ];
    /**
     * Uses data comprises of options as yes (y) or no (n) -- Mandatory
     */
    $uses_data = [
        "pi" => "n",
        "pa" => "n",
        "pfa" => "n",
        "bio" => "n",
        "bt" => "n",
        "pin" => "n",
        "otp" => "n"
    ];
    /**
     * Token data -- optional
     */
    $tkn_data = [
        "type" => "001", //only this option available for now which is mobile no.
        "value" => "" //Mobile no. 10 digit only no prefix
    ];
    /**
     * Meta Data Mandatory
     */
    $meta_data = [
        "udc" => $udc, //[vendorcode][date of deployment][serial number] max length 20
        "fdc" => "NA", //Fingerprint device code. use NA or NC or given code
        "idc" => "NA", //Iris device  code,  us na or NC
        "pip" => "NA", //Public IP address of the device, or NA
        "lot" => "P", //G -lat long format. p for pincode format
        "lov" => "110025" // value as per G and P- my pin change it
    ];
    /**
     * Skey data -- Mandatory
     */
    $skey_data = [
        "ci" => "", //Public key certificate Identifier --mandatory
        "ki" => "" //This is for advanced use only, --optional
    ];
	$format ='';
    $format = '<Auth uid="'.$auth_data['uid'].'" tid ="'.$auth_data['tid'].'" ac="'.$auth_data['ac'].'" sa="'.$auth_data['sa'].'" ver="'.$auth_data['ver'].'" txn="'.$auth_data['txn'].'" lk="'.$auth_data['lk'].'">';
    $format.= '<Uses pi="'.$uses_data['pi'].'" pa="'.$uses_data['pa'].'" pfa="'.$uses_data['pfa'].'" bio="'.$uses_data['bio'].'" bt="'.$uses_data['bt'].'" pin="'.$uses_data['pin'].'" otp="'.$uses_data['otp'].'"/>';
    $format.= '<Tkn type="'.$tkn_data['type'].'" value="'.$tkn_data['value'].'"/>';
    $format.= '<Meta udc="'.$meta_data['udc'].'" fdc="'.$meta_data['fdc'].'" idc="'.$meta_data['idc'].'" pip="'.$meta_data['pip'].'" lot="'.$meta_data['lot'].'" lov="'.$meta_data['lov'].'"/>';
    $format.= '<Skey ci="'.$skey_data['ci'].'" ki="'.$skey_data['ci'].'">'.$encrypted_encoded_session_key.'</Skey>';
    $format.= '<Data type="X">'.$encrypted_pid_block.'</Data>';
    $format.= '<Hmac>'.$sha256_pid_bloc_encrypted_encoded.'</Hmac>';
    $format.= '<Signature>'.$digital_aua_signatrure.'</Signature></Auth>';
    
	return $format;    

}
$request_url = buildUrl($adhar_card_no);
$data_to_senddata_to_send = requestDataBuilder($adhar_card_no); 

//setting the curl parameters.
$ch = curl_init();
$curl_options = [
    CURLOPT_URL => $request_url,
    CURLOPT_VERBOSE => 1,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_HTTPHEADER => array('Content-Type: application/xnl'),
    CURLOPT_POSTFIELDS => $data_to_senddata_to_send
];
curl_setopt_array($ch, $curl_options);
 $response = curl_exec($ch);
    print_r($response);
    curl_close($ch);
if (curl_errno($ch)) {
// moving to display page to display curl errors
    echo curl_errno($ch) ;
    echo curl_error($ch);
} else {
    //getting response from server
    $response = curl_exec($ch);
    print_r($response);
    curl_close($ch);
}
?>