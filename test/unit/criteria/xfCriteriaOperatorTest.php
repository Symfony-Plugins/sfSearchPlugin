<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'criteria/xfCriteriaOperator.class.php';
require 'mock/criteria/xfMockCriterion.class.php';

$t = new lime_test(5, new lime_output_color);

$modes = array(
  xfCriteriaOperator::MUST,
  xfCriteriaOperator::SHOULD,
  xfCriteriaOperator::CANNOT
);

foreach ($modes as $mode) {
  try {
    $msg = '__construct() allows mode "' . $mode . '"';
    new xfCriteriaOperator(new xfMockCriterion, $mode);
    $t->pass($msg);
  } catch (Exception $e) {
    $t->fail($msg);
  }
}

$op = new xfCriteriaOperator(new xfMockCriterion, xfCriteriaOperator::CANNOT);
$t->isa_ok($op->getCriterion(), 'xfMockCriterion', '->getCriterion() returns the wrapped criterion');
$t->is($op->getMode(), xfCriteriaOperator::CANNOT, '->getMode() returns the mode');
