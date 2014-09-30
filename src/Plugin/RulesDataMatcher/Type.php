<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesDataMatcher\Type.
 */

namespace Drupal\rules\Plugin\RulesDataMatcher;

/**
 * Defines a type matcher.
 *
 * @RulesDataMatcher(
 *   id = "rules_data_matcher_type",
 *   label = @Translation("A type matcher."),
 *   subject_type = "string",
 *   object_type = "string"
 * )
 */
class Type extends RulesDataMatcherBase {

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    if (is_object($subject) && $subject instanceof $object) {
      return TRUE;
    }

    if ($object === gettype($subject)) {
      return TRUE;
    }

    return FALSE;
  }

}
