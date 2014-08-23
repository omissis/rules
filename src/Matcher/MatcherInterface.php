<?php

/**
 * @file
 * Contains \Drupal\rules\Matcher\MatcherInterface.
 */

namespace Drupal\rules\Matcher;

/**
 * MatcherInterface is an interface for strategies to match a value.
 */
interface MatcherInterface {
  /**
   * Decides whether the rule(s) implemented by the strategy matches the supplied value.
   *
   * @param mixed $subject The subject to be matched
   * @param mixed $object The object to use for the match
   *
   * @return boolean true if the values match, false otherwise
   */
  public function match($subject, $object);
}
