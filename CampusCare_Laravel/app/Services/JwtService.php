<?php

namespace App\Services;

use App\Models\User;
use RuntimeException;

class JwtService
{
    private string $secret;
    private int $ttlSeconds;

    public function __construct(?string $secret = null, int $ttlSeconds = 3600)
    {
        $rawKey = $secret ?? (string) config('app.key', 'campuscare-jwt-secret');
        if (str_starts_with($rawKey, 'base64:')) {
            $decoded = base64_decode(substr($rawKey, 7), true);
            $rawKey = $decoded !== false ? $decoded : $rawKey;
        }
        $this->secret = $rawKey !== '' ? $rawKey : 'campuscare-jwt-secret';
        $this->ttlSeconds = $ttlSeconds;
    }

    public function generateToken(User $user): string
    {
        $now = time();
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'iat' => $now,
            'exp' => $now + $this->ttlSeconds,
        ];

        $headerEncoded = $this->base64UrlEncode((string) json_encode($header));
        $payloadEncoded = $this->base64UrlEncode((string) json_encode($payload));
        $signature = hash_hmac('sha256', "{$headerEncoded}.{$payloadEncoded}", $this->secret, true);
        $signatureEncoded = $this->base64UrlEncode($signature);

        return "{$headerEncoded}.{$payloadEncoded}.{$signatureEncoded}";
    }

    /**
     * @return array<string, mixed>
     */
    public function verifyToken(string $token): array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            throw new RuntimeException('Token format invalid.');
        }

        [$headerEncoded, $payloadEncoded, $signatureEncoded] = $parts;

        $header = json_decode($this->base64UrlDecode($headerEncoded), true);
        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);

        if (!is_array($header) || !is_array($payload) || ($header['alg'] ?? '') !== 'HS256') {
            throw new RuntimeException('Token header or payload invalid.');
        }

        $expectedSignature = $this->base64UrlEncode(
            hash_hmac('sha256', "{$headerEncoded}.{$payloadEncoded}", $this->secret, true)
        );

        if (!hash_equals($expectedSignature, $signatureEncoded)) {
            throw new RuntimeException('Token signature invalid.');
        }

        if (isset($payload['exp']) && time() >= (int) $payload['exp']) {
            throw new RuntimeException('Token expired.');
        }

        return $payload;
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder > 0) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        $decoded = base64_decode(strtr($data, '-_', '+/'), true);
        if ($decoded === false) {
            throw new RuntimeException('Invalid base64url encoding.');
        }
        return $decoded;
    }
}
