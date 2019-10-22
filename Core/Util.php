<?php

namespace Core;

class Util
{
  public static function generateSlug($str)
  {
    $slug = filter_var(strtolower($str), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $slug = str_replace(' ', '-', $slug);

    return $slug . '-' . rand(0, 9999);
  }
}
