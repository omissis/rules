<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\StringEquals.
 */

namespace Drupal\rules\Plugin\DataMatcher;

/**
 * Defines a strings equality matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_datamatcher_string_equals",
 *   label = @Translation("A string equality matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class StringEquals extends DataMatcherBase {

  /**
   * @var boolean
   */
  private $case_sensitive;

  /**
   * @var boolean
   */
  private $trim;

  /**
   * @param boolean $case_sensitive
   * @param boolean $trim
   */
  public function __construct($case_sensitive = FALSE, $trim = FALSE) {
    $this->validateArgumentType('case_sensitive', $case_sensitive, 'boolean');
    $this->validateArgumentType('trim', $trim, 'boolean');

    $this->case_sensitive = $case_sensitive;
    $this->trim = $trim;
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    if (TRUE === $this->trim) {
      $subject = trim($subject);
      $object = trim($object);
    }

    if (FALSE === $this->case_sensitive) {
      $subject = strtolower($subject);
      $object = strtolower($object);
    }

    return $object === $subject;
  }
}
