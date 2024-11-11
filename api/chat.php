<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$API_KEY = 'AIzaSyCsrBVCvzZcw99BwCTF3mkEAuCGyfewmCc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'] ?? '';

    if (empty($message)) {
        http_response_code(400);
        echo json_encode(['error' => 'Message is required']);
        exit;
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $API_KEY;
    
    $initialPrompt = "You are an AI assistant for 7TCC, a sportswear e-commerce website created by a team of 8 students from Sai Gon University. Your role is to help customers with product information, sizing guidance, order status, and general inquiries about our sportswear collection. You should be friendly, professional, and knowledgeable about sports apparel. Please provide accurate information and assistance while maintaining a helpful attitude. If you're unsure about specific details, please acknowledge that and offer to connect the customer with a human representative. Trả lời bằng Tiếng Việt.";
    
    $postData = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $initialPrompt . "\n\nCustomer: " . $message]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo $response;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to get response from Gemini API']);
    }
}