<?php

/**
 * @author     Ajith E R, <ajithurulikunnam@gmail.com>
 * @date       September 11, 2017
 * @brief      This class controlls all api calls.
 * @details    API calls are directed towards a method with the same name as the
 *             API
 */
use \library\PXL\Otp\OtpManager as OtpManager;
use library\PXL\Common\Validations as Validations;
use \library\PXL\SignUp\SignupManager as SignupManager;

class ApiController {

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      Signup Operations.                               
     * @return     JSON response.
     */
    public function signUp($request) {
        $payload = $request->getParsedBody();
        $expectedFields = ["user_mobile", "user_sex", "user_dob", "user_location", "user_address", "user_sex_interested", "user_sex_min", "user_sex_max"];
        $result = Validations::validateMandatoryFields($expectedFields, $payload);
        if (!$result['status']) {
            return json_encode($result['body'], JSON_NUMERIC_CHECK);
        }
        return SignupManager::userSignup($payload);
    }

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      OTP Verification.
     * @payload    {"mobile_number" : "919605258149","type" : "login"}
     * @response   {"success":"true","otp":409255}                               
     * @return     JSON response.
     */
    public function sendOtp($request) {
        $payload = $request->getParsedBody();
        $expectedFields = ["mobile_number", "type"];
        $result = Validations::validateMandatoryFields($expectedFields, $payload);
        if (!$result['status']) {
            return json_encode($result['body'], JSON_NUMERIC_CHECK);
        }
        return OtpManager::sendOtpToClient($payload);
    }

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 15, 2017
     * @brief      Error.                               
     * @return     JSON response.
     */
    public function error($code = NULL, $data = NULL, $custom = NULL) {
        $message = [
            400 => "Bad Request - Request does not have a valid format, all required parameters, etc.",
            401 => "Unauthorized Access - No currently valid authorization has been made.",
            403 => "Forbidden Access - Access to this service or resource is forbidden with the given authorization.",
            404 => "Not Found - Service or resource was not found",
            500 => "System Error - Specific reason is included in the error message"
        ];
        $response['success'] = 'false';
        $error = array();
        if ($code != null) {
            $error['code'] = $code;
        }
        $response['message'] = "";
        if (array_key_exists($code, $message)) {
            $response['message'] = $message[$code];
        }
        if ($data != null) {
            if (strlen($response['message']) == 0) {
                $response['message'] = $data->getMessage();
                $error['trace'] = $data->getTrace();
            }
        }
        $response['error'] = $error;
        $response['error']['debug_backtrace'] = debug_backtrace();
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

}
