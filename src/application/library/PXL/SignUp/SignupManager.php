<?php

/**
 * @author     Ajith E R, <hello@trycatchajith.com>
 * @date       September 20, 2017
 * @brief      All Signup related Operations.                               
 * @return     JSON response.
 */

namespace library\PXL\SignUp;

use \models\User as User;
use \models\User_Profile as User_Profile;

class SignupManager {

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      User SignUp.                               
     * @return     JSON response.
     */
    public static function userSignup($payload) {
        $user['user_mobile'] = $payload['user_mobile'];
        $user['is_active'] = 1;
        $userModel = new User();
        $user_id = $userModel->addUser($user);

        $userProfile['user_id'] = $user_id;
        $userProfile['user_sex'] = $payload['user_sex'];
        $userProfile['user_dob'] = $payload['user_dob'];
        $userProfile['user_location'] = $payload['user_location'];
        $userProfile['user_address'] = $payload['user_address'];
        $userProfile['user_sex_interested'] = $payload['user_sex_interested'];
        $userProfile['user_sex_min'] = $payload['user_sex_min'];
        $userProfile['user_sex_max'] = $payload['user_sex_max'];

        $userProfileModel = new User_Profile();
        $userProfileModel->addUserProfile($userProfile);

        $response['success'] = "true";
        $response['message'] = "User Account Created Successfully";
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

}
