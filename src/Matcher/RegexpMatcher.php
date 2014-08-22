<?php

/**
 * @file
 * Contains \Drupal\rules\Matcher\RegexpMatcher.
 */

namespace Drupal\rules\Matcher;

class RegexpMatcher implements MatcherInterface {
    private $flags;
    private $offset;

    public function __construct($flags = 0, $offset = 0) {
        if (!is_int($flags)) {
            throw new \InvalidArgumentException('$flags must be an integer value');
        }

        if (!is_int($offset)) {
            throw new \InvalidArgumentException('$offset must be an integer value');
        }

        $this->flags = $flags;
        $this->offset = $offset;
    }

    public function match($subject, $object) {
      if (!is_string($subject)) {
          throw new \InvalidArgumentException('$subject must be a string');
      }

      if (!is_string($object)) {
          throw new \InvalidArgumentException('$object must be a string');
      }

      $matches = array();

      return 1 === preg_match($object, $subject, $matches, $this->flags, $this->offset);
    }
}
