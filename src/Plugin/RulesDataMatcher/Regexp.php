<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesDataMatcher\Regexp.
 */

namespace Drupal\rules\Plugin\RulesDataMatcher;

/**
 * Defines a string regular expression matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_data_matcher_regexp",
 *   label = @Translation("A regular expression matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class Regexp extends RulesDataMatcherBase {

  /**
   * @var int
   */
  private $flags;

  /**
   * @var int
   */
  private $offset;

  /**
   *
   * @param int $flags
   */
  public function setFlags($flags) {
    $this->flags = $flags;
  }

  /**
   *
   * @param int $offset
   */
  public function setOffest($offset) {
    $this->offset = $offset;
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    $matches = array();

    return 1 === preg_match($object, $subject, $matches, $this->flags, $this->offset);
  }
}
