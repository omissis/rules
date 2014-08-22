<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Matcher\TypeMatcher.
 */

namespace Drupal\rules\Plugin\Matcher;

/**
 * Defines a 'string contains' matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_matcher_string_contains",
 *   label = @Translation("A 'string contains' matcher.")
 * )
 */
class StringContainsMatcher implements MatcherInterface {
    private $offset;
    private $case_sensitive;

    public function __construct($offset = 0, $case_sensitive = TRUE) {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException('$offset must be an integer value');
        }

        if (!is_bool($case_sensitive)) {
            throw new \InvalidArgumentException('$case_sensitive must be an integer value');
        }

        $this->offset = $offset;
        $this->case_sensitive = $case_sensitive;
    }

    public function match($subject, $object) {
      if (!is_string($subject)) {
          throw new \InvalidArgumentException('$subject must be a string');
      }

      if (!is_string($object)) {
          throw new \InvalidArgumentException('$object must be a string');
      }

      if (FALSE === $this->case_sensitive) {
        $subject = strtolower($subject);
        $object = strtolower($object);
      }

      return false !== strpos($subject, $object, 0);
    }
}
