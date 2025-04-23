<?php return [
  'debug' => true,
  'languages' => true,
  
  'email' => [
    'transport' => [
      'type' => 'smtp',
      'host' => 'localhost',
      'port' => 1025,
      'security' => false,
    ],
  ],

  'arnoson.kirby-forms' => [
    'fromEmails' => ['noreply@example.com'],
    'clientValidation' => false,
  ],
];
