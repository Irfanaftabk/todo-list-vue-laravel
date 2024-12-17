<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    /*
     * You can enable CORS for 1 or multiple paths.
     * Example: ['api/*']
     */
    'paths' => ['api/*'],

    /*
     * Matches the request method. `['*']` allows all methods.
     */
    'allowed_methods' => ['*'],

    /*
     * Matches the request origin. `['*']` allows all origins.
     * Set this based on your frontend URL in production.
     */
    'allowed_origins' => ['*'],

    /*
     * Matches the request headers. `['*']` allows all headers.
     */
    'allowed_headers' => ['*'],

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'supports_credentials' => false,

    /*
     * Sets the Access-Control-Max-Age header.
     */
    'max_age' => 0,

    /*
     * Sets the Access-Control-Expose-Headers header.
     */
    'exposed_headers' => [],

    /*
     * Sets the Access-Control-Allow-Origin header.
     */
    'allowed_origins_patterns' => [],
];