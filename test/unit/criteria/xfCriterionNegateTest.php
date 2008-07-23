<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'criteria/xfCriterion.interface.php';
require 'criteria/xfCriterionTerm.class.php';
require 'criteria/xfCriterionDecorator.class.php';
require 'criteria/xfCriterionNegate.class.php';

$t = new lime_test(2, new lime_output_color);
$c = new xfCriterionNegate(new xfCriterionTerm('foo'));

$t->is($c->toString(), 'NOT {foo}', '->toString() works');
$t->todo('->translate()');
