<?php

/**
 * @file
 * Contains \Drupal\rules\Annotation\RulesDataMatcher.
 */

namespace Drupal\rules\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the RulesDataMatcher annotation class.
 *
 * This annotation is used to identify plugins that want to perform a match test
 * against two values.
 *
 * @Annotation
 */
class RulesDataMatcher extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the rules plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * Define the type of the subject.
   *
   * @var string
   */
  public $subject_type;

  /**
   * Define the type of the object.
   *
   * @var string
   */
  public $object_type;

}
