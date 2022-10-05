<?php

namespace ArdentIntent\WpSettingsAdapter\models\settings;

use ArdentIntent\WpSettingsAdapter\facades\Setting;
use ArdentIntent\WpSettingsAdapter\models\settings\SettingTypes;

class TypeHelper
{

  private Setting $setting;

  public function __construct($setting)
  {
    $this->setting = $setting;
  }

  public function text(): Setting
  {
    $this->setting->changeType(SettingTypes::TEXT);
    return $this->setting;
  }

  public function toggle(): Setting
  {
    $this->setting->changeType(SettingTypes::TOGGLE);
    return $this->setting;
  }

  public function select(): Setting
  {
    $this->setting->changeType(SettingTypes::SELECT);
    return $this->setting;
  }

  public function color(): Setting
  {
    $this->setting->changeType(SettingTypes::COLOR);
    return $this->setting;
  }

  /**
   * This is clever and DRY, but breaks IDE suggestions. Sad.
   * But perhaps there is a way to get this to work that I do not know?
   */
  /* public function __construct($setting)
  {
    $this->setting = $setting;

    foreach (SettingTypes::asArray() as $key => $type) {
      $this->{$type} = function () use ($type): Setting {
        $this->setting->options->type = $type;
        $this->setting->view = SettingRendererFactory::request(
          $this->setting->options
        );
        return $this->setting;
      };
    }
  }

  public function __call($method, $args)
  {
    if (property_exists($this, $method)) {
      if (is_callable($this->$method)) {
        return call_user_func_array($this->$method, $args);
      }
    }
  } */
}
