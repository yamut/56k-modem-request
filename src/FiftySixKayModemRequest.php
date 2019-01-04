<?php

namespace Dmattern\Http;


use GuzzleHttp\Client;

class FiftySixKayModemRequest
{

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return static::request(
            $arguments[0]['url'],
            $arguments[0]['data'] ?? [],
            $name,
            microtime(true)
        );
    }

    /**
     * @param string $url
     * @param array $data
     * @param string $request_type
     * @param float $startTime
     * @return mixed
     */
    public static function request(string $url, array $data, string $request_type, float $startTime)
    {
        if (strtolower($request_type) === "get") {
            // Append the data to the url
            $options = ['query' => $data];
        } else {
            $options = ['form_params' => $data];
        }
        $client = new Client();
        $response        = $client->{strtolower($request_type)}($url, $options);
        $body            = $response->getBody();
        $size            = mb_strlen($body);
        $sizeInKb        = $size / 1024;
        $minTransferTime = $sizeInKb / 56;
        while (microtime(true) - $startTime < $minTransferTime) {
            usleep(500);
        }
        return $body;
    }
}