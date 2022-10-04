<?php

namespace ArdentIntent\WpSettingsAdapter;

use \ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\facades\Page;
use ArdentIntent\WpSettingsAdapter\facades\Section;
use ArdentIntent\WpSettingsAdapter\models\PageOptions;
use ArdentIntent\WpSettingsAdapter\models\SectionCollection;
use ArdentIntent\WpSettingsAdapter\models\SectionOptions;

class Adapter
{
  private Page $root;

  protected function __construct(Page $page)
  {
    $this->blade = Blade::getInstance();
    $this->blade->addViewPath(realpath(__DIR__ . '/views'));

    $this->root = $page;
  }

  /**
   * The adapter creates a new menu root page.
   */
  public static function create(
    string $title,
    string $capability,
    string $slug,
    string $type,
    string $icon = '',
    int $position = null
  ): Adapter {
    return new Adapter(new Page(new PageOptions(
      $title,
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
  public function withSections(array $sections): void
  {
    $this->root->withSections($sections);
  }

  public function Section(
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
  public function withSubPages(array $subPages): void
  {
    $this->root->withSubPages($subPages);
  }

  /**
   * @todo Figure out how to handle sub-pages.
   */
  public function SubPage()
  {
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
