<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/suite.php';

$h = new lime_search_harness(new lime_output_color);
$h->base_dir = realpath(dirname(__FILE__) . '/../');
$h->register(sfFinder::type('file')->name('xf*Test.php')->in(glob($h->base_dir . '/*/test/')));
$h->run();
