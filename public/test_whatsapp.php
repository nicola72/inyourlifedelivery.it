<?php
/*curl 'https://api.twilio.com/2010-04-01/Accounts/ACde8a66f7048629c1d3cddb87bf88d31c/Messages.json' -X POST \
--data-urlencode 'To=whatsapp:+393313935540' \
--data-urlencode 'From=whatsapp:+14155238886' \
--data-urlencode 'Body=Your Yummy Cupcakes Company order of 1 dozen frosted cupcakes has shipped and should be delivered on July 10, 2019. Details: http://www.yummycupcakes.com/' \
-u ACde8a66f7048629c1d3cddb87bf88d31c:9b2911497fa8edd1fcd1ce43d0a16ae0*/


$data = [
    'To' => 'whatsapp:+393313935540',
    'From' => 'whatsapp:+14155238886',
    'Body' => 'Ordine da SpeedyFood'
];

$req = '';
foreach ($data as $key => $value)
{
    $value = urlencode(stripslashes($value));
    $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
    $req .= "&$key=$value";
}

$token = 'ACde8a66f7048629c1d3cddb87bf88d31c:9b2911497fa8edd1fcd1ce43d0a16ae0';
//$authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
//$authorization = "Authorization: ".$token; // Prepare the authorisation token

$ch = curl_init('https://api.twilio.com/2010-04-01/Accounts/ACde8a66f7048629c1d3cddb87bf88d31c/Messages.json');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
$res = curl_exec($ch);

if (!$res)
{
    $errstr = curl_error($ch);
    curl_close($ch);
    echo 'fallita chiamata curl '.$errstr;
    return false;
}
else{
    $info = curl_getinfo($ch);
    print_r($res);
    curl_close($ch);
}
