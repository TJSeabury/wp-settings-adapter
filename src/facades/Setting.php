<?php

namespace ArdentIntent\WpSettingsAdapter\facades;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\models\SettingOptions;
use ArdentIntent\WpSettingsAdapter\interfaces\SettingRenderer;
use ArdentIntent\WpSettingsAdapter\factories\SettingRendererFactory;

/*
Part of the Settings API. Use this to define a settings field that will show as part of a settings section inside a settings page. The fields are shown using do_settings_fields() in do_settings-sections()

The $callback argument should be the name of a function that echoes out the html input tags for this setting field. Use get_option() to retrieve existing values to show.

$id
(string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.

$title
(string) (Required) Formatted title of the field. Shown as the label for the field during output.

$callback
(callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.

$page
(string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).

$this->optionsection
(string) (Optional) The slug-name of the section of the settings page in which to show the box.

Default value: 'default'

$args
(array) (Optional) Extra arguments used when outputting the field.

'label_for'
(string) When supplied, the setting title will be wrapped in a <label> element, its for attribute populated with this value.
'class'
(string) CSS Class to be added to the <tr> element when the field is output.
Default value: array()

*/

class Setting
{

  private SettingOptions $options;

  private SettingRenderer $view;

  public function __construct(SettingOptions $options)
  {
    $this->options = $options;

    $this->view = SettingRendererFactory::request(
      $this->options
    );
  }

  public function register()
  {
    \add_settings_field(
      $this->options->options_id,
      $this->options->title,
      $this->render(),
      $this->options->pageOptions->slug,
      $this->options->section,
      [
        'section' => $this->options->section,
        'group' => $this->options->options_group,
        'id' => $this->options->options_id,
        'type' => $this->options->type,
        'description' => $this->options->description
      ]
    );

    \register_setting(
      $this->options->pageOptions->slug,
      $this->options->options_id
    );
  }

  private function render()
  {
    return function () {
      $class = '';

      if (!empty($field['args']['class'])) {
        $class = ' class="' . esc_attr($field['args']['class']) . '"';
      }

      echo Blade::getInstance()->render(
        "Setting.Wrap",
        [
          'options' => $this->options,
          'id' => $this->options->options_id,
          'title' => $this->options->title,
          'desc' => $this->options->description,
          'class' => $class,
          'renderedSetting' => $this->view->render()
        ]
      );
    };
  }
}
