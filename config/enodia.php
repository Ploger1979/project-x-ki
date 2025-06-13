<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Customer Manager
    |--------------------------------------------------------------------------
    |
    | Should the customers get managed in the app or are they related to
    | external sources like SAP or do-it
    |
    */
    'customer-manager' => env('MANAGECUSTOMERS', true),

    /*
     |--------------------------------------------------------------------------
     | What system manages the customers
     |--------------------------------------------------------------------------
     |
     | Currently only DoIt is supported
     |
     */
    'customer-system' => env('CUSTOMERSOURCE', ''),

    /*
     |--------------------------------------------------------------------------
     | The API Url to get an access token
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'customer-token-url' => env('CUSTOMERSSOURCE_TOKEN_URL', ''),

    /*
     |--------------------------------------------------------------------------
     | The API Url to access customers endpoint
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'customer-source-url' => env('CUSTOMERSSOURCE_CUSTOMER_URL', ''),


    /*
     |--------------------------------------------------------------------------
     | The API Url to access contacts endpoint
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'contact-source-url' => env('CUSTOMERSSOURCE_CONTACT_URL', ''),

    /*
        |--------------------------------------------------------------------------
        | The API Url to access tickets endpoint
        |--------------------------------------------------------------------------
        |
        |
        |
        */

    'ticket-source-url' => env('CUSTOMERSSOURCE_TICKET_URL', ''),

    /*
     |--------------------------------------------------------------------------
     | The API user to access customers endpoint
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'customer-source-user' => env('CUSTOMERSOURCE_USER', ''),

    /*
     |--------------------------------------------------------------------------
     | The API password to access customers endpoint
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'customer-source-password' => env('CUSTOMERSOURCE_PASSWORD', ''),

    /*
     |--------------------------------------------------------------------------
     | The API user to access own api
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'self-api-user' => env('SELF_API_USER', ''),

    /*
     |--------------------------------------------------------------------------
     | The API password to access own api
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'self-api-secret' => env('SELF_API_SECRET', ''),

    /*
     |--------------------------------------------------------------------------
     | The number of contact slots used by customer. It is prefixed with VITE_
     | to make it accessible by vue templates
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'contact-slots' => env('VITE_CONTACTSLOTS', '3'),



    /*
    |--------------------------------------------------------------------------
    | find the database structure of doit
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'database-structure-url' => env('CUSTOMERSSOURCE_DATABASE_STRUCTURE_URL', ''),



    /*
     |--------------------------------------------------------------------------
     | The Deepl API key.
     |--------------------------------------------------------------------------
     |
     |
     |
     */
    'deepl-key' => env('DEEPLKEY', ''),

];
