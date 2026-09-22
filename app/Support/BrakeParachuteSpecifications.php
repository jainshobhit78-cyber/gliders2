<?php

namespace App\Support;

use Illuminate\Validation\ValidationException;

final class BrakeParachuteSpecifications
{
    public const HEADINGS = [
        'Design of Canopy',
        'Surface Area of Main Parachute',
        'Span/ Width of Arm',
        'Deployment speed (Normal/Emergency)',
        'Basic Canopy Material',
        'Rigging Line Material',
        'Mass of Parachutes',
        'Life of Parachutes',
    ];

    public static function forAdminSave(string $title, array $specifications): array
    {
        if (! str_contains(strtolower($title), 'brake parachute')) {
            return $specifications;
        }

        if (count($specifications) !== count(self::HEADINGS)) {
            throw ValidationException::withMessages([
                'technical_specs' => 'Brake parachutes require exactly eight specification values in the standard order.',
            ]);
        }

        $specifications = array_values($specifications);
        foreach ($specifications as $index => &$specification) {
            $specification['parameter'] = self::HEADINGS[$index];
        }
        unset($specification);

        return $specifications;
    }
}
