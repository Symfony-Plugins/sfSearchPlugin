<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'util/xfPropelVersion.class.php';

$t = new lime_test(3, new lime_output_color);
$t->is(xfPropelVersion::get(), xfPropelVersion::V12, '::get() detects Propel 1.2 without PropelPDO');
xfPropelVersion::clear();

// trick the PHP optimizer
if (true)
{
  class PropelPDO
  {
  }
}

$t->is(xfPropelVersion::get(), xfPropelVersion::V13, '::get() detects Propel 1.3 with PropelPDO');
xfPropelVersion::set(xfPropelVersion::V12);
$t->is(xfPropelVersion::get(), xfPropelVersion::V12, '::set() forces the Propel version');

