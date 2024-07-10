<?php
// Include the configuration file
require_once 'config.php';

// Set the content type of the response to JSON
header('Content-Type: application/json');

// Allow cross-origin requests from any domain
header('Access-Control-Allow-Origin: *');

// Allow the POST method for cross-origin requests
header('Access-Control-Allow-Methods: POST');

// Specify allowed headers for cross-origin requests, including Content-Type and Authorization
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON input and store it in a variable
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://". RAPIDAPI_HOST ."/v1/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'model' => MODEL,
            'max_tokens' => MAX_TOKENS,
            'temperature' => TEMPERATURE
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: " . RAPIDAPI_HOST,
            "x-rapidapi-key: " . RAPIDAPI_KEY
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo json_encode(['error' => "cURL Error #:" . $err]);
    } else {

        $response_data = json_decode($response, true);
        $message_content = $response_data['choices'][0]['message']['content'];
        echo json_encode(['message' => $message_content]);
    }
} else {

    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
