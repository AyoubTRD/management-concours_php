<?php

class PasswordManager
{
    function hashPassword($password)
    {
        return hash("sha256", $password);
    }

    function verifyPasswordAgainstHash($password, $hash)
    {
        return $this->hashPassword($password) == $hash;
    }
}
