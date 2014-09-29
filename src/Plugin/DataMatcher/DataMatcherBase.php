<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\DataMatcherBase.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Drupal\Core\Plugin\PluginBase;
use Drupal\rules\Matcher\MatcherInterface;
use Drupal\rules\Inflector\InflectorInterface;
use Drupal\rules\Plugin\DataInflector\Lowercase;
use Drupal\rules\Plugin\DataInflector\Trim;

/**
 * Base class for rules conditions.
 */
abstract class DataMatcherBase extends PluginBase implements MatcherInterface {

  protected $subjectInflectors = array();
  protected $objectInflectors = array();

  /**
   * {@inheritdoc}
   */
  public function match($subject, $object) {
    return $this->doMatch(
      $this->inflect($subject, $this->subjectInflectors),
      $this->inflect($object, $this->objectInflectors)
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

    $inflector = new Lowercase([], 'rules_data_inflector_lowercase', []);

    $this->addSubjectInflector($inflector);
    $this->addObjectInflector($inflector);
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

    $inflector = new Trim([], 'rules_data_inflector_trim', []);

    $this->addSubjectInflector($inflector);
    $this->addObjectInflector($inflector);
  }

  protected function inflect($value, array $inflectors = array()) {
    array_walk($inflectors, function ($inflector) use (&$value) {
      $value = $inflector->inflect($value);
    });

    return $value;
  }

  protected function addSubjectInflector(InflectorInterface $inflector) {
    $this->subjectInflectors[] = $inflector;
  }

  protected function addObjectInflector(InflectorInterface $inflector) {
    $this->objectInflectors[] = $inflector;
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
