<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\Type.
 */

namespace Drupal\rules\Plugin\DataMatcher;

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
class Type extends DataMatcherBase {

  /**
   * {@inheritdoc}
   */
  public function match($subject, $object) {
    return $this->doMatch($subject, $object);
  }

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
