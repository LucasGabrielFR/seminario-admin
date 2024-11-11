<?php
// URL para a requisição GET
$url = "https://seminario.acutisroad.com.br/telegram/send-scale-response-morning";

// Inicializa a sessão cURL
$ch = curl_init();

// Define a URL da requisição
curl_setopt($ch, CURLOPT_URL, $url);

// Retorna o resultado em vez de imprimi-lo
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição
$response = curl_exec($ch);

// Verifica se houve algum erro
if(curl_errno($ch)) {
    echo 'Erro na requisição: ' . curl_error($ch);
} else {
    // Exibe a resposta
    echo 'Resposta da requisição: ' . $response;
}

// Fecha a sessão cURL
curl_close($ch);
?>
