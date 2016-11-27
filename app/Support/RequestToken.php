<?php

namespace App\Support;

class RequestToken
{
    /** @var string */
    protected $token;

    /**
     * Generates a new request token.
     *
     * @param  int    $ttl
     *
     * @return string
     */
    public function generate(int $ttl = null):string
    {
        $type       = 'REQUEST_TOKEN';
        $ip         = ip();
        $ttl        = is_null($ttl) ? 3600 * random_int(10, 24) : $ttl;
        $ttl        = $ttl < 0 ? 0 : $ttl;
        $expires_at = time() + $ttl;

        return encrypt("{$type}|{$ip}|{$expires_at}");
    }

    /**
     * Sets a new request token.
     *
     * @param  string $token
     *
     * @return string
     */
    public function set(string $token):string
    {
        return $this->token = $token;
    }

    /**
     * Updates the request token.
     *
     * @return string
     */
    public function update():string
    {
        return $this->set($this->generate());
    }

    /**
     * Returns current request token.
     *
     * @return string
     */
    public function get():string
    {
        return $this->token ?: $this->update();
    }

    /**
     * Validates a request token.
     *
     * @param  string|null $token
     *
     * @return bool
     */
    public function validate(string $token = null):bool
    {
        try {
            $token = decrypt($token);
        } catch (\Exception $ex) {
            return false;
        }

        if (strpos($token, 'REQUEST_TOKEN') !== 0) {
            return false;
        }

        $token      = explode('|', $token);
        $ip         = $token[1] ?? '';
        $expires_at = (int)$token[2] ?? 0;

        if (ip() !== $ip) {
            return false;
        }

        if ($expires_at < time()) {
            return false;
        }

        return true;
    }
}