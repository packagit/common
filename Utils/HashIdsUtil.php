<?php

namespace Package\Component\Common\Utils;

use Hashids\Hashids;

class HashIdsUtil
{
    /**
     * @param string $salt
     *
     * @return mixed
     */
    private static function getSalt(string $salt)
    {
        if ($salt) {
            return $salt;
        }
        return env('HASHIDS_SALT', 'wB29S6mKC3');
    }

    /**
     * @param        $hash
     * @param string $salt
     *
     * @return array
     */
    public static function decode($hash, $salt = '')
    {
        $hashids = new Hashids(self::getSalt($salt));
        return $hashids->decode($hash);
    }

    /**
     * @param array  $numbers
     * @param string $salt
     *
     * @return string
     */
    public static function encode($numbers, $salt = '')
    {
        $hashids = new Hashids(self::getSalt($salt));
        return $hashids->encode($numbers);
    }
}
