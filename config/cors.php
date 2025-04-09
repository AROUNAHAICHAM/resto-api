<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'], // Remplace par ton domaine Flutter en production
'allowed_headers' => ['*'],
];
