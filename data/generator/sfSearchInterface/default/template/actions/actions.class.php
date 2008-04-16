[?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * <?php echo $this->getGeneratedModuleName() ?> actions.
 *
 * @package ##PROJECT_NAME##
 * @subpackage <?php echo $this->getGeneratedModuleName() ?>

 * @author Carl Vondrick
 */
abstract class <?php echo $this->getGeneratedModuleName() ?>Actions extends sfActions
{
  public function executeIndex()
  {
    $this->forward('<?php echo $this->getModuleName() ?>', 'search');
  }

  public function executeSearch()
  {
    $this->form = new <?php echo $this->get('mode.simple.form.class', 'xfSimpleForm') ?>;
    $this->form->getWidgetSchema()->setNameFormat('search[%s]');

    $data = $this->getRequestParameter('search');

    if ($data)
    {
      $this->form->bind($data);

      if ($this->form->isValid())
      {
        $this->criteria = $this->form->getCriterion();
        $this->results = $this->doSearch($this->criteria);

        if (count($this->results))
        {
          $this->setTitle('<?php echo $this->get('mode.simple.results.title', 'Search Results') ?>');

          return 'Results';
        }
        else
        {
          $this->setTitle('<?php echo $this->get('mode.simple.no_results.title', 'No Search Results') ?>');

          return 'NoResults';
        }
      }
    }

    $this->setTitle('<?php echo $this->get('mode.simple.controls.title', 'Search') ?>');
    
    return 'Controls';
  }

  protected function doSearch(xfCriterion $c)
  {
    $index = new <?php echo $this->get('index_class') ?>($this->getContext()->getEventDispatcher());
    $index->setup();

    return $index->find($c);
  }

  protected function setTitle($title)
  {
    $this->getResponse()->setTitle($title);
  }
}
