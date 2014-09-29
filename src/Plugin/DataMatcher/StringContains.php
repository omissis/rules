<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\StringContains.
 */

namespace Drupal\rules\Plugin\DataMatcher;

/**
 * Defines a 'string contains' matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_string_contains",
 *   label = @Translation("A 'string contains' matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class StringContains extends DataMatcherBase {
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
