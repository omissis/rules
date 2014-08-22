<?php

/**
 * @file
 * Contains \Drupal\rules\Matcher\StringEqualsMatcher.
 */

namespace Drupal\rules\Matcher;

class StringEqualsMatcher implements MatcherInterface {
    private $trim;
    private $case_sensitive;

    public function __construct($case_sensitive = FALSE, $trim = FALSE) {
        if (!is_bool($case_sensitive)) {
            throw new \InvalidArgumentException('$case_sensitive must be a boolean value');
        }

        if (!is_bool($trim)) {
            throw new \InvalidArgumentException('$trim must be a boolean value');
        }

        $this->case_sensitive = $case_sensitive;
        $this->trim = $trim;
    }

    public function match($subject, $object) {
        if ($this->trim) {
            $subject = trim($subject);
            $object = trim($object);
        }

        if (!$this->case_sensitive) {
            $subject = strtolower($subject);
            $object = strtolower($object);
        }

        return $object === $subject;
    }
}
