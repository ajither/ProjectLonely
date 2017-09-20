<?php

namespace library\PXL\Token;

class TokenManager {

    public static function validateTokens($request) {
        if ($request->getAttribute('apiname') == 'login' ||
                $request->getAttribute('apiname') == 'sendotp' ||
                $request->getAttribute('apiname') == 'signup') {
            if (!array_key_exists('HTTP_PXL_API_KEY', $request->getHeaders())) {
                return false;
            } else {
                $headers = $request->getHeaders();
                return self::validateApiKey($headers['HTTP_PXL_API_KEY'][0]);
            }
        } else {
            $headers = $request->getHeaders();
            if (!array_key_exists('HTTP_PXL_API_KEY', $request->getHeaders())) {
                return false;
            }
            if (!array_key_exists('HTTP_PXL_SESSION_TOKEN', $request->getHeaders())) {
                return false;
            }
            $apiKeyValid = self::validateApiKey($headers['HTTP_PXL_API_KEY'][0]);
            $sessionTokenValid = self::
                    validateSessionToken($headers['HTTP_PXL_SESSION_TOKEN'][0]);
            if ($apiKeyValid && $sessionTokenValid) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function validateApiKey($apiKey) {
        if ($apiKey == getenv('API.KEY.ANDROID')) {
            $_SESSION['access_log_string'] .= '--[ANDROID]';
            $_SESSION['accessing_platform'] = 'ANDROID';
            return true;
        } else {
            return false;
        }
    }

}
