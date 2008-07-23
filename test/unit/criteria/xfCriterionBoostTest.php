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
require 'criteria/xfCriterionDecorator.class.php';
require 'criteria/xfCriterionBoost.class.php';
require 'criteria/xfCriterionTerm.class.php';

$t = new lime_test(5, new lime_output_color);

$term = new xfCriterionTerm('foo');
$c = new xfCriterionBoost($term, 2);

$t->is($c->getCriterion(), $term, '->getCriterion() returns the wrapped criterion');
$t->is($c->getBoost(), 2, '->getBoost() returns the boost');
$c->setBoost(3);
$t->is($c->getBoost(), 3, '->setBoost() changes the boost');
$t->is($c->toString(), 'BOOST {3 ON foo}', '->toString() produces the string representation');

$t->todo('->translate()');
