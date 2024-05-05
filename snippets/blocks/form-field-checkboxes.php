<?php $default = $block->default()->isEmpty()
  ? []
  : array_map('trim', explode(',', $block->default()->value())); ?>

<fieldset>
  <?php snippet('form-legend', [
    'label' => $label,
    'required' => $block->required()->toBool(),
  ]); ?>
  <?php foreach ($block->options()->toStructure() as $option): ?>
  <?php
  $value = $option->value();
  $optionId = "$id/$value";
  $label = $option->text()->isEmpty() ? $value : $option->text();
  $attributes = [
    'name' => $block->name() . '[]',
    'id' => $optionId,
    'value' => $value,
    'checked' => in_array($value, $default) ? true : null,
  ];
  ?>
  <div>
    <input type="checkbox" <?= attr($attributes) ?> />
    <label for="<?= $optionId ?>"><?= $label ?></label>
  </div>
  <?php endforeach; ?>
</fieldset>
