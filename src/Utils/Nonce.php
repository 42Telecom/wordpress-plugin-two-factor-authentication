<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils;

/**
 * Manage Wordpress Nonce for the login
 * See https://codex.wordpress.org/WordPress_Nonces
 */
class Nonce
{
    /**
     * The user meta nonce key.
     *
     * @type string
     */
    const USER_META_NONCE_KEY    = '_two_factor_nonce';

    private $key;
    private $expiration;

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function setExpiration()
    {
        $this->expiration = time() + HOUR_IN_SECONDS;

        return $this;
    }

    public function toArray()
    {
        $loginNonce                 = array();
        $loginNonce['key']          = $this->getKey();
        $loginNonce['expiration']   = $this->getExpiration();

        return $loginNonce;
    }

    /**
     * Create the login nonce.
     *
     * @param  int     $userId User ID.
     * @return string  return the login Nonce or false if can't be created.
     */
    public function create($userId)
    {
        // Preparing the parameters
        $loginNonce = $this
            ->setKey(wp_hash($userId . mt_rand() . microtime(), 'nonce'))
            ->setExpiration()
            ->toArray();

        // Update user Nonce value on the database
        if (!update_user_meta($userId, self::USER_META_NONCE_KEY, $loginNonce)) {
            return false;
        }

        return $loginNonce;
    }

    /**
     * Delete the login nonce.
     *
     * @param int $user_id User ID.
     * @return boolean, False for failure. True for success.
     */
    public static function delete($userId)
    {
        return delete_user_meta($userId, self::USER_META_NONCE_KEY);
    }

    /**
     * Verify the login nonce.
     *
     * @param int    $user_id User ID.
     * @param string $nonce Login nonce.
     */
    public static function verify($userId, $nonce)
    {
        $loginNonce = get_user_meta($userId, self::USER_META_NONCE_KEY, true);
        if (!$loginNonce) {
            return false;
        }

        if ($nonce !== $loginNonce['key'] || time() > $loginNonce['expiration']) {
            self::delete($userId);
            return false;
        }

        return true;
    }
}
