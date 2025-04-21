<?php 
// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the raw POST data
$rawData = file_get_contents('php://input');

// Get headers
$headers = getallheaders();
$headerString = '';
foreach ($headers as $key => $value) {
    $headerString .= "$key: $value\n";
}

// Log to console
$timestamp = date('Y-m-d H:i:s');
error_log("=== REQUEST AT $timestamp ===");
error_log("HEADERS:\n$headerString");
error_log("BODY:\n$rawData");

// Parse the data (assuming JSON)
$data = json_decode($rawData, true);

// Prepare response
$response = [
    'status' => 'success',
    'message' => 'Data received and logged successfully',
    'timestamp' => $timestamp
];

// Set response headers
header('Content-Type: application/json');

// Send response
echo json_encode($response);

