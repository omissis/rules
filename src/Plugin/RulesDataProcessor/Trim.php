<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesDataProcessor\Trim.
 */

namespace Drupal\rules\Plugin\RulesDataProcessor;

use Drupal\Core\Plugin\PluginBase;
use Drupal\rules\Engine\RulesDataProcessorInterface;

/**
 * Defines a string trim processor.
 *
 * @RulesDataProcessor(
 *   id = "rules_data_processor_trim",
 *   label = @Translation("A string trimming processor.")
 * )
 */
class Trim extends PluginBase implements RulesDataProcessorInterface {

  /**
   * @param string $value
   */
  public function process($value) {
    return trim($value);
  }

}
