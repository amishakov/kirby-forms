<?php

use Kirby\Cms\Page;
use Kirby\Content\Field;

class FormEntryPage extends Page {
  public function title(): Field {
    // Submitted forms will have the `form_submitted` field set, but when
    // creating entries manually it might be missing for a short time (we set it
    // in the page create dialog). To prevent an error we have to pass an empty
    // string as fallback.
    $date = new DateTime(
      $this->content()->get('form_submitted')->or('')->value(),
    );
    $format = IntlDateFormatter::RELATIVE_SHORT;
    $language = kirby()->user()->language();
    $displayDate = IntlDateFormatter::formatObject($date, $format, $language);
    return new Field($this, 'title', $displayDate);
  }
}
