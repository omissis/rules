<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesExpression\Rule.
 */

namespace Drupal\rules\Plugin\RulesExpression;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\rules\Engine\RulesActionBase;
use Drupal\rules\Engine\RulesActionContainerInterface;
use Drupal\rules\Engine\RulesConditionContainerInterface;
use Drupal\rules\Engine\RulesExpressionActionInterface;
use Drupal\rules\Engine\RulesExpressionBase;
use Drupal\rules\Engine\RulesExpressionConditionInterface;
use Drupal\rules\Engine\RulesState;
use Drupal\rules\Plugin\RulesExpressionPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a rule, executing actions when conditions are met.
 *
 * Actions added to a rule can also be rules themselves, so it is possible to
 * nest several rules into one rule. This is the functionality of so called
 * "rule sets" in Drupal 7.
 *
 * @RulesExpression(
 *   id = "rules_rule",
 *   label = @Translation("A rule, executing actions when conditions are met.")
 * )
 */
class Rule extends RulesActionBase implements RuleInterface, ContainerFactoryPluginInterface {

  use RulesExpressionBase;

  /**
   * List of conditions that must be met before actions are executed.
   *
   * @var \Drupal\rules\Engine\RulesConditionContainerInterface
   */
  protected $conditions;

  /**
   * List of actions that get executed if the conditions are met.
   *
   * @var \Drupal\rules\Engine\RulesActionContainerInterface
   */
  protected $actions;

  /**
   * Constructs a new class instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\rules\Plugin\RulesExpressionPluginManager $expression_manager
   *   The rules expression plugin manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RulesExpressionPluginManager $expression_manager) {
    // @todo: This needs to be removed again and we need to add proper derivative handling for Rules.
    if (isset($configuration['context_definitions'])) {
      $plugin_definition['context'] = $this->createContextDefinitions($configuration['context_definitions']);
    }

    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $configuration += ['conditions' => [], 'actions' => []];
    // Per default the outer condition container of a rule is initialized as
    // conjunction (AND), meaning that all conditions in it must evaluate to
    // TRUE to fire the actions.
    $this->conditions = $expression_manager->createInstance('rules_and', $configuration['conditions']);
    $this->actions = $expression_manager->createInstance('rules_action_set', $configuration['actions']);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.rules_expression')
    );
  }

  /**
   * Converts a context definition configuration array into an object.
   *
   * @todo This should be replaced by some convenience method on the
   *   ContextDefinition class in core?
   *
   * @param array $configuration
   *   The configuration properties for populating the context definition
   *   object.
   *
   * @return \Drupal\Core\Plugin\Context\ContextDefinitionInterface[]
   *   A list of context definitions keyed by the context name.
   */
  protected function createContextDefinitions(array $configuration) {
    $context_definitions = [];
    foreach ($configuration as $context_name => $definition_array) {
      $definition_array += [
        'type' => 'any',
        'label' => NULL,
        'required' => TRUE,
        'multiple' => FALSE,
        'description' => NULL,
      ];
      $context_definitions[$context_name] = new ContextDefinition(
        $definition_array['type'], $definition_array['label'],
        $definition_array['required'], $definition_array['multiple'],
        $definition_array['description']);
    }
    return $context_definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function executeWithState(RulesState $state) {
    // Evaluate the rule's conditions.
    if (!$this->conditions->executeWithState($state)) {
      // Do not run the actions if the conditions are not met.
      return;
    }
    $this->actions->executeWithState($state);
  }

  /**
   * {@inheritdoc}
   */
  public function addCondition(RulesExpressionConditionInterface $condition) {
    $this->conditions->addCondition($condition);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getConditions() {
    return $this->conditions;
  }

  /**
   * {@inheritdoc}
   */
  public function setConditions(RulesConditionContainerInterface $conditions) {
    $this->conditions = $conditions;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function addAction(RulesExpressionActionInterface $action) {
    $this->actions->addAction($action);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getActions() {
    return $this->actions;
  }

  /**
   * {@inheritdoc}
   */
  public function setActions(RulesActionContainerInterface $actions) {
    $this->actions = $actions;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    $configuration = parent::getConfiguration();
    // We need to update the configuration in case actions/conditions have been
    // added or changed.
    $configuration['conditions'] = $this->conditions->getConfiguration();
    $configuration['actions'] = $this->actions->getConfiguration();
    return $configuration;
  }

}
