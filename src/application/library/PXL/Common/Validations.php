<?php

/**
 * @author     Ajith E R, <hello@trycatchajith.com>
 * @date       September 20, 2017
 * @brief      This class is used for validations
 */

namespace library\PXL\Common;

class Validations {

    public static function validateMandatoryFields($expectedFields, $payLoad) {
        foreach ($expectedFields as $key) {
            if (($payLoad == null) || !array_key_exists($key, $payLoad)) {
                $response['status'] = false;
                $error['success'] = "false";
                $error['code'] = 501;
                $error['reason'] = 'Required field \'' . $key . '\' missing from payload';
                $response['body'] = $error;
                return $response;
            }
        }
        $response['status'] = true;
        return $response;
    }

}
