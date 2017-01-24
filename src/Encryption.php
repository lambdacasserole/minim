<?php

namespace Minim;

use Defuse\Crypto\Crypto;

/**
 * Provides useful encryption functions.
 *
 * @package Minim
 * @author Saul Johnson
 * @since 13/09/2016
 */
class Encryption
{
    /**
     * Hashes a password.
     *
     * @param string $password  the password to hash
     * @return string           the hashed password
     */
    public static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifies that a password matches a hash.
     *
     * @param string $password  the password to verify
     * @param string $hash      the hash to check against
     * @return bool             true if the password matches the hash, otherwise false
     */
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Encrypts a string.
     *
     * @param string $data      the string to encrypt
     * @param string $password  the password to use to encrypt it
     * @return string           the encrypted string in raw binary
     */
    public static function encrypt($data, $password)
    {
        return Crypto::encryptWithPassword($data, $password, true);
    }

    /**
     * Decrypts a previously encrypted string.
     *
     * @param string $data      the string to decrypt
     * @param string $password  the password to use to decrypt it
     * @return string           the decrypted string
     */
    public static function decrypt($data, $password)
    {
        return Crypto::decryptWithPassword($data, $password, true);
    }
}