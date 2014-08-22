<?php

/**
 * @file
 * Contains \Drupal\rules\Matcher\TypeMatcher.
 */

namespace Drupal\rules\Matcher;

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
