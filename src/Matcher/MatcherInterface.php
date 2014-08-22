<?php

/**
 * @file
 * Contains \Drupal\rules\Matcher\MatcherInterface.
 */

namespace Drupal\rules\Matcher;

interface MatcherInterface {
  public function match($subject, $object);
}
