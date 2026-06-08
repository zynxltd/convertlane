<?php

namespace App\Console\Commands;

use App\Support\BrandImages;
use Illuminate\Console\Command;

class ValidateBrandImagesCommand extends Command
{
    protected $signature = 'brand:validate-images';

    protected $description = 'Ensure each section photo is assigned to exactly one page';

    public function handle(): int
    {
        $errors = BrandImages::validatePageAssignments();

        if ($errors === []) {
            $this->info('Brand image assignments are valid (one section image per page).');

            return self::SUCCESS;
        }

        foreach ($errors as $error) {
            $this->error($error);
        }

        return self::FAILURE;
    }
}
