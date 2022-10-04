<?php

namespace ArdentIntent\WpSettingsAdapter\models\settings;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\models\SettingOptions;
use ArdentIntent\WpSettingsAdapter\interfaces\SettingRenderer;

class TextView implements SettingRenderer
{
  public function __construct(SettingOptions $options)
  {
    $this->options = $options;
  }

  public function render()
  {
    echo Blade::getInstance()->render(
      "Setting.Text",
      [
        'id' => $this->options->options_id,
        'desc' => $this->options->description,
      ]
    );
  }
}
