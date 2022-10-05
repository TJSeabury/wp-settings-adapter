# WP Settings Adapter

The Adapter is a declarative facade for the Wordpress Settings API. It is designed to handle the complexities behind the scenes and get out of your way so your can focus on what's really important.

Disregard the tangled, putrid spaghetti and optionalize your theme or plugin with ease!

## Usage Example

```php
use \ArdentIntent\WpSettingsAdapter\Adapter;

global $pluginOptions;
$pluginOptions = Adapter::create(
  'Adapter Test',
  'This is the root options page description.',
  'manage_options',
  'adapter-test',
  'general',
  'dashicon-flag',
  2
);

($general = $pluginOptions->createSection('general'))->withSettings([
  $general->createSetting(
    'test-1',
    'An example text setting description.'
  )->ofType()->text(),
  $general->createSetting('test-2')->ofType()->color(),
  $general->createSetting('test-5')->ofType()->text(),
]);

($special = $pluginOptions->createSection('special'))->withSettings([

  $special->createSetting(
    'test-6',
    'A short description of this setting.'
  )->ofType()->text(),

  $special->createSetting(
    'test-3',
    'An example select setting.'
  )->ofType()->select()->withValues([
    'apple' => 'Apple',
    'pear' => 'Pear',
    'pineapple' => 'Pineapple'
  ]),

  $special->createSetting('test-4')->ofType()->toggle(),

]);

$pluginOptions->withSections([
  $general,
  $special
]);

$pluginOptions->register();

```
