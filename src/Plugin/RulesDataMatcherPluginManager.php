<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesExpressionPluginManager.
 */

namespace Drupal\rules\Plugin;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Plugin manager for all Rules' DataMatchers.
 */
class RulesDataMatcherPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, ModuleHandlerInterface $module_handler, $plugin_definition_annotation_name = 'Drupal\rules\Annotation\RulesDataMatcher') {
    $this->alterInfo('rules_datamatcher');

    parent::__construct('Plugin/DataMatcher', $namespaces, $module_handler, 'Drupal\rules\Matcher\MatcherInterface', $plugin_definition_annotation_name);
  }

}
