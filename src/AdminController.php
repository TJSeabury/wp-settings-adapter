<?php

namespace ArdentIntent\WpSettingsAdapter;

class AdminController
{

  public function __construct(array $settings, array $sections, array $subPages)
  {
    $this->settings = new \ArdentIntent\WpSettingsAdapter\facades\Page(
      $settings,
      $sections,
      $subPages
    );
  }

  public function init()
  {
    $this->settings->render($this);
  }
}
