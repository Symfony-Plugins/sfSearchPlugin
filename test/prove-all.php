<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__) . '/bootstrap/unit.php';
require_once 'util/sfFinder.class.php';

class lime_search extends lime_harness
{
  protected function get_relative_file($file)
  {
    return preg_replace('#^.*/(.*?)Plugin/test/(unit|functional)/#', '[$1] $2/', $file);
  }
}

$h = new lime_search(new lime_output_color);
$h->base_dir = realpath(dirname(__FILE__) . '/../..');
$h->register(sfFinder::type('file')->name('xf*Test.php')->in(glob($h->base_dir . '/*/test/')));
$h->run();
