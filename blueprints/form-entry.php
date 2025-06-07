<?php

return function ($kirby) {
  $url = $kirby->urls()->current();
  $result = preg_match('/\/pages\/([a-zA-Z0-9+-]+)\/?/', $url, $matches);
  if (!$result) {
    return;
  }
  $slug = str_replace('+', '/', $matches[1]);
  /** @var Kirby\Cms\Page */
  $entryPage = page($slug) ?? site()->index()->drafts()->find($slug);
  $formPage = $entryPage->parent();

  $blueprint = [
    'options' => [
      'changeSlug' => false,
      'changeTitle' => false,
      'changeTemplate' => false,
      'duplicate' => false,
      'move' => false,
    ],
    'type' => 'fields',
    'fields' => [
      'form_export' => [
        'type' => 'form-export',
        'label' => ['*' => 'arnoson.kirby-forms.export'],
        'formId' => $formPage?->uuid()->id(),
        'entryId' => $entryPage?->uuid()->id(),
      ],
    ],
  ];

  if (!$formPage) {
    $blueprint['fields']['form_error'] = [
      'type' => 'info',
      'theme' => 'negative',
      'text' => tt('arnoson.kirby-forms.form-not-found', replace: ['name' => $slug]),
    ];
    return $blueprint;
  }

  if (!$entryPage) {
    $blueprint['fields']['form_entry_error'] = [
      'type' => 'info',
      'theme' => 'negative',
      'text' => tt('arnoson.kirby-forms.form-entry-not-found', replace: ['name' => $slug]),
    ];
    return $blueprint;
  }

  $formFields = kirbyForms()->formFields($formPage);
  if (!count($formFields)) {
    $blueprint['fields']['form_info'] = [
      'type' => 'info',
      'label' => 'Data',
      'text' => t('arnoson.kirby-forms.no-fields'),
    ];
    return $blueprint;
  }

  foreach ($formFields as $field) {
    $blueprint['fields'][$field['name']] = $field;
  }

  return $blueprint;
};
