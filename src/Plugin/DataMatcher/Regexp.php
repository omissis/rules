<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\Regexp.
 */

namespace Drupal\rules\Plugin\DataMatcher;

/**
 * Defines a string regular expression matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_regexp",
 *   label = @Translation("A regular expression matcher.")
 * )
 */
class Regexp extends DataMatcherBase {
  private $flags;
  private $offset;

  public function __construct($flags = 0, $offset = 0) {
    $this->validateArgumentType('flags', $flags, 'integer');
    $this->validateArgumentType('offset', $offset, 'integer');

    $this->flags = $flags;
    $this->offset = $offset;
  }

  public function doMatch($subject, $object) {
    $matches = array();

    return 1 === preg_match($object, $subject, $matches, $this->flags, $this->offset);
  }
}
