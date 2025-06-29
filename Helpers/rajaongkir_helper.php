<?php

use CodeIgniter\HTTP\CURLRequest;

if (!function_exists('rajaongkir_get_provinces')) {
    function rajaongkir_get_provinces()
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get('https://api.rajaongkir.com/starter/province', [
            'headers' => [
                'key' => getenv('RAJAONGKIR_API_KEY'),
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}

if (!function_exists('rajaongkir_get_cities')) {
    function rajaongkir_get_cities($province_id)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get('https://api.rajaongkir.com/starter/city?province=' . $province_id, [
            'headers' => [
                'key' => getenv('RAJAONGKIR_API_KEY'),
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}

if (!function_exists('rajaongkir_get_cost')) {
    function rajaongkir_get_cost($origin, $destination, $weight, $courier)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->post('https://api.rajaongkir.com/starter/cost', [
            'headers' => [
                'key' => getenv('RAJAONGKIR_API_KEY'),
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
