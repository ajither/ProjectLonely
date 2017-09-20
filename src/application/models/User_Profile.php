<?php

namespace models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

class User_Profile extends Eloquent {

    public $timestamps = false;
    protected $table = 'user_profile';
    protected $fillable = [
        "user_sex",
        "user_dob",
        "user_location",
        "user_address",
        "user_sex_interested",
        "user_sex_min",
        "user_sex_max"
    ];

    public function __construct() {
        $this->tableObject = $this->getConnectionResolver()->connection()->table($this->table);
    }

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 15, 2017
     * @brief      Add User Profile.                               
     * @return     JSON response.
     */
    public function addUserProfile($data) {
        return $this->tableObject->insertGetId($data);
    }

}
