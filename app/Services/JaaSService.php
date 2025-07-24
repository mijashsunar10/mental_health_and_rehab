<?php

namespace App\Services;

use Firebase\JWT\JWT;

class JaaSService
{
    public function generateToken(string $roomName, string $userName, string $email): string
    {
        $appId = env('JAAS_APP_ID');
        $tenantId = env('JAAS_TENANT_ID');
        $kid = env('JAAS_KID');
        $privateKey = env('JAAS_PRIVATE_KEY');

            $payload = [
            'aud' => 'jitsi',
            'iss' => $appId,
            'sub' => $tenantId,
            'room' => $roomName,
            'exp' => time() + 3600,
            'context' => [
                'user' => [
                    'name' => $userName,
                    'email' => $email,
                    'avatar' => 'https://example.com/avatar.png',
                    'moderator' => 'true', // ✅ must be string
                ],
            ],
        ];


        $headers = [
            'kid' => $kid,
        ];

        return JWT::encode($payload, $privateKey, 'RS256', null, $headers);
    }
}