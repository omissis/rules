<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Matcher\TypeMatcher.
 */

namespace Drupal\rules\Plugin\Matcher;

/**
 * Defines a type matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_matcher_type",
 *   label = @Translation("A type matcher.")
 * )
 */
class TypeMatcher implements MatcherInterface {

  public function match($subject, $object) {
    if ($object === gettype($subject)) {
      return TRUE;
    }

    if (is_object($subject) && $subject instanceof $object) {
      return TRUE;
    }

    return FALSE;
  }

}
