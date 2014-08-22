<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Matcher\MatcherInterface.
 */

namespace Drupal\rules\Plugin\Matcher;

interface MatcherInterface {
    public function match($subject, $object);
}
