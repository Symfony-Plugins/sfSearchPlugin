<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Builds a document from a symfony action
 *
 * @package sfSymfonySearch
 * @subpackage Builder
 * @author Carl Vondrick
 */
final class xfSymfonyBuilder implements xfBuilder
{
  /**
   * The title field
   *
   * @var xfField
   */
  private $titleField;

  /**
   * The contents field
   *
   * @var xfField
   */
  private $bodyField;

  /**
   * The route field
   *
   * @var xfField
   */
  private $routeField;

  /**
   * The symfony browser used to fetch content
   *
   * @var xfSymfonyBrowser
   */
  private $browser;
  
  /**
   * Constructor to set initial values
   *
   * @param xfField $titleField The field for the title
   * @param xfField $bodyField The field for the body
   * @param xfField $routeField The field for the route
   * @param xfSymfonyBrowser $browser The symfony browser instance
   */
  public function __construct(xfField $titleField = null, xfField $bodyField = null, xfField $routeField = null, xfSymfonyBrowser $browser = null)
  {
    if (!$titleField)
    {
      $titleField = new xfField('title', xfField::TEXT);
      $titleField->setBoost(2);
      $titleField->registerCallback('trim');
    }

    if (!$bodyField)
    {
      $bodyField = new xfField('body', xfField::TEXT);
      $bodyField->registerCallback('strip_tags');
      $bodyField->registerCallback('trim');
    }

    if (!$routeField)
    {
      $routeField = new xfField('uri', xfField::STORED);
    }

    if (!$browser)
    {
      $browser = new xfSymfonyBrowserSimple;
    }

    $this->titleField   = $titleField;
    $this->bodyField    = $bodyField;
    $this->routeField   = $routeField;
    $this->browser      = $browser;
  }

  /**
   * Sets the title field
   *
   * @param xfField $field The field for the title
   */
  public function setTitleField(xfField $field)
  {
    $this->titleField = $field;
  }

  /**
   * Sets the body field
   *
   * @param xfField $field The field for the body
   */
  public function setBodyField(xfField $field)
  {
    $this->bodyField = $field;
  }

  /**
   * Sets the route field
   *
   * @param xfField $field The field for the route
   */
  public function setRouteField(xfField $field)
  {
    $this->routeField = $field;
  }

  /**
   * Sets the browser
   *
   * @param xfSymfonyBrowser $browser The browser to fetch
   */
  public function setBrowser(xfSymfonyBrowser $browser)
  {
    $this->browser = $browser;
  }

  /**
   * @see xfBuilder
   */
  public function build($input, xfDocument $doc)
  {
    if (!($input instanceof xfSymfonyBrowserRequest))
    {
      throw new xfSymfonyException('Input to ' . __CLASS__ . ' must be an xfSymfonyBrowserRequest');
    }

    $response = $this->browser->fetch($input)->getResponse();

    // use regex because it's going to be faster for our needs

    if (preg_match('/<title.*?>(.*)<\/title>/si', $response, $matches))
    {
      $doc->addField(new xfFieldValue($this->titleField, $matches[1]));
    }

    if (preg_match('/<body.*?>(.*)<\/body>/si', $response, $matches))
    {
      $doc->addField(new xfFieldValue($this->bodyField, $matches[1]));
    }

    $doc->addField(new xfFieldValue($this->routeField, $input->getAsString()));
    
    return $doc;
  }
}
