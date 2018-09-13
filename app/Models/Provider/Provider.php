<?php

namespace App\Models\Provider;

use App\Models\Provider\ProviderInterface;
use Exception;

class Provider implements ProviderInterface {

    private $httpSuccessCodes = [200,202];
    private $curlOptions = [
        CURLOPT_URL => 'https://demo.appmanager.pl/api/v1/ads',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true
    ];

    public function __construct(Array $additionalCurlOptions = [])
    {   
        if(isArrayNotEmpty($additionalCurlOptions)){
            $addedCurlOptions = array_replace($this->getCurlOptions(), $additionalCurlOptions);
            $this->setCurlOptions($addedCurlOptions);
        }
    }

    private function getHttpSuccessCodes(): Array
    {
        return $this->httpSuccessCodes;
    }

    private function setCurlOptions(Array $newOptions): void
    {
        $this->curlOptions = $newOptions;
    }

    private function getCurlOptions(): Array
    {
        return $this->curlOptions;
    }

    private function isFaultRequest(int $curlResponseCode)
    {   
        if(in_array($curlResponseCode,$this->getHttpSuccessCodes()))
            return false;
        else
            return true;
    }

    private function requestResponseCurl(): Array
    {   
        //$jsonResponseData = file_get_contents($url);
        try
        {
            $curl = curl_init();

            curl_setopt_array($curl, $this->getCurlOptions());

            $curlResultRequest = curl_exec($curl);

            if (!$curlResultRequest) {
                throw new Exception('Error: ' . curl_error($curl));
            }

            $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $responseData = json_decode($curlResultRequest,TRUE);
            
            if ($this->isFaultRequest($responseCode)) {
                throw new Exception("Waring: Response code: {$responseCode}. Info: {$responseData['data']['name']}. Message: {$responseData['data']['message']}");
            }
            
            //$responseData['connection']['time'] = round(curl_getinfo($curl, CURLINFO_CONNECT_TIME),2);

            curl_close($curl);
        }
        catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
        
            return $responseData['data'];
    }

    public function getAllJobsOffer(): Array
    {   
        return $this->requestResponseCurl();
    }
}
