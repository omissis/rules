<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\Type.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Drupal\rules\Matcher\MatcherInterface;

/**
 * Defines a type matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_type",
 *   label = @Translation("A type matcher.")
 * )
 */
class Type implements MatcherInterface {

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
