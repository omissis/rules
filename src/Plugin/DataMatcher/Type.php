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
 *   id = "rules_datamatcher_type",
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
    $this->validateArgumentType('object', $object, 'string');

    return $this->doMatch($subject, $object);
  }

  /**
   * {@inheritdoc}
   */
  protected function doMatch($subject, $object) {
    if ($object === gettype($subject)) {
      return TRUE;
    }

    if (is_object($subject) && $subject instanceof $object) {
      return TRUE;
    }

    return FALSE;
  }

}
