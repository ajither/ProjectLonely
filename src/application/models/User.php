<?php

namespace models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

class User extends Eloquent {

    public $timestamps = false;
    protected $table = 'user';
    protected $fillable = [
        'user_mobile',
        'is_active',
    ];

    public function __construct() {
        $this->tableObject = $this->getConnectionResolver()->connection()->table($this->table);
    }

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      Add New User.                               
     * @return     JSON response.
     */
    public function addUser($data) {
        return $this->tableObject->insertGetId($data);
    }

    /**
     * @author     Ajith E R, <hello@trycatchajith.com>
     * @date       September 20, 2017
     * @brief      Fetch User Details.                               
     * @return     JSON response.
     */
    public function fetchUser($userMobile) {
        $result = $this->tableObject->
                        where('user_mobile', $userMobile)->
                        where('is_active', '1')->get();
        if (isset($result[0])) {
            return $result[0];
        } else {
            return null;
        }
    }

}
