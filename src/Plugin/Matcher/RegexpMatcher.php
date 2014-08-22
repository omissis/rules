<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Matcher\RegexpMatcher.
 */

namespace Drupal\rules\Plugin\Matcher;

/**
 * Defines a string regular expression matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_matcher_regexp",
 *   label = @Translation("A regular expression matcher.")
 * )
 */
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
