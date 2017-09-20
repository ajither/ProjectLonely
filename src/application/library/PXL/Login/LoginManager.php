<?php

/**
 * @author     Ajith E R, <hello@trycatchajith.com>
 * @date       September 20, 2017
 * @brief      All Login related Operations.                               
 * @return     JSON response.
 */

namespace library\PXL\Login;

use models\User as User;
use \library\PXL\Otp\OtpManager as OtpManager;

class LoginManager {

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      User Login.                               
     * @return     JSON response.
     */
    public static function userLogin($payload) {
        $userModel = new User();
        $user = $userModel->fetchUser($payload['user_mobile']);
        if (isset($user)) {
            $otp['mobile_number'] = $payload['user_mobile'];
            $otp['type'] = 'login';
            return OtpManager::sendOtpToClient($otp);
        }
        $response['success'] = "false";
        $response['message'] = "User Account Not Found";
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

}
