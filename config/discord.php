<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Discord Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings for Discord integration, 
    | including OAuth settings, server ID, and role IDs for different user types.
    |
    */

    // OAuth Settings
    'client_id' => env('DISCORD_CLIENT_ID'),
    'client_secret' => env('DISCORD_CLIENT_SECRET'),
    'redirect_uri' => env('DISCORD_REDIRECT_URI'),
    
    // Server Settings
    'server_id' => env('DISCORD_SERVER_ID'),
    
    // Role IDs
    'roles' => [
        'admin' => env('DISCORD_ROLE_ADMIN'),
        'premium' => env('DISCORD_ROLE_PREMIUM'),
        'external' => env('DISCORD_ROLE_EXTERNAL'),
        'streamer' => env('DISCORD_ROLE_STREAMER'),
        'bypass' => env('DISCORD_ROLE_BYPASS'),
        'reseller' => env('DISCORD_ROLE_RESELLER'),
    ],
    
    // API Settings
    'api_base_url' => 'https://discord.com/api',
    'api_version' => 'v10',
    
    // Bot Settings
    'bot_token' => env('DISCORD_BOT_TOKEN'),
    
    // Others
    'guild_member_add_role_on_auth' => true,

]; 