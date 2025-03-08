<?php

return [
  'repository_path' => env('REPOSITORY_PATH', base_path('app/Repositories')),
  'interface_subfolder' => env('REPOSITORY_INTERFACE_SUBFOLDER', true),
  'transformer_path' => 'app/Http/Transformers',
  'filter_path' => 'app/Http/Filters'
];
