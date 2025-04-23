<?php $attributes = arnoson\KirbyForms\formFieldAttributes(
  $id,
  $block,
  $form
); ?>

<?php snippet('form-label', [
  'id' => $id,
  'label' => $label,
  'required' => $block->required()->toBool(),
]); ?>
<input id="<?= $id ?>" type="checkbox" <?= attr($attributes) ?> />