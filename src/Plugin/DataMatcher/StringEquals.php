<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\StringEquals.
 */

namespace Drupal\rules\Plugin\DataMatcher;

/**
 * Defines a strings equality matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_string_equals",
 *   label = @Translation("A string equality matcher.")
 * )
 */
class StringEquals extends DataMatcherBase {
  private $case_sensitive;
  private $trim;

  public function __construct($case_sensitive = FALSE, $trim = FALSE) {
    $this->validateArgumentType('case_sensitive', $case_sensitive, 'boolean');
    $this->validateArgumentType('trim', $trim, 'boolean');

    $this->case_sensitive = $case_sensitive;
    $this->trim = $trim;
  }

  public function doMatch($subject, $object) {
    if ($this->trim) {
      $subject = trim($subject);
      $object = trim($object);
    }

    if (FALSE === $this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return $object === $subject;
  }
}
