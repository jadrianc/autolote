<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if (!function_exists('getHashedPassword')) {
    function getHashedPassword($plainPassword)
    {
        $options = [
            'cost' => 12,
        ];

        return password_hash($plainPassword, PASSWORD_BCRYPT, $options);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if (!function_exists('verifyHashedPassword')) {
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        $password = (string) $plainPassword;
        $hash = (string) $hashedPassword;
        return password_verify($password, $hash) ? true : false;
    }
}
