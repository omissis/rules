<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesDataMatcher\StringContains.
 */

namespace Drupal\rules\Plugin\RulesDataMatcher;

/**
 * Defines a 'string contains' matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_data_matcher_string_contains",
 *   label = @Translation("A 'string contains' matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class StringContains extends RulesDataMatcherBase {
  /**
   * @var int
   */
  private $offset = 0;

  /**
   *
   * @param int $offset
   */
  public function setOffset($offset) {
    $this->offset = $offset;
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    return FALSE !== strpos($subject, $object, $this->offset);
  }
}
