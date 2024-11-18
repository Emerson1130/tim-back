<?php

return [
    # The Keycloak Server realm public key (string).
    'realm_public_key' => env('JWT_REALM_PUBLIC_KEY', null),

    # If you do not have an users table you must disable this.
    'load_user_from_database' => env('JWT_LOAD_USER_FROM_DATABASE', true),

    /*
     | If you have an users table and want it to be updated (creating or updating users) based on the token, you can
     | inform a custom method on a custom UserProvider, that will be called instead retrieveByCredentials and will
     | receive the complete decoded token as parameter, not just the credentials (as default).
     | This will allow you to customize the way you want to interact with your database, before matching and delivering
     | the authenticated user object, having all the information contained in the (valid) access token available. To
     | read more about custom UserProviders, please check Laravel's documentation about.
     |
     | If using this feature, obviously, values defined for user_provider_credential and token_principal_attribute will
     | be ignored.
     */

    'user_provider_custom_retrieve_method' => 'customRetrieve',

    # The field from "users" table that contains the user unique identifier (eg. username, email, nickname). This will be confronted against token_principal_attribute attribute, while authenticating.
    'user_provider_credential' => env('JWT_USER_PROVIDER_CREDENTIAL', 'username'),

    # The property from JWT token that contains the user identifier. This will be confronted against user_provider_credential attribute, while authenticating.
    'token_principal_attribute' => env('JWT_TOKEN_PRINCIPAL_ATTRIBUTE', 'name'),

    # Appends to the authenticated user the full decoded JWT token ($user->token). Useful if you need to know roles, groups and other user info holded by JWT token. Even choosing false, you can also get it using Auth::token(), see API section.
    'append_decoded_token' => env('JWT_APPEND_DECODED_TOKEN', false),

    # Usually you API should handle one resource_access. But, if you handle multiples, just use a comma separated list of allowed resources accepted by API. This attribute will be confronted against resource_access attribute from JWT token, while authenticating.
    'allowed_resources' => env('JWT_ALLOWED_RESOURCES', null),

    # Path to get roles
    'resources_roles_path' => env('JWT_RESOURCES_ROLES_PATH', null)
];
