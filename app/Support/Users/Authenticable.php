<?php

namespace App\Support\Users;

use MongoDB\BSON\UTCDateTime;

trait Authenticable
{
    /**
     * Creates a login attempt.
     *
     * @param  string $email
     * @param  string $password
     *
     * @return null|\App\User
     */
    public static function attempt(string $email, string $password)
    {
        $user = static::select('password')->where('email', $email)->first();

        if (!$user) {

            return null;
        }

        if (app('hash')->check($password, $user->password) !== true) {

            return $user->registerFailedAttempt($password);
        }

        return $user->registerSuccessfulAttempt();
    }

    /**
     * Registers a failed login attempt.
     *
     * @param  string $password
     *
     * @return void
     */
    public function registerFailedAttempt(string $password)
    {
        $this->push('attempts', [
            'ip'         => ip(),
            'browser'    => app('request')->header('user-agent'),
            'password'   => $password,
            'created_at' => new UTCDateTime,
        ]);
    }

    /**
     * Registers a successful login attempt.
     *
     * @return \App\User
     */
    public function registerSuccessfulAttempt()
    {
        $token = str_random(128);

        $this->push('logins', [
            'ip'         => ip(),
            'browser'    => app('request')->header('user-agent'),
            'token'      => $token,
            'created_at' => new UTCDateTime,
        ]);

        $this->auth_token = $token;
        $this->save();

        return $this;
    }

    /**
     * Authenticates an user with a token.
     *
     * @param  string|null $token
     *
     * @return null|\App\User
     */
    public static function auth(string $token = null)
    {
        if (!$token) {
            return;
        }

        return static::where('auth_token', $token)->project([
            'logins'   => 0,
            'attempts' => 0,
        ])->first();
    }

    /**
     * Removes active auth token from the user.
     *
     * @return void
     */
    public function logout()
    {
        $this->unset('auth_token');
    }
}