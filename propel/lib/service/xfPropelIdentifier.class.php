<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Identifies a Propel model.
 *
 * @package sfPropelSearch
 * @subpackage Service
 * @author Carl Vondrick
 */
final class xfPropelIdentifier implements xfIdentifier
{
  /**
   * Flag to indicate that hydration has *not* been done and must be done
   * on the fly.
   *
   * When passed, this identifier will use a result iterator.
   */
  const HYDRATE_INCOMPLETE = 1;

  /**
   * Flag to indicate that hydration *has* already been done.
   */
  const HYDRATE_COMPLETE = 2;

  /**
   * The model we are identifying.
   *
   * @var string
   */
  private $name;

  /**
   * The model peer
   * 
   * @var string
   */
  private $peer;

  /**
   * The model peer select method
   *
   * @var string
   */
  private $selectMethod;

  /**
   * The indication for whether to expect a hydration or not
   *
   * @var int
   */
  private $hydrationTechnique;

  /**
   * The select criteria.
   *
   * @var Criteria
   */
  private $discoverCriteria;

  /**
   * The validator methods.  All of these methods must return true on the object
   * for it to match.
   */
  private $validatorMethods = array();

  /**
   * Constructor to set initial name.
   *
   * @param string $name The model name.
   */
  public function __construct($name)
  {
    $this->name = $name;
    $this->peer = $name . 'Peer';
    $this->setDiscoverCriteria(new Criteria);
    $this->selectMethod = (xfPropelVersion::get() == xfPropelVersion::V13) ? 'doSelectStmt' : 'doSelectRS';
    $this->hydrationTechnique = self::HYDRATE_INCOMPLETE;
  }

  /**
   * Adds a validator method.
   *
   * @param string $method The method
   */
  public function addValidator($method)
  {
    $this->validatorMethods[] = $method;
  }

  /**
   * Sets the discovery criteria.
   *
   * @param Criteria $c The criteria
   */
  public function setDiscoverCriteria(Criteria $c)
  {
    $c = clone $c;

    if ($c->getLimit() == 0)
    {
      $c->setLimit(250);
    }

    $this->discoverCriteria = $c;
  }

  /**
   * Sets the peer select method
   *
   * @param string $method The select method
   * @param int $hydration The hydration technique
   */
  public function setPeerSelectMethod($method, $hydration = 1)
  {
    $this->selectMethod = $method;
    $this->hydrationTechnique = $hydration;
  }

  /**
   * Gets the registered peer select method.
   *
   * @returns string
   */
  public function getPeerSelectMethod()
  {
    return $this->selectMethod;
  }

  /**
   * @see xfIdentifier
   */
  public function getName()
  {
    return 'propel-' . $this->name;
  }

  /**
   * @see xfIdentifier
   */
  public function getGuid($input)
  {
    return 'p' . sha1($this->getName() . '-' . $input->hashCode());
  }

  /**
   * @see xfIdentifier
   */
  public function match($input)
  {
    if (get_class($input) == $this->name) // don't use instanceof 
    {
      foreach ($this->validatorMethods as $method)
      {
        if (!$input->$method())
        {
          return self::MATCH_IGNORED;
        }
      }
      
      return self::MATCH_YES;
    }

    return self::MATCH_NO;
  }

  /**
   * @see xfIdentifier
   */
  public function discover($count)
  {
    $c = clone $this->discoverCriteria;
    $c->setOffset($count * 250);

    $results = call_user_func(array($this->peer, $this->selectMethod), $c);

    if ($this->hydrationTechnique == self::HYDRATE_COMPLETE)
    {
      return $results;
    }
    elseif (xfPropelVersion::get() == xfPropelVersion::V12)
    {
      return new xfPropelResourceIterator($this->name, $results);
    }
    else 
    {
      return new xfPropelPDOIterator($this->name, $results);
    }
  }
}
