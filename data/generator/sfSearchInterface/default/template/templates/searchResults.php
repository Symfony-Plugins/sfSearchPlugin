[?php use_helper('I18N') ?]
<h2>[?php echo __('<?php echo $this->get('modes.simple.results.heading', 'Search Results') ?>') ?]</h2>

<ol>
[?php foreach ($results as $result): ?]
  <li><strong>[?php echo $result->getDocument()->getField('title')->getValue() ?]</strong> [?php echo $result->getDocument()->getField('description')->getValue() ?]</li>
[?php endforeach ?]
</ol>

[?php include_partial('simpleControls', array('form' => $form)) ?]
