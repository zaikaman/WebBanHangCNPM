<?php
// brevo_config.php

// Fetch the API key from an environment variable
$apiKey = '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';

// Check if the API key is set
if (!$apiKey) {
    die("Error: API key is not set. Please configure the environment variable.");
}

// Base URL for Brevo API
$apiUrl = 'https://api.brevo.com/v3/smtp/email';

// You can also add other configurations if needed
return [
    'apiKey' => $apiKey,
    'apiUrl' => $apiUrl,
];
