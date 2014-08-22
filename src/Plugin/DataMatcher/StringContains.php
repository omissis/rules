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
  private $case_sensitive;
  private $offset;

  public function __construct($case_sensitive = TRUE, $offset = 0) {
    if (!is_bool($case_sensitive)) {
      throw new \InvalidArgumentException('$case_sensitive must be a boolean value');
    }

    if (!is_int($offset)) {
      throw new \InvalidArgumentException('$offset must be an integer value');
    }

    $this->case_sensitive = $case_sensitive;
    $this->offset = $offset;
  }

  public function doMatch($subject, $object) {
    if (FALSE === $this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return false !== strpos($subject, $object, $this->offset);
  }
}
