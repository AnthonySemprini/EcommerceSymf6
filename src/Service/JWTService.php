<?php

namespace App\Service;

use DateTimeImmutable;

class JWTService 
{
    // On genere le token

    public function generate(array $header, array $paylod, string $secret, int $validity = 10800): string
    {
        if($validity <= 0){
            return "";
        }

        $now = new DateTimeImmutable();
        $exp = $now->getTimestamp() + $validity;

        $payload['iat'] = $now->getTimestamp();
        $payload['exp'] = $exp;

        //on encode en base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // on nettoie les valeurs encodees (retrait des + , / et =)
        $base64Header = str_replace(['+','/','='],['-','_','']
        ,$base64Header);
        $base64Payload = str_replace(['+','/','='],['-','_','']
        ,$base64Payload);

        // on genere la signature
        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256',$base64Header.'.'.$base64Payload, $secret, true);
        
        $base64Signature = base64_encode($signature);

        $base64Signature = str_replace(['+','/','='],['-','_','']
        ,$base64Signature);

        // on crée le token
        $Jwt = $base64Header.'.'.$base64Payload.'.'.$base64Signature;

        return $Jwt;
    }
}