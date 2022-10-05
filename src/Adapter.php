<?php

namespace ArdentIntent\WpSettingsAdapter;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\facades\Page;
use ArdentIntent\WpSettingsAdapter\models\PageOptions;
use ArdentIntent\WpSettingsAdapter\facades\SubPage;
use ArdentIntent\WpSettingsAdapter\models\SubPageOptions;
use ArdentIntent\WpSettingsAdapter\facades\Section;
use ArdentIntent\WpSettingsAdapter\models\SectionOptions;

class Adapter
{
  private Page $root;

  private static bool $developmentMode = false;

  public static function enableDevMode(): void
  {
    self::$developmentMode = true;
  }

  public static function devMode()
  {
    return self::$developmentMode;
  }

  private static array $optionCache = [];

  public static function get($option_id)
  {
    if (!array_key_exists($option_id, self::$optionCache)) {
      self::$optionCache[$option_id] = get_option($option_id);
    }
    return self::$optionCache[$option_id];
  }

  protected function __construct(Page $page)
  {
    $this->blade = Blade::getInstance();
    $this->blade->addViewPath(realpath(__DIR__ . '/views'));

    $this->root = $page;
  }

  /**
   * The adapter creates a new menu root page.
   */
  public static function createPage(
    string $title,
    string $description,
    string $capability,
    string $slug,
    string $type,
    string $icon = '',
    int $position = null
  ): Adapter {
    return new Adapter(new Page(new PageOptions(
      $title,
      $description,
      $capability,
      $slug,
      $type,
      $icon,
      $position
    )));
  }

  /**
   * Register sections to the adapter's root page.
   * The sections should contain registered setting fields.
   */
  public function withSections(array $sections): Adapter
  {
    $this->root->withSections($sections);
    return $this;
  }

  public function createSection(
    string $id,
    string $type = 'general',
    string $description = ''
  ): Section {
    return new Section(new SectionOptions(
      $this->root->options,
      $id,
      $type,
      $description
    ));
  }

  /**
   * Register sub-pages to the adapters root page.
   * The sub-pages should contain registered sections
   * with their respective registered setting fields.
   */
  public function withSubPages(array $subPages): Adapter
  {
    $this->root->withSubPages($subPages);
    return $this;
  }

  /**
   * @todo Figure out how to handle sub-pages.
   */
  public function createSubPage(
    string $title,
    string $description,
    string $capability,
    string $slug,
    string $type,
    int $position = null
  ): SubPage {
    return new SubPage(new SubPageOptions(
      $this->root->options->slug,
      $title,
      $description,
      $capability,
      $slug,
      $type,
      '',
      $position
    ));
  }

  /**
   * The adapter will register the finalized menu page model with Wordpress.
   * This should be called last.
   */
  public function register()
  {
    $this->root->register();
  }
}
