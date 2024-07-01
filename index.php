<?php
//require ('index.html');
// Get visitor name from the query parameter
$visitor_name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest';

// Get client IP address
$client_ip = $_SERVER['REMOTE_ADDR'];

// Use a geolocation API to get the location data
/*$geo_api_key = '95b3c3fb1d298615959a0075806d9f7e'; // Replace with your geolocation API key
$geo_url = "http://api.ipstack.com/$client_ip?access_key=$geo_api_key";
$location_data = @file_get_contents($geo_url);
$location_data = $location_data ? json_decode($location_data, true) : null;

// Default location if geolocation fails
$location = 'Unknown location';
if ($location_data && isset($location_data['city']) && $location_data['city']) {
    $location = $location_data['city'];
}*/

// Use a weather API to get the current temperature
$weather_api_key = '88b5638bb9324ec081c34044240107'; // Replace with your OpenWeatherMap API key
$weather_url = "http://api.weatherapi.com/v1/current.json?key=$weather_api_key&q=$client_ip";
$weather_data = @file_get_contents($weather_url);
$weather_data = $weather_data ? json_decode($weather_data, true) : null;

// Default temperature if weather API fails
$city = 'Unknown city';
$temperature = 'N/A';

if ($weather_data && isset($weather_data['location']['name']) && isset($weather_data['current']['temp_c'])) {
    $city = $weather_data['location']['name'];
    $temperature = $weather_data['current']['temp_c'];
}
// Create response data
$response = [
    "client_ip" => $client_ip,
    "location" => $city,
    "greeting" => "Hello $visitor_name! The temperature is $temperature degrees Celsius in $city"
];

// Output the JSON response
echo json_encode($response);
?>
