<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://mail-sender-api1.p.rapidapi.com/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'sendto' => 'EMAIL_HERE',
            'name' => 'GPT USER',
            'replyTo' => $email,
            'ishtml' => 'false',
            'title' => 'Newsletter Subscription',
            'body' => $email . 'Subscribed to our newsletter!'
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: mail-sender-api1.p.rapidapi.com",
            "x-rapidapi-key: REMEMBER TO REGISTER FOR SERVICE" 
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
} else {
    echo "Invalid request method.";
}
?>
