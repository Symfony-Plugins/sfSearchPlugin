<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__) . '/symfony.php';
require_once 'vendor/lime/lime.php';
require_once 'util/sfFinder.class.php';

/**
 * A class to help running tests across sfSearch
 *
 * @package sfSearch
 * @subpackage Test
 * @author Carl Vondrick
 */
class lime_search
{
  /**
   * The root
   *
   * @var string
   */
  private $root;

  /**
   * The output
   *
   * @param lime_output
   */
  private $output;

  /**
   * Constructs a new testing system
   *
   * @param string $root The path to the root of the plugin
   * @param lime_output $output The lime_output helper
   */
  public function __construct($root, lime_output $output)
  {
    $this->root = realpath($root);
    $this->output = $output;
  }

  /**
   * Runs prove testing on the plugin
   */
  public function prove()
  {
    $this->getHarness()->run();
  }

  /**
   * Proves against all plugins
   */
  public function proveAll()
  {
  }

  /**
   * Runs coverage testing on the plugin
   */
  public function coverage($verbose = true)
  {
    $h = $this->getHarness();

    $c = new lime_coverage($h);
    $c->extension = '.php';
    $c->verbose = $verbose;
    $c->base_dir = $this->root . '/lib/';

    $c->register(sfFinder::type('file')->name('*.class.php')->prune('vendor')->in($c->base_dir));
    $c->run();
  }

  /**
   * Gets the harness
   *
   * @returns lime_harnes
   */
  private function getHarness()
  {
    $h = new lime_search_harness($this->output);
    $h->base_dir = $this->root;
    $h->register(sfFinder::type('file')->name('xf*Test.php')->in(glob($h->base_dir . '/test/')));

    return $h;
  }
}

class lime_search_harness extends lime_harness
{
  protected function get_relative_file($file)
  {
    return preg_replace('#^.*/(.*?)/test/(unit|functional)/#', '[$1] $2/', $file);
  }
}

