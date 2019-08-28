<?php

return [


    /*
    |-----------------------------------------------
    | Custom Config
    |--------------------------------------------
    */
    'system_id' => env('SYSTEM_ID'),
    'hostname' => env('HOSTNAME'),
    'vehicle_badge_colors' => [
        'SPLASH WHITE'       => "kt-badge kt-badge--splash-white kt-badge--md kt-badge--rounded",
        'RED SPINEL MICA'    => "kt-badge kt-badge--red-spinel-mica kt-badge--md kt-badge--rounded",
        'ARC WHITE'          => "kt-badge kt-badge--arc-white kt-badge--md kt-badge--rounded",
        'SILKY PEARL WHITE'  => "kt-badge kt-badge--silky-pearl-white kt-badge--md kt-badge--rounded",
        'GALENA GRAY'        => "kt-badge kt-badge--galena-gray kt-badge--md kt-badge--rounded",
        'MARINE BLUE'        => "kt-badge kt-badge--marine-blue kt-badge--md kt-badge--rounded",
        'OBSIDIAN GRAY MICA' => "kt-badge kt-badge--obsidian-gray-mica kt-badge--md kt-badge--rounded",
        'HUNTER GREEN'       => "kt-badge kt-badge--hunter-green kt-badge--md kt-badge--rounded",
        'GARNET RED'         => "kt-badge kt-badge--garnet-red kt-badge--md kt-badge--rounded",
        'TITANIUM SILVER'    => "kt-badge kt-badge--titanium-silver kt-badge--md kt-badge--rounded",
        'COSMIC BLACK MICA'  => "kt-badge kt-badge--cosmic-black-mica kt-badge--md kt-badge--rounded",
        'CREAM WHITE'        => "kt-badge kt-badge--cream-white kt-badge--md kt-badge--rounded",
        'DARK SILVER'        => "kt-badge kt-badge--dark-silver kt-badge--md kt-badge--rounded",
        'OUTBACK BROWN'      => "kt-badge kt-badge--outback-brown kt-badge--md kt-badge--rounded",
        'SAPPHIRE BLUE'      => "kt-badge kt-badge--sapphire-blue kt-badge--md kt-badge--rounded",
        'SILVER'             => "kt-badge kt-badge--silver kt-badge--md kt-badge--rounded",
        'ASH BEIGE'          => "kt-badge kt-badge--ash-beige kt-badge--md kt-badge--rounded",
        'AQUA BLUE'          => "kt-badge kt-badge--aqua-blue kt-badge--md kt-badge--rounded",
        'VENETIAN RED'       => "kt-badge kt-badge--venetian-red kt-badge--md kt-badge--rounded",
        'HAVANA BROWN'       => "kt-badge kt-badge--havana-brown kt-badge--md kt-badge--rounded",
        'NO COLOR'           => "kt-badge kt-badge--no-color kt-badge--md kt-badge--rounded"
    ],
    'status_colors' => [
        'New'          => "kt-badge kt-badge--brand kt-badge--inline",
        'Acknowledged' => "kt-badge kt-badge--success kt-badge--inline",
        'Approved'     => "kt-badge kt-badge--success kt-badge--inline",
        'Submitted'    => "kt-badge kt-badge--warning kt-badge--inline",
        'Open'    => "kt-badge kt-badge--warning kt-badge--inline",
        'Cancelled'    => "kt-badge kt-badge--danger kt-badge--inline",
        'CANCELLED'    => "kt-badge kt-badge--danger kt-badge--inline",
        'Rejected'     => "kt-badge kt-badge--danger kt-badge--inline",
        'In progress'  => "kt-badge kt-badge--warning kt-badge--inline",
        'Pending'      => "kt-badge kt-badge--warning kt-badge--inline",
        'CLOSED'       => "kt-badge kt-badge--success kt-badge--inline",
        'Closed'       => "kt-badge kt-badge--success kt-badge--inline"
    ],
    'vehicle_lead_time' => [
        // In months
        'N-SERIES'       => 1,
        'CROSSWIND'      => 0,
        'C AND E SERIES' => 3,
        'MU-X'           => 0,
        'Q-SERIES'       => 2,
        'D-MAX'          => 0,
        'F-SERIES'       => 2,
        'BUS'            => 2
    ],
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Fleet Ordering System'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL'),
    
    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Manila',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
         Yajra\Oci8\Oci8ServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,

    ],

];
