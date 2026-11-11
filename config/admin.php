<?php

return [
    'email' => env('ADMIN_DEFAULT_EMAIL', env('ADMIN_EMAIL', 'admin@rpalma.edu.pe')),
    'password' => env('ADMIN_DEFAULT_PASSWORD', env('ADMIN_PASSWORD', '@dmin$RP')),
    'name' => env('ADMIN_DEFAULT_NAME', env('ADMIN_NAME', 'Administrador')),
];
