<?php
header('Content-type: text/html; charset=utf-8');
session_start();

// Load config and environment variables
require_once '../../admincp/config/config.php';

// Calculate total amount from session cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Giỏ hàng trống.");
}

$totalAmount = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalAmount += $item['gia_sp'] * $item['so_luong'];
}

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

// Get MoMo configuration from environment variables
$momo_config = momo_config();
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = $momo_config['partner_code'];
$accessKey = $momo_config['access_key'];
$secretKey = $momo_config['secret_key'];

$orderInfo = "Thanh toán qua mã QR MoMo";
$orderId = time() . "";

// Get app URL from environment for redirect URLs
$app_url = app_url();
$redirectUrl = $app_url . "/index.php?quanly=camon";
$ipnUrl = $app_url . "/index.php?quanly=camon";
$extraData = "";

$requestId = time() . "";
$requestType = "captureWallet";
$amount = (string) $totalAmount;  // Set the calculated total amount

// before sign HMAC SHA256 signature
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    'storeId' => "MomoTestStore",
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

$result = execPostRequest($endpoint, json_encode($data));

$jsonResult = json_decode($result, true);

if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit;
} else {
    echo "Error: Unable to retrieve payment URL.";
}
?>
