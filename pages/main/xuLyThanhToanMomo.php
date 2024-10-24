<?php
header('Content-type: text/html; charset=utf-8');


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    
    // Execute POST
    $result = curl_exec($ch);

    // Handle cURL errors
    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "cURL Error: " . $error;
    }

    // Close connection
    curl_close($ch);
    return $result;
}



$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';


$orderInfo = "Thanh toán qua mã QR MoMo";
$amount = "10000";
$orderId = time() ."";
$redirectUrl = "http://7tcc.atwebpages.com/index.php?quanly=camon";
$ipnUrl = "http://7tcc.atwebpages.com/index.php?quanly=camon";
$extraData = "";

    $requestId = time() . "";
    $requestType = "captureWallet";
   $extraData = isset($_POST["extraData"]) ? $_POST["extraData"] : "";

    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature
        );
echo json_encode($data); // In ra dữ liệu JSON
    $result = execPostRequest($endpoint, json_encode($data));
$result = execPostRequest($endpoint, json_encode($data));
if ($result === false) {
    $error = curl_error($ch);
    echo "cURL Error: " . $error;
} else {
    echo "Response: " . $result;
}

    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit; // Ngăn chặn việc tiếp tục xuất dữ liệu
} else {
    echo "Error: Unable to retrieve payment URL.";
}


?>