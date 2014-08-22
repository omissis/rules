<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\Levenshtein.
 */

namespace Drupal\rules\Plugin\DataMatcher;

/**
 * Defines a levenshtein distance matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_levenshtein",
 *   label = @Translation("A Levenshtein distance matcher.")
 * )
 */
class Levenshtein extends DataMatcherBase {
  private $case_sensitive;
  private $threshold;

  public function __construct($case_sensitive = TRUE, $threshold = 1) {
    if (!is_int($threshold)) {
      throw new \InvalidArgumentException('$offset must be an integer value');
    }

    $this->case_sensitive = $case_sensitive;
    $this->threshold = $threshold;
  }

  protected function doMatch($subject, $object) {
    if (!$this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return $this->threshold >= levenshtein($subject, $object);
  }
}
