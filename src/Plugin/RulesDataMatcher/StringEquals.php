<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesDataMatcher\StringEquals.
 */

namespace Drupal\rules\Plugin\RulesDataMatcher;

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
class StringEquals extends RulesDataMatcherBase {

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    return $object === $subject;
  }
}
