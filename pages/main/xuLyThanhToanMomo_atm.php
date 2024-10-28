session_start();
$totalAmount = 0;

// Kiểm tra nếu giỏ hàng tồn tại trong session
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        // Tính tổng tiền bằng cách nhân giá sản phẩm với số lượng và cộng dồn
        $totalAmount += $item['price'] * $item['quantity'];
    }
}

// Chuyển tổng tiền thành chuỗi để gửi vào yêu cầu thanh toán
$amount = strval($totalAmount);

// Kiểm tra tổng tiền có hợp lệ với yêu cầu của MoMo không
if ($totalAmount < 10000) {
    echo "Tổng số tiền phải lớn hơn hoặc bằng 10,000 VND để thực hiện thanh toán qua MoMo.";
    exit;
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua MoMo ATM";
$orderId = time() . "";
$redirectUrl = "http://7tcc.atwebpages.com/index.php?quanly=camon";
$ipnUrl = "http://7tcc.atwebpages.com/index.php?quanly=camon";
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
$jsonResult = json_decode($result, true);

if (isset($jsonResult['payUrl'])) {
    echo "<script>window.location.href='" . $jsonResult['payUrl'] . "';</script>";
} else {
    echo "Có lỗi xảy ra: ";
    echo "<pre>";
    print_r($jsonResult);
    echo "</pre>";
}
