<?php

return [
  'repository_path'     => env('REPOSITORY_PATH', 'app/Repositories'),
  'interface_subfolder' => env('REPOSITORY_INTERFACE_SUBFOLDER', true),
  'repository_suffix'   => env('REPOSITORY_SUFFIX', 'EloquentRepository'),
  'interface_suffix'    => env('REPOSITORY_INTERFACE_SUFFIX', 'Repository'),
  'transformer_path'    => env('TRANSFORMER_PATH', 'app/Transformers'),
  'filter_path'         => env('FILTER_PATH', 'app/Filters'),
];
