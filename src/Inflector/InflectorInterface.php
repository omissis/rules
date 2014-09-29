<?php

/**
 * @file
 * Contains \Drupal\rules\Inflector\InflectorInterface.
 */

namespace Drupal\rules\Inflector;

/**
 * InflectorInterface defines an interface to inflect data.
 */
interface InflectorInterface {
  /**
   * Perform data inflection.
   *
   * @param mixed $value
   *
   * @return mixed the given value, inflected.
   */
  public function inflect($value);
}
