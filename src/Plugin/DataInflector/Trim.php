<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataInflector\Trim.
 */

namespace Drupal\rules\Plugin\DataInflector;

use Drupal\Core\Plugin\PluginBase;
use Drupal\rules\Inflector\InflectorInterface;

/**
 * Defines a string regular expression matcher.
 *
 * @RulesDataInflector(
 *   id = "rules_data_inflector_trim",
 *   label = @Translation("A string trimming inflector.")
 * )
 */
class Trim extends PluginBase implements InflectorInterface {

  /**
   * @param string $value
   */
  public function inflect($value) {
    return trim($value);
  }

}
