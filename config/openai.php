<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key, Organization, and Project ID
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key, Organization, and Project ID.
    | This will be used to authenticate with the OpenAI API. You can find your
    | API key, organization, and project information on your OpenAI dashboard.
    */

    'api_key' => env('OPENAI_API_KEY'), // Your OpenAI API Key
    'organization' => env('OPENAI_ORGANIZATION_ID'),  // Your OpenAI organization ID
    'project_id' => env('OPENAI_PROJECT_ID'),  // Your OpenAI project ID
    'assistant_id' => env('ASSISTANT_ID'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Model
    |--------------------------------------------------------------------------
    |
    | The model you wish to use with OpenAI, such as GPT-4 or GPT-3.5. This
    | allows you to change the model without changing your code.
    */

    'model' => env('ASSISTANT_MODEL', 'gpt-4o-2024-05-13'),  // Default model (e.g., GPT-4)

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout for API requests. You can adjust this if you expect longer
    | running requests or to prevent timeouts during long operations.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),  // Default timeout 30 seconds
];