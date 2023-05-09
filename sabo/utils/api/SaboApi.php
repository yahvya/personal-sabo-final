<?php

namespace Sabo\Utils\Api;

use Exception;
use ReflectionClass;

/**
 * utilitaire requête d'api curl
 */
abstract class SaboApi{ 
    /**
     * préfixe url api
     */
    protected string $apiUrlPrefix;

    /**
     * résultats de requêtes stockés
     */
    protected array $storedRequestResult;

    /**
     * valeur de la dernière requête exécuté, null si aucune valeur
     */
    private ?string $lastRequestResult;

    /**
     * @param apiUrlPrefix lien préfixant les appels de l'api
     */
    public function __construct(string $apiUrlPrefix){
        $this->apiUrlPrefix = !str_ends_with($apiUrlPrefix,"/") || ! str_ends_with($apiUrlPrefix,"\\") ? $apiUrlPrefix . "/" : $apiUrlPrefix;
        $this->lastRequestResult = null;
        $this->storedRequestResult = [];
    }

    /**
     * @param apiSuffix suffixe à ajouter
     * @return string l'url composé du préfix de l'api et du suffixe 
     */
    protected function apiUrl(string $apiSuffix):string{
        return $this->apiUrlPrefix . $apiSuffix;
    }

    /**
     * fais une requête curl à partir de la configuration donnée
     * met en jour en cas de succès lastRequestResult
     * @param requestUrl lien de requête ($api->apiUrl("lien") )
     * @param headers en-tête de la reqûete
     * @param data données de la requête
     * @param dataConversionType type de conversion de donnée par défault json_encode [JSON_BODY|HTTP_BUILD_QUERY]
     * @param overrideCurlOptions tableau écrasant les options par défaut curl indicé par CURLOPT_...
     * @param storeIn si non null sauvegarde le résultat de la requête avec comme indice la clé donné dans l'accessible "storedRequestResult"
     * @return bool si la requête a réussi
     */
    protected function request(string $requestUrl,array $headers,mixed $data,SaboApiRequest $dataConversionType,array $overrideCurlOptions = [],?string $storeIn = null):bool{
        $curl = curl_init();

        if($curl === false) return false;

        // options par défaut
        $options = [
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true
        ];

        // override des options
        foreach($overrideCurlOptions as $curlOption => $value) $options[$curlOption] = $value;

        $options[CURLOPT_HTTPHEADER] = $headers;
        $options[CURLOPT_URL] = $requestUrl;
        $options[CURLOPT_POSTFIELDS] = $dataConversionType == SaboApiRequest::HTTP_BUILD_QUERY ? http_build_query($data) : json_encode($data);

        if(!curl_setopt_array($curl,$options) ) return false;

        $result = curl_exec($curl);
        
        if($storeIn == null) $this->storedRequestResult[$storeIn] = $result;

        if($options[CURLOPT_RETURNTRANSFER]){
            if($result === false) return false;

            $this->lastRequestResult = $result;

            return true;
        }
        
        return $result;
    }

    /**
     * @return string|array|null les données de la dernière requête
     */
    protected function getLastRequestResult(SaboApiRequest $as):string|array|null{
        if($this->lastRequestResult == null) return null;

        switch($as){
            case SaboApiRequest::RESULT_AS_JSON_ARRAY : 
                $jsonData = json_decode($this->lastRequestResult,true);    
                
                if(gettype($jsonData) != "array") return $jsonData;

            case SaboApiRequest::RESULT_AS_STRING: 
                return $this->lastRequestResult;

            default:
                return null;
        }
    }

    /**
     * crée un objet à partir de la configuration api
     * @param config tableaux indicés par SaboApiConfig->value
     * @return mixed l'objet crée ou null
     */
    public static function createFromConfig(array $config):mixed{
        try{
            $reflection = new ReflectionClass(get_called_class() );

            return $reflection->newInstance(
                $config[SaboApiConfig::URL->value]
            );
        }
        catch(Exception){
            return null;
        }
    } 
}