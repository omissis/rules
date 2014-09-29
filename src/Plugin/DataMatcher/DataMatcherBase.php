<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\DataMatcherBase.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Drupal\Core\Plugin\PluginBase;
use Drupal\rules\Matcher\MatcherInterface;
use Drupal\rules\Engine\RulesDataProcessorInterface;
use Drupal\rules\Plugin\RulesDataProcessor\Lowercase;
use Drupal\rules\Plugin\RulesDataProcessor\Trim;

/**
 * Base class for rules conditions.
 */
abstract class DataMatcherBase extends PluginBase implements MatcherInterface {

  protected $subjectProcessors = array();
  protected $objectProcessors = array();

  /**
   * {@inheritdoc}
   */
  public function match($subject, $object) {
    return $this->doMatch(
      $this->process($subject, $this->subjectProcessors),
      $this->process($object, $this->objectProcessors)
    );
  }

  /**
   * Set the flag for case sensitive.
   *
   * @todo inject Lowercase Plugin
   * @todo move this to a StringMatcherTrait
   *
   * @param boolean $caseSensitive
   */
  public function setCaseSensitive($caseSensitive) {
    if (TRUE === $caseSensitive) {
      return;
    }

    $processor = new Lowercase([], 'rules_data_processor_lowercase', []);

    $this->addSubjectProcessor($processor);
    $this->addObjectProcessor($processor);
  }

  /**
   * Set the flag for trim.
   *
   * @todo inject Lowercase Plugin
   * @todo move this to a StringMatcherTrait
   *
   * @param boolean $trimmed
   */
  public function setTrimmed($trimmed) {
    if (FALSE === $trimmed) {
      return;
    }

    $processor = new Trim([], 'rules_data_processor_trim', []);

    $this->addSubjectProcessor($processor);
    $this->addObjectProcessor($processor);
  }

  protected function process($value, array $processors = array()) {
    array_walk($processors, function ($processor) use (&$value) {
      $value = $processor->process($value);
    });

    return $value;
  }

  protected function addSubjectProcessor(RulesDataProcessorInterface $processor) {
    $this->subjectProcessors[] = $processor;
  }

  protected function addObjectProcessor(RulesDataProcessorInterface $processor) {
    $this->objectProcessors[] = $processor;
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

}
