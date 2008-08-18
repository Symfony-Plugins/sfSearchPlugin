<?php

/**
 * legal actions.
 *
 * @package    functest
 * @subpackage legal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class legalActions extends sfActions
{
  public function executePrivacyPolicy()
  {
    $this->getResponse()->setTitle('Privacy Policy');
  }

  public function executeTermsOfService()
  {
    $this->getResponse()->setTitle('Terms of Service');

    $this->name = $this->getRequestParameter('name');
  }
}
