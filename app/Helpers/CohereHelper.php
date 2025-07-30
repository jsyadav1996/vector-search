<?php

// Global helper function to get embeddings from Cohere API
// It takes a string and returns an array of embeddings
function generateEmbedding(string $text)
{
    $url = 'https://api.cohere.ai/v1/embed';
    $apiKey = config('services.cohere.key');
    $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'Cohere-Version: 2022-12-06'
    ];

    $data = [
        'texts' => [$text],
        'model' => 'embed-english-v3.0',
        'input_type' => 'search_document'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return null;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    return $result['embeddings'][0] ?? null;
}

// Global helper function to calculate cosine similarity between two vectors
function cosineSimilarity(array $vec1, array $vec2): float
{
    $dotProduct = array_sum(array_map(fn($a, $b) => $a * $b, $vec1, $vec2));
    $magnitude1 = sqrt(array_sum(array_map(fn($a) => $a ** 2, $vec1)));
    $magnitude2 = sqrt(array_sum(array_map(fn($b) => $b ** 2, $vec2)));

    return $magnitude1 && $magnitude2 ? $dotProduct / ($magnitude1 * $magnitude2) : 0.0;
}
