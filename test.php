<?php
require __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);

$dotenv->load();

$command ="WN-Lagos";

$location = explode("-",$command);
  try {
    $data = [
      'q' => $location[1],
      'appid' => getenv("OPEN_WEATHER_API_KEY"),
      'units' => 'metric'
    ];
        $url = getenv("OPEN_WEATHER_API_URL");
        $query_url = sprintf("%s?%s", $url, http_build_query($data));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query_url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = curl_exec($curl);
        header('Content-type: application/json');
        $weather_data = json_decode($result, true);
        $response = [
          'weather' => $weather_data['weather'][0]['description'],
          'temp' => $weather_data['main']['temp']
        ];
        print_r($response);
        curl_close($curl);
  } catch (exception $e) {
    print_r($e);
  }