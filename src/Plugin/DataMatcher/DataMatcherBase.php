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

  public function match($subject, $object) {
    $this->validateMatchArgument('subject', $subject, 'string');
    $this->validateMatchArgument('object', $object, 'string');

    return $this->doMatch($subject, $object);
  }

  abstract protected function doMatch($subject, $object);

  protected function validateMatchArgument($name, $argument, $type) {
    if ($type !== gettype($argument)) {
      throw new \InvalidArgumentException('Argument "$' . $name . '" must be a ' . $type . '.');
    }
  }

}
