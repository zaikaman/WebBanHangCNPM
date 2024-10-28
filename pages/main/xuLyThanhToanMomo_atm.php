<?php
session_start();
header('Content-type: text/html; charset=utf-8');

// Function to calculate total amount
function calculateTotalAmount() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("Giỏ hàng trống.");
    }

    $totalAmount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalAmount += $item['gia_sp'] * $item['so_luong'];
    }

    // Ensure amount is a string and compatible with MoMo's minimum requirement
    if ($totalAmount < 10000) {
        die("Tổng số tiền phải lớn hơn hoặc bằng 10,000 VND để thực hiện thanh toán qua MoMo.");
    }

    return (string)$totalAmount;
}

// Function to execute POST requests
function execPostRequest($url, $data) {
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

    $result = curl_exec($ch);
    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "cURL Error: " . $error;
    }

    curl_close($ch);
    return $result;
}

// MoMo Payment settings
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$redirectUrl = "http://7tcc.atwebpages.com/index.php?quanly=camon";
$ipnUrl = "http://7tcc.atwebpages.com/index.php?quanly=camon";
$extraData = "";

// Common variables for both payment types
$amount = calculateTotalAmount();
$orderId = time() . "";
$requestId = time() . "";

// MoMo QR Payment
$orderInfoQR = "Thanh toán qua mã QR MoMo";
$requestTypeQR = "captureWallet";
$rawHashQR = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfoQR . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestTypeQR;
$signatureQR = hash_hmac("sha256", $rawHashQR, $secretKey);

$dataQR = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    'storeId' => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfoQR,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestTypeQR,
    'signature' => $signatureQR
);

$resultQR = execPostRequest($endpoint, json_encode($dataQR));
$jsonResultQR = json_decode($resultQR, true);

if (isset($jsonResultQR['payUrl'])) {
    header('Location: ' . $jsonResultQR['payUrl']);
    exit;
} else {
    echo "Error: Unable to retrieve payment URL for QR.";
}

// MoMo ATM Payment
$orderInfoATM = "Thanh toán qua MoMo ATM";
$requestTypeATM = "payWithATM";
$rawHashATM = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfoATM . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestTypeATM;
$signatureATM = hash_hmac("sha256", $rawHashATM, $secretKey);

$dataATM = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    'storeId' => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfoATM,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestTypeATM,
    'signature' => $signatureATM
);

$resultATM = execPostRequest($endpoint, json_encode($dataATM));
$jsonResultATM = json_decode($resultATM, true);

if (isset($jsonResultATM['payUrl'])) {
    echo "<script>window.location.href='" . $jsonResultATM['payUrl'] . "';</script>";
} else {
    echo "Có lỗi xảy ra trong thanh toán qua ATM:";
    echo "<pre>";
    print_r($jsonResultATM);
    echo "</pre>";
}
?>
