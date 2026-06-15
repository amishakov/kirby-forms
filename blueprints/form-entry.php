<?php

use Kirby\Toolkit\Str;
use Kirby\Uuid\Uuid;

return function ($kirby) {
  // This blueprint gets called in the entries tab because of the form entries
  // and export sections. But at this point the url is still the form page, not the form
  // entry.
  // TODO: find a more robust way of handling this.
  $url = $kirby->urls()->current();
  if (
    Str::endsWith($url, '/sections/form_entries') ||
    Str::endsWith($url, '/sections/form_export')
  ) {
    return [];
  }

  /** @var Kirby\Cms\Page */
  $entryPage = KirbyFormBuilder()->pageFromPanelContext();
  if (!$entryPage) {
    return;
  }
  $formPage = $entryPage->parent();
  $uuid = Uuid::generate();

  $blueprint = [
    'options' => [
      'changeSlug' => false,
      'changeTitle' => false,
      'changeTemplate' => false,
      'duplicate' => false,
      'move' => false,
    ],
    'create' => [
      // Title is auto-generated from the form submission date, but since it can't be empty here we have to provide something.
      'title' => $uuid,
      'slug' => $uuid,
      'form_submitted' => date('c'),
    ],
    'type' => 'fields',
    'fields' => [
      'form_export' => [
        'type' => 'form-export',
        'label' => ['*' => 'arnoson.kirby-form-builder.export'],
        'formId' => $formPage?->uuid()->id(),
        'entryId' => $entryPage?->uuid()->id(),
      ],
    ],
  ];

  $formFields = KirbyFormBuilder()->formFields($formPage);
  if (!count($formFields)) {
    $blueprint['fields']['form_info'] = [
      'type' => 'info',
      'label' => 'Data',
      'text' => t('arnoson.kirby-form-builder.no-fields'),
    ];
    return $blueprint;
  }

  foreach ($formFields as $field) {
    $blueprint['fields'][$field['name']] = $field;
  }

  return $blueprint;
};
