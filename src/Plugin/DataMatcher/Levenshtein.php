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
 *   label = @Translation("A Levenshtein distance matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class Levenshtein extends DataMatcherBase {
  private $threshold;

  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * Threshold for levenstein function.
   *
   * @param int $threshold
   */
  public function setThreshold($threshold) {
    $this->threshold = $threshold;
  }

  /**
   *
   * @return int
   */
  protected function getThreshold() {
    return isset($this->threshold) ? $this->threshold : 1;
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    return $this->getThreshold() >= levenshtein($subject, $object);
  }
}
