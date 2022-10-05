# WP Settings Adapter

The Adapter is a declarative facade for the Wordpress Settings API. It is designed to handle the complexities behind the scenes and get out of your way so you can focus on what's really important.

Disregard the tangled, putrid spaghetti and optionalize your theme or plugin with ease!

## Usage Example

```php
use \ArdentIntent\WpSettingsAdapter\Adapter;

global $pluginOptions;
($pluginOptions = Adapter::createPage(
  'Theme Options',
  'Not spaghetti.',
  'manage_options',
  'adapter-test',
  'general',
  'dashicons-flag',
  2
))->withSections([

  ($general = $pluginOptions->createSection('general'))->withSettings([

    $general->createSetting(
      'test-1',
      'An example text setting description.'
    )->ofType()->text(),

    $general->createSetting('test-2')->ofType()->color(),

    $general->createSetting('test-5')->ofType()->text(),

  ]),

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

  ])

])->withSubPages([

  ($subPageOne = $pluginOptions->createSubPage(
    'Subpage One',
    'An example sub-page.',
    'manage_options',
    'adapter-test-sub-one',
    'general',
    1
  ))->withSections([

    ($general = $subPageOne->createSection('general'))->withSettings([

      $general->createSetting('general-1')->ofType()->toggle(),

      $general->createSetting('general-2')->ofType()->select()->withValues([
        'go',
        'touch',
        'grass'
      ])

    ]),

    ($social = $subPageOne->createSection('social'))->withSettings([

      $general->createSetting('social-1', 'Social link 1.')->ofType()->text(),

      $general->createSetting('social-2', 'Social link 2.')->ofType()->text(),

      $general->createSetting('social-3')->ofType()->select()->withValues([
        'on' => 'On',
        'off' => 'Off'
      ])

    ])

  ]),

  ($subPageTwo = $pluginOptions->createSubPage(
    'Subpage Two',
    'An example sub-page.',
    'manage_options',
    'adapter-test-sub-two',
    'general',
    2
  ))->withSections([

    ($whatever = $subPageTwo->createSection('whatever'))->withSettings([

      $whatever->createSetting('what', 'Life is suffering.')->ofType()->toggle(),

      $whatever->createSetting('ever', 'No one understands me.')->ofType()->toggle()

    ])

  ])

])->register();

```
