<?php

return [
  'repository_path' => env('REPOSITORY_PATH', base_path('app/Repositories')),
  'interface_subfolder' => env('REPOSITORY_INTERFACE_SUBFOLDER', true),
  'transformer_path' => env('TRANSFORMER_PATH', 'app/Http/Transformers'),
  'filter_path' => env('FILTER_PATH', 'app/Http/Filters'),
];
