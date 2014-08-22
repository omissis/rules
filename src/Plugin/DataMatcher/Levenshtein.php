<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\Levenshtein.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Drupal\rules\Matcher\MatcherInterface;

/**
 * Defines a levenshtein distance matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_levenshtein",
 *   label = @Translation("A Levenshtein distance matcher.")
 * )
 */
class Levenshtein implements MatcherInterface {
  private $threshold;

  public function __construct($threshold = 1) {
    if (!is_int($threshold)) {
      throw new \InvalidArgumentException('$offset must be an integer value');
    }

    $this->threshold = $threshold;
  }

  public function match($subject, $object) {
    if (!is_string($subject)) {
      throw new \InvalidArgumentException('$subject must be a string');
    }

    if (!is_string($object)) {
      throw new \InvalidArgumentException('$object must be a string');
    }

    return $this->threshold >= levenshtein($subject, $object);
  }
}
