<?php
// brevo_config.php

// Fetch the API key parts
$apiKey1 = 'xkeysib';
$apiKey2 = 'ab004c6e42d57aff3d285ffb5c9775f8d6bb2070b28cd22bfd6efe634dea1e27';
$apiKey3 = 'E5DJhCPyUnxH69tM';

// Combine the parts to form the full API key
$apiKey = $apiKey1 . '-' . $apiKey2 . '-' . $apiKey3;

// Base URL for Brevo API
$apiUrl = 'https://api.brevo.com/v3/smtp/email';

// Return the configuration array
return [
    'apiKey' => $apiKey,
    'apiUrl' => $apiUrl,
];
