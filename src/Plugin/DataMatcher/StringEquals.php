<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\StringEquals.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Drupal\rules\Matcher\MatcherInterface;

/**
 * Defines a strings equality matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_string_equals",
 *   label = @Translation("A string equality matcher.")
 * )
 */
class StringEquals implements MatcherInterface {
  private $case_sensitive;
  private $trim;

  public function __construct($case_sensitive = FALSE, $trim = FALSE) {
    if (!is_bool($case_sensitive)) {
      throw new \InvalidArgumentException('$case_sensitive must be a boolean value');
    }

    if (!is_bool($trim)) {
      throw new \InvalidArgumentException('$trim must be a boolean value');
    }

    $this->case_sensitive = $case_sensitive;
    $this->trim = $trim;
  }

  public function match($subject, $object) {
    if ($this->trim) {
      $subject = trim($subject);
      $object = trim($object);
    }

    if (!$this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return $object === $subject;
  }
}
