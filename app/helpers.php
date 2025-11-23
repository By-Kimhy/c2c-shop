<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('resolveItemImageUrl')) {
    function resolveItemImageUrl($image) {
        $placeholder = asset('frontend/assets/img/product/p4.jpg');

        if (empty($image)) return $placeholder;

        if (is_array($image)) {
            $first = $image[0] ?? null;
            return resolveItemImageUrl($first);
        }

        if (is_string($image) && in_array(substr(trim($image),0,1), ['[','{'])) {
            $decoded = json_decode($image, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return resolveItemImageUrl($decoded);
            }
        }

        if (is_string($image) && preg_match('#^https?://#i', $image)) {
            return $image;
        }

        $rel = ltrim((string)$image, '/');

        if (Storage::disk('public')->exists($rel)) {
            return asset('storage/'.$rel);
        }

        if (file_exists(public_path($rel))) {
            return asset($rel);
        }

        return $placeholder;
    }
}
