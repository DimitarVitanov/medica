<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Translation;

class ServiceDescriptionTranslationSeeder extends Seeder
{
    public function run(): void
    {
        // English translations for service descriptions
        $translations = [
            'opsta-medicina' => [
                'short_description' => 'Primary healthcare for the whole family',
                'description' => '',
            ],
            'ginekologija' => [
                'short_description' => 'Complete care for women\'s health',
                'description' => '',
            ],
            'psihijatrija' => [
                'short_description' => 'Mental health and psychological support',
                'description' => 'At PZU Medica we offer you a place of "new understanding" and "new hope" where you and your loved ones will understand what and why is happening to you, how to help yourself and your loved ones get out of crisis, restore balance and continue walking through life without fear.

Mental illness is not destiny, let\'s turn it together into a chance for a new, better beginning. Don\'t let the "illness" control you and your destiny, be the master of your own destiny. You control the illness!

With us, the way out of any mental illness is possible. It depends on you when you decide to take that step! With us there is no belittling, judgments or criticism! With us you will find understanding, guidance and suggestions for possible options - new hope.',
            ],
            'estetska-medicina' => [
                'short_description' => 'Rejuvenation and beauty treatments',
                'description' => 'Beauty and health today are intertwined more than you can imagine. Modern everyday life requires you to always be smiling and cheerful, but obligations don\'t leave you enough time to take care of your body.

External appearance is something that is very important to every person. Being satisfied with your appearance is the foundation of self-confidence and life energy.

Change your life, restore your youthful appearance and the smile on your face! We offer you top and unique treatments with botox, hyaluronic acid and mesotherapy.

A unique and fast process with high expertise will meet all your expectations. We are at the service of your beauty and it will be our pleasure to help you. Your satisfaction is the crown of our success, and we will strive to be the crown of your appearance.',
            ],
            'laboratorija' => [
                'short_description' => 'Biochemical analysis and diagnostics',
                'description' => 'PZU Medica has a specialized biochemical laboratory, unique of its kind in terms of equipment, staff and space in the Southeastern part of Macedonia. Certified through monthly external quality control PREVECAL for biochemistry.',
            ],
            'medicina-na-trud' => [
                'short_description' => 'Health examinations for employment',
                'description' => 'In the Authorized Specialist Clinic for Occupational Medicine, periodic health examinations are performed, assessing their health condition and providing an opinion on their work ability.

Medical certificates are issued for employment; then for travel, residence and schooling abroad; for taking and obtaining a security license and obtaining a caregiver/educator license.',
            ],
            'semejna-medicina' => [
                'short_description' => 'Healthcare for the whole family',
                'description' => 'Family medicine provides comprehensive healthcare for all family members, from children to the elderly. Our specialists offer preventive examinations, chronic disease monitoring, vaccinations and health counseling.',
            ],
        ];

        foreach ($translations as $slug => $fields) {
            $service = Service::where('slug', $slug)->first();
            if ($service) {
                foreach ($fields as $field => $value) {
                    if (!empty($value)) {
                        Translation::updateOrCreate(
                            [
                                'translatable_type' => 'App\Models\Service',
                                'translatable_id' => $service->id,
                                'locale' => 'en',
                                'field' => $field,
                            ],
                            ['value' => $value]
                        );
                        $this->command->info("Added EN {$field} for {$slug}");
                    }
                }
            }
        }

        $this->command->info('Service description translations completed!');
    }
}
