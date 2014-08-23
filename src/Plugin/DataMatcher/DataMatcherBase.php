<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\DataMatcherBase.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Drupal\rules\Matcher\MatcherInterface;

/**
 * Base class for rules conditions.
 */
abstract class DataMatcherBase implements MatcherInterface {

  /**
   * {@inheritdoc}
   */
  public function match($subject, $object) {
    $this->validateArgumentType('subject', $subject, 'string');
    $this->validateArgumentType('object', $object, 'string');

    return $this->doMatch($subject, $object);
  }

  /**
   * Perform the actual matching.
   *
   * @param mixed $subject
   * @param mixed $object
   *
   * @return boolean
   */
  abstract protected function doMatch($subject, $object);


  /**
   * Helper function to validate arguments.
   *
   * @param string $name    The name of the argument
   * @param mixed $argument The argument itself
   * @param string $type    The type of the argument, whether a scalar type or a class' FQDN
   */
  protected function validateArgumentType($name, $argument, $type) {
    if ($type !== gettype($argument)) {
      throw new \InvalidArgumentException('Argument "$' . $name . '" must be a ' . $type . '.');
    }
  }

}
