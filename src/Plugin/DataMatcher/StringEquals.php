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
 *   id = "rules_data_matcher_string_equals",
 *   label = @Translation("A string equality matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class StringEquals extends DataMatcherBase {

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    return $object === $subject;
  }
}
