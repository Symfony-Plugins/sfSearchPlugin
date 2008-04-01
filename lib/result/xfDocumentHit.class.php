<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A document hit wraps a document to provide extra meta information about the
 * document that the search engine returned.
 *
 * @package sfSearch
 * @subpackage Result
 * @author Carl Vondrick
 */
final class xfDocumentHit
{
  /**
   * The wrapped document.
   *
   * @var xfDocument
   */
  private $document;

  /**
   * The matching criterion.
   *
   * @var xfCriterion
   */
  private $criterion;

  /**
   * Additional options for the document.
   *
   * @var array
   */
  private $options = array();

  /**
   * The registered retorts.
   *
   * @var array
   */
  private $retorts = array();

  /**
   * Constructor to set document and initial options.
   *
   * @param xfDocument $doc The wrapped document
   * @param xfCriterion $criterion The criterion that matched the document
   * @param array $options The initial options
   */
  public function __construct(xfDocument $doc, xfCriterion $criterion, array $options = array())
  {
    $this->document = $doc;
    $this->criterion = $criterion;
    $this->options = array_merge(array('score' => 0), $options);
  }

  /**
   * Runs the retorts to find an appropriate match.
   *
   * @param string $method
   * @param array $args
   * @returns mixed
   */
  public function __call($method, $args)
  {
    foreach ($this->retorts as $retort)
    {
      if ($retort->can($this, $method, $args))
      {
        return $retort->respond($this, $method, $args);
      }
    }

    throw new xfResultException('Retort for ->' . $method . '() not found');
  }

  /**
   * Sets the retorts
   *
   * @param array $retorts The retorts
   */
  public function setRetorts(array $retorts)
  {
    $this->retorts = $retorts;
  }

  /**
   * Gets an option
   *
   * @param string $name The option name
   * @param mixed $default The default response
   * @returns mixed The option name
   */
  public function getOption($name, $default = null)
  {
    if (isset($this->options[$name]))
    {
      return $this->options[$name];
    }

    return $default;
  }

  /**
   * Tests to see if an option exists.
   *
   * @param string $name The option name
   * @returns bool true if it exists, false otherwise
   */
  public function hasOption($name)
  {
    return isset($this->options[$name]);
  }

  /**
   * Sets an option
   *
   * @param string $name The option name
   * @param mixed $value The option value
   */
  public function setOption($name, $value)
  {
    $this->options[$name] = $value;
  }

  /**
   * Gets the wrapped document.
   *
   * @returns xfDocument
   */
  public function getDocument()
  {
    return $this->document;
  }

  /**
   * Gets the matching criterion.
   *
   * @returns xfCriterion
   */
  public function getCriterion()
  {
    return $this->criterion;
  }
}
