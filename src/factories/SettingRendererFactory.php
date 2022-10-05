<?php

namespace ArdentIntent\WpSettingsAdapter\factories;

use ArdentIntent\WpSettingsAdapter\interfaces\SettingRenderer;
use ArdentIntent\WpSettingsAdapter\models\SettingOptions;
use ArdentIntent\WpSettingsAdapter\models\settings\ColorView;
use ArdentIntent\WpSettingsAdapter\models\settings\SettingTypes;
use ArdentIntent\WpSettingsAdapter\models\settings\TextView;
use ArdentIntent\WpSettingsAdapter\models\settings\ToggleView;

/**
 * I'm actually unsure if a factory is nesseccary.. oh well, it's probably fine.
 */
class SettingRendererFactory
{
  public static function request(SettingOptions $options): SettingRenderer
  {
    if (!SettingTypes::isValidValue($options->type)) {
      throw new \InvalidArgumentException("$options->type is not a valid Setting type.");
    }

    switch ($options->type) {
      case SettingTypes::TEXT:
        return new TextView($options);
        break;
      case SettingTypes::TOGGLE:
        return new ToggleView($options);
        break;
      case SettingTypes::COLOR:
        return new ColorView($options);
        break;
      default:
        return new TextView($options);
        break;
    }
  }
}
