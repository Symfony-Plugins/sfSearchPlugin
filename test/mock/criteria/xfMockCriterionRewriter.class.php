<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once 'criteria/xfCriterionRewriter.interface.php';

class xfMockCriterionRewriterItem
{
  public $type, $options = array();

  public function __construct($type, $options)
  {
    $this->type = $type;
    $this->options = $options;
  }
}

class xfMockCriterionRewriter implements xfCriterionRewriter
{
  public $parse_fail = false;

  public function createField($name, $value)
  {
    $args = array(
      'name' => $name,
      'value' => $value
    );

    return new xfMockCriterionRewriterItem('field', $args);
  }

  public function createBoolean(array $queries)
  {
    return new xfMockCriterionRewriterItem('boolean', $queries);
  }

  public function parse($query, $encoding = 'utf8')
  {
    if ($this->parse_fail)
    {
      throw new Exception('Failed to parse because you told me to');
    }

    $args = array(
      'query' => $query,
      'encoding' => $encoding
    );

    return new xfMockCriterionRewriterItem('parse', $args);
  }

  public function fixParseErrors($query, $encoding = 'utf8')
  {
    $this->parse_fail = false;
  }
}
