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
 *   label = @Translation("A 'string contains' matcher.")
 * )
 */
class StringContains extends DataMatcherBase {

  /**
   * @var boolean
   */
  private $case_sensitive;

  /**
   * @var int
   */
  private $offset;

  public function __construct($case_sensitive = TRUE, $offset = 0) {
    $this->validateArgumentType('case_sensitive', $case_sensitive, 'boolean');
    $this->validateArgumentType('offset', $offset, 'integer');

    $this->case_sensitive = $case_sensitive;
    $this->offset = $offset;
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    if (FALSE === $this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return false !== strpos($subject, $object, $this->offset);
  }
}
