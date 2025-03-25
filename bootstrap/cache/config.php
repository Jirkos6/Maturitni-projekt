<?php return array (
  4 => 'concurrency',
  5 => 'cors',
  8 => 'hashing',
  14 => 'view',
  'app' =>
  array (
    'name' => 'Kormorán',
    'env' => 'local',
    'debug' => true,
    'url' => '127.0.0.1:8000',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:ft681tZZMRgeM4N8jnodGTC8BJzeQJ7LchP73zdLjxQ=',
    'previous_keys' =>
    array (
    ),
    'maintenance' =>
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' =>
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\FortifyServiceProvider',
      25 => 'App\\Providers\\JetstreamServiceProvider',
      26 => 'App\\Providers\\MenuServiceProvider',
      27 => 'App\\Providers\\TelescopeServiceProvider',
      28 => 'Mailjet\\LaravelMailjet\\MailjetServiceProvider',
    ),
    'aliases' =>
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Uri' => 'Illuminate\\Support\\Uri',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
  ),
  'auth' =>
  array (
    'defaults' =>
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' =>
    array (
      'web' =>
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'sanctum' =>
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' =>
    array (
      'users' =>
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' =>
    array (
      'users' =>
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' =>
  array (
    'default' => 'reverb',
    'connections' =>
    array (
      'reverb' =>
      array (
        'driver' => 'reverb',
        'key' => 'tu2ye1weuwgzd3d1dhjc',
        'secret' => 'lvxxomyjpkvwv5nyxtdh',
        'app_id' => '235063',
        'options' =>
        array (
          'host' => 'localhost',
          'port' => '8080',
          'scheme' => 'http',
          'useTLS' => false,
        ),
        'client_options' =>
        array (
        ),
      ),
      'pusher' =>
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' =>
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' =>
        array (
        ),
      ),
      'ably' =>
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' =>
      array (
        'driver' => 'log',
      ),
      'null' =>
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' =>
  array (
    'default' => 'database',
    'stores' =>
    array (
      'array' =>
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' =>
      array (
        'driver' => 'file',
        'path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\framework/cache/data',
        'lock_path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\framework/cache/data',
      ),
      'memcached' =>
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' =>
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' =>
        array (
        ),
        'servers' =>
        array (
          0 =>
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' =>
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' =>
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => '',
  ),
  'database' =>
  array (
    'default' => 'mysql',
    'connections' =>
    array (
      'sqlite' =>
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'maturitniprojekt',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' =>
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3307',
        'database' => 'maturitniprojekt',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'mariadb' =>
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3307',
        'database' => 'maturitniprojekt',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'pgsql' =>
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3307',
        'database' => 'maturitniprojekt',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' =>
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3307',
        'database' => 'maturitniprojekt',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' =>
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' =>
    array (
      'client' => 'phpredis',
      'options' =>
      array (
        'cluster' => 'redis',
        'prefix' => 'kormoran_database_',
      ),
      'default' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'filesystems' =>
  array (
    'default' => 'local',
    'disks' =>
    array (
      'local' =>
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\app',
        'throw' => false,
      ),
      'public' =>
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\app/public',
        'url' => '127.0.0.1:8000/storage',
        'visibility' => 'public',
        'throw' => false,
      ),
      's3' =>
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
      ),
    ),
    'links' =>
    array (
      'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\public\\storage' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\app/public',
    ),
  ),
  'fortify' =>
  array (
    'guard' => 'web',
    'middleware' =>
    array (
      0 => 'web',
    ),
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => true,
    'home' => '/dashboard',
    'prefix' => '',
    'domain' => NULL,
    'lowercase_usernames' => true,
    'limiters' =>
    array (
      'login' => 'login',
      'two-factor' => 'two-factor',
    ),
    'paths' =>
    array (
      'login' => NULL,
      'logout' => NULL,
      'password' =>
      array (
        'request' => NULL,
        'reset' => NULL,
        'email' => NULL,
        'update' => NULL,
        'confirm' => NULL,
        'confirmation' => NULL,
      ),
      'register' => NULL,
      'verification' =>
      array (
        'notice' => NULL,
        'verify' => NULL,
        'send' => NULL,
      ),
      'user-profile-information' =>
      array (
        'update' => NULL,
      ),
      'user-password' =>
      array (
        'update' => NULL,
      ),
      'two-factor' =>
      array (
        'login' => NULL,
        'enable' => NULL,
        'confirm' => NULL,
        'disable' => NULL,
        'qr-code' => NULL,
        'secret-key' => NULL,
        'recovery-codes' => NULL,
      ),
    ),
    'redirects' =>
    array (
      'login' => NULL,
      'logout' => NULL,
      'password-confirmation' => NULL,
      'register' => NULL,
      'email-verification' => NULL,
      'password-reset' => NULL,
    ),
    'features' =>
    array (
      0 => 'reset-passwords',
      1 => 'update-profile-information',
      2 => 'update-passwords',
    ),
  ),
  'google-calendar' =>
  array (
    'default_auth_profile' => 'service_account',
    'auth_profiles' =>
    array (
      'service_account' =>
      array (
        'credentials_json' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\app/google-calendar/service-account-credentials.json',
      ),
      'oauth' =>
      array (
        'credentials_json' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\app/google-calendar/oauth-credentials.json',
        'token_json' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\app/google-calendar/oauth-token.json',
      ),
    ),
    'calendar_id' => NULL,
    'user_to_impersonate' => NULL,
  ),
  'jetstream' =>
  array (
    'stack' => 'livewire',
    'middleware' =>
    array (
      0 => 'web',
    ),
    'features' =>
    array (
      0 => 'account-deletion',
    ),
    'profile_photo_disk' => 'public',
    'auth_session' => 'Laravel\\Jetstream\\Http\\Middleware\\AuthenticateSession',
    'guard' => 'sanctum',
  ),
  'logging' =>
  array (
    'default' => 'stack',
    'deprecations' =>
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' =>
    array (
      'stack' =>
      array (
        'driver' => 'stack',
        'channels' =>
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' =>
      array (
        'driver' => 'single',
        'path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' =>
      array (
        'driver' => 'daily',
        'path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' =>
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' =>
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' =>
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' =>
        array (
          'stream' => 'php://stderr',
        ),
        'processors' =>
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' =>
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' =>
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' =>
      array (
        'path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\logs/laravel.log',
      ),
      'deprecations' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
    ),
  ),
  'mail' =>
  array (
    'default' => 'mailjet',
    'mailers' =>
    array (
      'smtp' =>
      array (
        'transport' => 'smtp',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => 2525,
        'encryption' => 'tls',
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'local_domain' => NULL,
      ),
      'ses' =>
      array (
        'transport' => 'ses',
      ),
      'postmark' =>
      array (
        'transport' => 'postmark',
      ),
      'resend' =>
      array (
        'transport' => 'resend',
      ),
      'sendmail' =>
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' =>
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' =>
      array (
        'transport' => 'array',
      ),
      'failover' =>
      array (
        'transport' => 'failover',
        'mailers' =>
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
      'roundrobin' =>
      array (
        'transport' => 'roundrobin',
        'mailers' =>
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
      ),
      'mailjet' =>
      array (
        'transport' => 'mailjet',
      ),
    ),
    'from' =>
    array (
      'address' => 'skaut@rpg-4fun.eu',
      'name' => 'Kormorán',
    ),
    'markdown' =>
    array (
      'theme' => 'default',
      'paths' =>
      array (
        0 => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'queue' =>
  array (
    'default' => 'database',
    'connections' =>
    array (
      'sync' =>
      array (
        'driver' => 'sync',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' =>
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' =>
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'batching' =>
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' =>
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'reverb' =>
  array (
    'default' => 'reverb',
    'servers' =>
    array (
      'reverb' =>
      array (
        'host' => '0.0.0.0',
        'port' => 8080,
        'hostname' => 'localhost',
        'options' =>
        array (
          'tls' =>
          array (
          ),
        ),
        'max_request_size' => 10000,
        'scaling' =>
        array (
          'enabled' => false,
          'channel' => 'reverb',
          'server' =>
          array (
            'url' => NULL,
            'host' => '127.0.0.1',
            'port' => '6379',
            'username' => NULL,
            'password' => NULL,
            'database' => '0',
          ),
        ),
        'pulse_ingest_interval' => 15,
        'telescope_ingest_interval' => 15,
      ),
    ),
    'apps' =>
    array (
      'provider' => 'config',
      'apps' =>
      array (
        0 =>
        array (
          'key' => 'tu2ye1weuwgzd3d1dhjc',
          'secret' => 'lvxxomyjpkvwv5nyxtdh',
          'app_id' => '235063',
          'options' =>
          array (
            'host' => 'localhost',
            'port' => '8080',
            'scheme' => 'http',
            'useTLS' => false,
          ),
          'allowed_origins' =>
          array (
            0 => '*',
          ),
          'ping_interval' => 60,
          'activity_timeout' => 30,
          'max_message_size' => 10000,
        ),
      ),
    ),
  ),
  'sanctum' =>
  array (
    'stateful' =>
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => '127.0.0.1:8000',
    ),
    'guard' =>
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'token_prefix' => '',
    'middleware' =>
    array (
      'authenticate_session' => 'Laravel\\Sanctum\\Http\\Middleware\\AuthenticateSession',
      'encrypt_cookies' => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
      'validate_csrf_token' => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
    ),
  ),
  'services' =>
  array (
    'postmark' =>
    array (
      'token' => NULL,
    ),
    'ses' =>
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'resend' =>
    array (
      'key' => NULL,
    ),
    'slack' =>
    array (
      'notifications' =>
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
      'mailjet' =>
      array (
        'key' => '74d3b98a20f2f6bf71a7b03dd55e0c4d',
        'secret' => 'fefe2f6f745e7d3b196b8fead5cbbf46',
      ),
    ),
    'google' =>
    array (
      'client_id' => '200060981180-o3c8ljla58eojnh49a9ba7i93offje6d.apps.googleusercontent.com',
      'client_secret' => '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',
      'redirect' => 'http://127.0.0.1:8000/auth/callback',
    ),
    'mailjet' =>
    array (
      'key' => '74d3b98a20f2f6bf71a7b03dd55e0c4d',
      'secret' => 'fefe2f6f745e7d3b196b8fead5cbbf46',
    ),
  ),
  'session' =>
  array (
    'driver' => 'database',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' =>
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'kormoran_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'telescope' =>
  array (
    'enabled' => true,
    'domain' => NULL,
    'path' => 'telescope',
    'driver' => 'database',
    'storage' =>
    array (
      'database' =>
      array (
        'connection' => 'mysql',
        'chunk' => 1000,
      ),
    ),
    'queue' =>
    array (
      'connection' => NULL,
      'queue' => NULL,
      'delay' => 10,
    ),
    'middleware' =>
    array (
      0 => 'web',
      1 => 'Laravel\\Telescope\\Http\\Middleware\\Authorize',
    ),
    'only_paths' =>
    array (
    ),
    'ignore_paths' =>
    array (
      0 => 'livewire*',
      1 => 'nova-api*',
      2 => 'pulse*',
    ),
    'ignore_commands' =>
    array (
    ),
    'watchers' =>
    array (
      'Laravel\\Telescope\\Watchers\\BatchWatcher' => true,
      'Laravel\\Telescope\\Watchers\\CacheWatcher' =>
      array (
        'enabled' => true,
        'hidden' =>
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\ClientRequestWatcher' => true,
      'Laravel\\Telescope\\Watchers\\CommandWatcher' =>
      array (
        'enabled' => true,
        'ignore' =>
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\DumpWatcher' =>
      array (
        'enabled' => true,
        'always' => false,
      ),
      'Laravel\\Telescope\\Watchers\\EventWatcher' =>
      array (
        'enabled' => true,
        'ignore' =>
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\ExceptionWatcher' => true,
      'Laravel\\Telescope\\Watchers\\GateWatcher' =>
      array (
        'enabled' => true,
        'ignore_abilities' =>
        array (
        ),
        'ignore_packages' => true,
        'ignore_paths' =>
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\JobWatcher' => true,
      'Laravel\\Telescope\\Watchers\\LogWatcher' =>
      array (
        'enabled' => true,
        'level' => 'error',
      ),
      'Laravel\\Telescope\\Watchers\\MailWatcher' => true,
      'Laravel\\Telescope\\Watchers\\ModelWatcher' =>
      array (
        'enabled' => true,
        'events' =>
        array (
          0 => 'eloquent.*',
        ),
        'hydrations' => true,
      ),
      'Laravel\\Telescope\\Watchers\\NotificationWatcher' => true,
      'Laravel\\Telescope\\Watchers\\QueryWatcher' =>
      array (
        'enabled' => true,
        'ignore_packages' => true,
        'ignore_paths' =>
        array (
        ),
        'slow' => 100,
      ),
      'Laravel\\Telescope\\Watchers\\RedisWatcher' => true,
      'Laravel\\Telescope\\Watchers\\RequestWatcher' =>
      array (
        'enabled' => true,
        'size_limit' => 64,
        'ignore_http_methods' =>
        array (
        ),
        'ignore_status_codes' =>
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\ScheduleWatcher' => true,
      'Laravel\\Telescope\\Watchers\\ViewWatcher' => true,
    ),
  ),
  'variables' =>
  array (
    'creatorName' => 'ThemeSelection',
    'creatorUrl' => 'https://themeselection.com',
    'templateName' => 'Kormorán',
    'templateSuffix' => 'Bootstrap Dashboard FREE',
    'templateVersion' => '2.0.0',
    'templateFree' => true,
    'templateDescription' => 'Most Powerful & Comprehensive Bootstrap 5 + Laravel HTML Admin Dashboard Template built for developers!',
    'templateKeyword' => 'dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5, bootstrap 5 free, free admin template',
    'licenseUrl' => 'https://themeselection.com/license/',
    'livePreview' => 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template-free/demo/',
    'productPage' => 'https://themeselection.com/item/materio-dashboard-free-laravel/',
    'productPagePro' => 'https://themeselection.com/item/materio-dashboard-pro-laravel/',
    'support' => 'https://github.com/themeselection/materio-bootstrap-html-laravel-admin-template-free/issues',
    'moreThemes' => 'https://themeselection.com/',
    'documentation' => 'https://demos.themeselection.com/materio-bootstrap-html-admin-template/documentation',
    'repository' => 'https://github.com/themeselection/materio-bootstrap-html-laravel-admin-template-free',
    'gitRepo' => 'https://github.com/themeselection/materio-bootstrap-html-laravel-admin-template-free.git',
    'gitRepoAccess' => 'https://tools.themeselection.com/github/github-access',
    'githubFreeUrl' => 'https://github.com/themeselection',
    'facebookUrl' => 'https://www.facebook.com/ThemeSelections/',
    'twitterUrl' => 'https://twitter.com/Theme_Selection',
    'githubUrl' => 'https://github.com/themeselection',
    'dribbbleUrl' => 'https://dribbble.com/themeselection',
    'instagramUrl' => 'https://www.instagram.com/themeselection/',
  ),
  'concurrency' =>
  array (
    'default' => 'process',
  ),
  'cors' =>
  array (
    'paths' =>
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' =>
    array (
      0 => '*',
    ),
    'allowed_origins' =>
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' =>
    array (
    ),
    'allowed_headers' =>
    array (
      0 => '*',
    ),
    'exposed_headers' =>
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'hashing' =>
  array (
    'driver' => 'bcrypt',
    'bcrypt' =>
    array (
      'rounds' => '12',
      'verify' => true,
    ),
    'argon' =>
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'view' =>
  array (
    'paths' =>
    array (
      0 => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\resources\\views',
    ),
    'compiled' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\framework\\views',
  ),
  'debugbar' =>
  array (
    'enabled' => NULL,
    'hide_empty_tabs' => true,
    'except' =>
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' =>
    array (
      'enabled' => true,
      'open' => NULL,
      'driver' => 'file',
      'path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\storage\\debugbar',
      'connection' => NULL,
      'provider' => '',
      'hostname' => '127.0.0.1',
      'port' => 2304,
    ),
    'editor' => 'phpstorm',
    'remote_sites_path' => NULL,
    'local_sites_path' => NULL,
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'ajax_handler_auto_show' => true,
    'ajax_handler_enable_tab' => true,
    'defer_datasets' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' =>
    array (
      'phpinfo' => false,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => false,
      'auth' => false,
      'gate' => true,
      'session' => false,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => true,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
      'jobs' => false,
      'pennant' => false,
    ),
    'options' =>
    array (
      'time' =>
      array (
        'memory_usage' => false,
      ),
      'messages' =>
      array (
        'trace' => true,
      ),
      'memory' =>
      array (
        'reset_peak' => false,
        'with_baseline' => false,
        'precision' => 0,
      ),
      'auth' =>
      array (
        'show_name' => true,
        'show_guards' => true,
      ),
      'db' =>
      array (
        'with_params' => true,
        'exclude_paths' =>
        array (
        ),
        'backtrace' => true,
        'backtrace_exclude_paths' =>
        array (
        ),
        'timeline' => false,
        'duration_background' => true,
        'explain' =>
        array (
          'enabled' => false,
        ),
        'hints' => false,
        'show_copy' => true,
        'slow_threshold' => false,
        'memory_usage' => false,
        'soft_limit' => 100,
        'hard_limit' => 500,
      ),
      'mail' =>
      array (
        'timeline' => true,
        'show_body' => true,
      ),
      'views' =>
      array (
        'timeline' => true,
        'data' => false,
        'group' => 50,
        'exclude_paths' =>
        array (
          0 => 'vendor/filament',
        ),
      ),
      'route' =>
      array (
        'label' => true,
      ),
      'session' =>
      array (
        'hiddens' =>
        array (
        ),
      ),
      'symfony_request' =>
      array (
        'label' => true,
        'hiddens' =>
        array (
        ),
      ),
      'events' =>
      array (
        'data' => false,
      ),
      'logs' =>
      array (
        'file' => NULL,
      ),
      'cache' =>
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_middleware' =>
    array (
    ),
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'livewire' =>
  array (
    'class_namespace' => 'App\\Livewire',
    'view_path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt\\resources\\views/livewire',
    'layout' => 'components.layouts.app',
    'lazy_placeholder' => NULL,
    'temporary_file_upload' =>
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' =>
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
      'cleanup' => true,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' =>
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'pagination_theme' => 'tailwind',
  ),
  'mailersend-driver' =>
  array (
    'api_key' => NULL,
    'host' => 'api.mailersend.com',
    'protocol' => 'https',
    'api_path' => 'v1',
  ),
  'flare' =>
  array (
    'key' => NULL,
    'flare_middleware' =>
    array (
      0 => 'Spatie\\FlareClient\\FlareMiddleware\\RemoveRequestIp',
      1 => 'Spatie\\FlareClient\\FlareMiddleware\\AddGitInformation',
      2 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddNotifierName',
      3 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddEnvironmentInformation',
      4 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionInformation',
      5 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddDumps',
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddLogs' =>
      array (
        'maximum_number_of_collected_logs' => 200,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddQueries' =>
      array (
        'maximum_number_of_collected_queries' => 200,
        'report_query_bindings' => true,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddJobs' =>
      array (
        'max_chained_job_reporting_depth' => 5,
      ),
      6 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddContext',
      7 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionHandledStatus',
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestBodyFields' =>
      array (
        'censor_fields' =>
        array (
          0 => 'password',
          1 => 'password_confirmation',
        ),
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestHeaders' =>
      array (
        'headers' =>
        array (
          0 => 'API-KEY',
          1 => 'Authorization',
          2 => 'Cookie',
          3 => 'Set-Cookie',
          4 => 'X-CSRF-TOKEN',
          5 => 'X-XSRF-TOKEN',
        ),
      ),
    ),
    'send_logs_as_events' => true,
  ),
  'ignition' =>
  array (
    'editor' => 'phpstorm',
    'theme' => 'auto',
    'enable_share_button' => true,
    'register_commands' => false,
    'solution_providers' =>
    array (
      0 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\BadMethodCallSolutionProvider',
      1 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\MergeConflictSolutionProvider',
      2 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\UndefinedPropertySolutionProvider',
      3 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\IncorrectValetDbCredentialsSolutionProvider',
      4 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingAppKeySolutionProvider',
      5 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\DefaultDbNameSolutionProvider',
      6 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\TableNotFoundSolutionProvider',
      7 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingImportSolutionProvider',
      8 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\InvalidRouteActionSolutionProvider',
      9 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\ViewNotFoundSolutionProvider',
      10 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\RunningLaravelDuskInProductionProvider',
      11 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingColumnSolutionProvider',
      12 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownValidationSolutionProvider',
      13 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingMixManifestSolutionProvider',
      14 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingViteManifestSolutionProvider',
      15 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingLivewireComponentSolutionProvider',
      16 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UndefinedViewVariableSolutionProvider',
      17 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\GenericLaravelExceptionSolutionProvider',
      18 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\OpenAiSolutionProvider',
      19 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\SailNetworkSolutionProvider',
      20 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownMysql8CollationSolutionProvider',
      21 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownMariadbCollationSolutionProvider',
    ),
    'ignored_solution_providers' =>
    array (
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => 'C:\\xampp\\htdocs\\achilles\\Maturitni-projekt',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
    'settings_file_path' => '',
    'recorders' =>
    array (
      0 => 'Spatie\\LaravelIgnition\\Recorders\\DumpRecorder\\DumpRecorder',
      1 => 'Spatie\\LaravelIgnition\\Recorders\\JobRecorder\\JobRecorder',
      2 => 'Spatie\\LaravelIgnition\\Recorders\\LogRecorder\\LogRecorder',
      3 => 'Spatie\\LaravelIgnition\\Recorders\\QueryRecorder\\QueryRecorder',
    ),
    'open_ai_key' => NULL,
    'with_stack_frame_arguments' => true,
    'argument_reducers' =>
    array (
      0 => 'Spatie\\Backtrace\\Arguments\\Reducers\\BaseTypeArgumentReducer',
      1 => 'Spatie\\Backtrace\\Arguments\\Reducers\\ArrayArgumentReducer',
      2 => 'Spatie\\Backtrace\\Arguments\\Reducers\\StdClassArgumentReducer',
      3 => 'Spatie\\Backtrace\\Arguments\\Reducers\\EnumArgumentReducer',
      4 => 'Spatie\\Backtrace\\Arguments\\Reducers\\ClosureArgumentReducer',
      5 => 'Spatie\\Backtrace\\Arguments\\Reducers\\DateTimeArgumentReducer',
      6 => 'Spatie\\Backtrace\\Arguments\\Reducers\\DateTimeZoneArgumentReducer',
      7 => 'Spatie\\Backtrace\\Arguments\\Reducers\\SymphonyRequestArgumentReducer',
      8 => 'Spatie\\LaravelIgnition\\ArgumentReducers\\ModelArgumentReducer',
      9 => 'Spatie\\LaravelIgnition\\ArgumentReducers\\CollectionArgumentReducer',
      10 => 'Spatie\\Backtrace\\Arguments\\Reducers\\StringableArgumentReducer',
    ),
  ),
  'tinker' =>
  array (
    'commands' =>
    array (
    ),
    'alias' =>
    array (
    ),
    'dont_alias' =>
    array (
      0 => 'App\\Nova',
    ),
  ),
);
