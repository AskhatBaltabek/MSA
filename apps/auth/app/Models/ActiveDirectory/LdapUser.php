<?php

namespace App\Models\ActiveDirectory;

use \Adldap\Laravel\Facades\Adldap;
use Adldap\Models\ModelNotFoundException;

class LdapUser
{
    protected $user = NULL;

    public function __construct($username = NULL)
    {
        if ($username) {
            try {
                $this->user = Adldap::search()->findByOrFail('sAMAccountName', $username);
            } catch (ModelNotFoundException $e) {
                $this->user = NULL;
            }
        }
    }

    public function getUser()
    {
        return $this->user;
    }

}
