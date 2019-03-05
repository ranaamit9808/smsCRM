<?php return array (
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'aloha/twilio' => 
  array (
    'providers' => 
    array (
      0 => 'Aloha\\Twilio\\Support\\Laravel\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Twilio' => 'Aloha\\Twilio\\Support\\Laravel\\Facade',
    ),
  ),
);