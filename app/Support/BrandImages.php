<?php

namespace App\Support;

class BrandImages
{
    /**
     * Section photo for a marketing page (one unique image per page).
     */
    public static function sectionForPage(string $page): ?string
    {
        $key = config("brand.page_images.{$page}");

        if (! is_string($key) || $key === '' || $key === 'vertical_images') {
            return null;
        }

        return config("brand.sections.{$key}");
    }

    /**
     * Vertical hero image — only for /verticals.
     */
    public static function vertical(string $slug): ?string
    {
        if (config('brand.page_images.verticals') !== 'vertical_images') {
            return null;
        }

        return config("brand.vertical_images.{$slug}");
    }

    /**
     * @return array<int, string>
     */
    public static function validatePageAssignments(): array
    {
        $errors = [];
        $used = [];

        foreach (config('brand.page_images', []) as $page => $key) {
            if ($key === null || $key === '' || $key === 'vertical_images') {
                continue;
            }

            if (! is_string($key)) {
                $errors[] = "Page “{$page}” must map to a single section key string.";

                continue;
            }

            if (! config("brand.sections.{$key}")) {
                $errors[] = "Page “{$page}” references unknown section key “{$key}”.";

                continue;
            }

            if (isset($used[$key])) {
                $errors[] = "Section “{$key}” is assigned to both “{$used[$key]}” and “{$page}”. Each image may appear on one page only.";
            }

            $used[$key] = $page;
        }

        return $errors;
    }
}
