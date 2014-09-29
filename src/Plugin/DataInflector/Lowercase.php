<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataInflector\Lowercase.
 */

namespace Drupal\rules\Plugin\DataInflector;

use Drupal\Core\Plugin\PluginBase;
use Drupal\rules\Inflector\InflectorInterface;

/**
 * Defines a string regular expression matcher.
 *
 * @RulesDataInflector(
 *   id = "rules_data_inflector_lowercase",
 *   label = @Translation("A string lowercase inflector.")
 * )
 */
class Lowercase extends PluginBase implements InflectorInterface {

  /**
   * @param string $value
   */
  public function inflect($value) {
    return strtolower($value);
  }

}
