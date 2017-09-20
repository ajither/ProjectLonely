<?php

namespace library\PXL\Otp;

use \library\PXL\Common\Constants as Constants;
use sendotp\sendotp as sendotp;

class OtpManager {

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      Send Otp To Users.                               
     * @return     JSON response.
     */
    public static function sendOtpToClient($payload) {
        $otpNumber = self::generateOtp();
        if ($payload['type'] == 'verify-number') {
            $otp = new sendotp(getenv('OTP.API.KEY'), Constants::$MESSAGE_OTP_VERIFY);
            $result = $otp->send($payload['mobile_number'], Constants::$MESSAGE_TITLE_NAME, $otpNumber);
        } elseif ($payload['type'] == 'login') {
            $otp = new sendotp(getenv('OTP.API.KEY'), Constants::$MESSAGE_OTP_LOGIN);
            $result = $otp->send($payload['mobile_number'], Constants::$MESSAGE_TITLE_NAME, $otpNumber);
        }

        if (isset($result['type']) && $result['type'] == 'success') {
            $response['success'] = "true";
            $response['otp'] = $otpNumber;
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else {
            $response['success'] = "false";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      6 Digit Opt Generation.                               
     * @return     JSON response.
     */
    public static function generateOtp($digit = 6) {
        $i = 0;
        $pin = "";
        while ($i < $digit) {
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }

}
