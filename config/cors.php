<?php

return [
    'paths' => ['api/*'], // Les routes à autoriser
    'allowed_methods' => ['*'], // Méthodes HTTP autorisées
    'allowed_origins' => ['*'], // Origines autorisées (remplace par ton domaine Flutter en prod)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // En-têtes autorisés
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
