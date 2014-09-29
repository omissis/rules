<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesDataProcessor\Lowercase.
 */

namespace Drupal\rules\Plugin\RulesDataProcessor;

use Drupal\Core\Plugin\PluginBase;
use Drupal\rules\Engine\RulesDataProcessorInterface;

/**
 * Defines a string lowercase processor.
 *
 * @RulesDataProcessor(
 *   id = "rules_data_processor_lowercase",
 *   label = @Translation("A string lowercase processor.")
 * )
 */
class Lowercase extends PluginBase implements RulesDataProcessorInterface {

  /**
   * @param string $value
   */
  public function process($value) {
    return strtolower($value);
  }

}
