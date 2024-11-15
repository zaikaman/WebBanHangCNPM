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
    // Execute post
    $result = curl_exec($ch);
    // Close connection
    curl_close($ch);
    return $result;
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua MoMo ATM";
$amount = calculateTotalAmount();
$orderId = time() . "";
$redirectUrl = "https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php?quanly=camon";
$ipnUrl = "https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php?quanly=camon";
$extraData = "";

$requestId = time() . "";
$requestType = "payWithATM";
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
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

$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);  // decode JSON as associative array

if (isset($jsonResult['payUrl'])) {
    echo "<script>window.location.href='" . $jsonResult['payUrl'] . "';</script>";
} else {
    // Display error or response from the API
    echo "Có lỗi xảy ra: ";
    echo "<pre>";
    print_r($jsonResult);  // Show entire response for debugging
    echo "</pre>";
}
?>
