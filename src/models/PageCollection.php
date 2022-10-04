<?php

namespace ArdentIntent\WpSettingsAdapter\models;

use ArdentIntent\WpSettingsAdapter\facades\pages\Page;

class PageCollection extends AbstractTypedArray
{
  const ARRAY_TYPE = Page::class;
}
