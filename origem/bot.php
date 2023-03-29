<?php
// Informações do bot
$botToken = 'YOUR_BOT_TOKEN';
$botName = '@YOUR_BOTNAME';

// Mensagem recebida do usuário
$update = json_decode(file_get_contents('php://input'), TRUE);
$message = $update['message']['text'];
$chatId = $update['message']['chat']['id'];

$start = file_get_contents("*Olá usuário, fico feliz por você estar me utilizando. Eu sou apenas um pequeno bot OpenAI, feito para ajudar a sanar suas dúvidas.*

🧑‍💻 Meu desenvolvedor: @xSpeed#5812
💻 Meu projeto: *https://github.com/xSpeedDev/BOT-OPENAI-TELEGRAM*");

// Resposta do bot
if($message) {
    $openaiUrl = 'https://api.openai.com/v1/engines/davinci-codex/completions';
    $data = array(
        'prompt' => $message,
        'max_tokens' => 50,
        'temperature' => 0.7,
        'stop' => '\n',
    );
    $json_data = json_encode($data);

    $ch = curl_init($openaiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer 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'
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    $answer = json_decode($response)->choices[0]->text;

    $telegramUrl = 'https://api.telegram.org/bot'.$botToken.'/sendMessage?chat_id='.$chatId.'&text='.urlencode($answer);
    file_get_contents($telegramUrl);
}

