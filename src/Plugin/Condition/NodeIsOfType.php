<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Condition\NodeIsOfType.
 */

namespace Drupal\rules\Plugin\Condition;

use Drupal\rules\Engine\RulesConditionBase;

/**
 * Provides a 'Node is of type' condition.
 *
 * @Condition(
 *   id = "rules_node_is_of_type",
 *   label = @Translation("Node is of type"),
 *   context = {
 *     "node" = @ContextDefinition("entity:node",
 *       label = @Translation("Node")
 *     ),
 *     "types" = @ContextDefinition("string",
 *       label = @Translation("Content types"),
 *       description = @Translation("Check for the the allowed node types."),
 *       multiple = TRUE
 *     )
 *   }
 * )
 */
class NodeIsOfType extends RulesConditionBase {

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Node is of type');
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    $node = $this->getContextValue('node');
    $types = $this->getContextValue('types');
    return in_array($node->getType(), $types);
  }
}
