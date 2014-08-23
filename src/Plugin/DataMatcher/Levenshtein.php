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

  /**
   * @var boolean
   */
  private $case_sensitive;

  /**
   * @var int
   */
  private $threshold;

  /**
   * @param boolean $case_sensitive
   * @param int $threshold
   */
  public function __construct($case_sensitive = TRUE, $threshold = 1) {
    $this->validateArgumentType('case_sensitive', $case_sensitive, 'boolean');
    $this->validateArgumentType('threshold', $threshold, 'integer');

    $this->case_sensitive = $case_sensitive;
    $this->threshold = $threshold;
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    if (!$this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return $this->threshold >= levenshtein($subject, $object);
  }
}
