<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabAnalysisCategory;
use App\Models\LabAnalysis;
use Illuminate\Support\Str;

class LabAnalysisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Витамини',
                'name_en' => 'Vitamins',
                'analyses' => [
                    ['name' => 'Витамин Д', 'name_en' => 'Vitamin D', 'price' => 1200],
                ],
            ],
            [
                'name' => 'Глуциден статус',
                'name_en' => 'Glucose Status',
                'analyses' => [
                    ['name' => 'Глукоза во серум', 'name_en' => 'Serum Glucose', 'price' => 100],
                    ['name' => 'Глукоза толеранс тест', 'name_en' => 'Glucose Tolerance Test', 'price' => 350],
                    ['name' => 'Гликозилиран хемоглобин (HbA1c)', 'name_en' => 'Glycosylated Hemoglobin (HbA1c)', 'price' => 500],
                ],
            ],
            [
                'name' => 'Деградациони продукти',
                'name_en' => 'Degradation Products',
                'analyses' => [
                    ['name' => 'Уреа во серум', 'name_en' => 'Serum Urea', 'price' => 100],
                    ['name' => 'Креатинин во серум', 'name_en' => 'Serum Creatinine', 'price' => 100],
                    ['name' => 'Мочна киселина во серум', 'name_en' => 'Serum Uric Acid', 'price' => 150],
                    ['name' => 'Директен билирубин', 'name_en' => 'Direct Bilirubin', 'price' => 100],
                    ['name' => 'Индиректен билирубин', 'name_en' => 'Indirect Bilirubin', 'price' => 100],
                    ['name' => 'Вкупен билирубин', 'name_en' => 'Total Bilirubin', 'price' => 100],
                ],
            ],
            [
                'name' => 'Електролитен статус во серум',
                'name_en' => 'Serum Electrolyte Status',
                'analyses' => [
                    ['name' => 'Натриум', 'name_en' => 'Sodium', 'price' => 100],
                    ['name' => 'Калиум', 'name_en' => 'Potassium', 'price' => 100],
                    ['name' => 'Калциум', 'name_en' => 'Calcium', 'price' => 100],
                    ['name' => 'Јонизиран калциум', 'name_en' => 'Ionized Calcium', 'price' => 100],
                    ['name' => 'Магнезиум', 'name_en' => 'Magnesium', 'price' => 100],
                    ['name' => 'Хлориди', 'name_en' => 'Chlorides', 'price' => 100],
                    ['name' => 'Неоргански фосфати', 'name_en' => 'Inorganic Phosphates', 'price' => 100],
                    ['name' => 'Железо (серум)', 'name_en' => 'Iron (Serum)', 'price' => 100],
                ],
            ],
            [
                'name' => 'Ензимски статус',
                'name_en' => 'Enzyme Status',
                'analyses' => [
                    ['name' => 'Гама глутамил трансфераза (GGT)', 'name_en' => 'Gamma Glutamyl Transferase (GGT)', 'price' => 150],
                    ['name' => 'ALT (GPT)', 'name_en' => 'ALT (GPT)', 'price' => 100],
                    ['name' => 'AST (GOT)', 'name_en' => 'AST (GOT)', 'price' => 100],
                    ['name' => 'Алкална фосфатаза', 'name_en' => 'Alkaline Phosphatase', 'price' => 150],
                    ['name' => 'Кисела фосфатаза', 'name_en' => 'Acid Phosphatase', 'price' => 150],
                    ['name' => 'α-Амилаза во серум', 'name_en' => 'α-Amylase in Serum', 'price' => 150],
                    ['name' => 'Креатин киназа (CK)', 'name_en' => 'Creatine Kinase (CK)', 'price' => 150],
                    ['name' => 'Лактат дехидрогеназа (LDH)', 'name_en' => 'Lactate Dehydrogenase (LDH)', 'price' => 150],
                ],
            ],
            [
                'name' => 'Липиден статус',
                'name_en' => 'Lipid Status',
                'analyses' => [
                    ['name' => 'Холестерол', 'name_en' => 'Cholesterol', 'price' => 100],
                    ['name' => 'Триглицериди', 'name_en' => 'Triglycerides', 'price' => 100],
                    ['name' => 'HDL холестерол', 'name_en' => 'HDL Cholesterol', 'price' => 100],
                    ['name' => 'LDL холестерол', 'name_en' => 'LDL Cholesterol', 'price' => 100],
                ],
            ],
            [
                'name' => 'Протеински статус',
                'name_en' => 'Protein Status',
                'analyses' => [
                    ['name' => 'Вкупни протеини', 'name_en' => 'Total Proteins', 'price' => 100],
                    ['name' => 'Албумини', 'name_en' => 'Albumin', 'price' => 100],
                    ['name' => 'Глобулини', 'name_en' => 'Globulins', 'price' => 100],
                ],
            ],
            [
                'name' => 'Имунолошки статус',
                'name_en' => 'Immunological Status',
                'analyses' => [
                    ['name' => 'CRP', 'name_en' => 'CRP', 'price' => 200],
                    ['name' => 'RF', 'name_en' => 'RF', 'price' => 200],
                    ['name' => 'ASO', 'name_en' => 'ASO', 'price' => 200],
                ],
            ],
            [
                'name' => 'Инфективни маркери',
                'name_en' => 'Infectious Markers',
                'analyses' => [
                    ['name' => 'HIV 1/2', 'name_en' => 'HIV 1/2', 'price' => 500],
                    ['name' => 'HCV', 'name_en' => 'HCV', 'price' => 200],
                    ['name' => 'HAV IgM rapid test', 'name_en' => 'HAV IgM Rapid Test', 'price' => 300],
                    ['name' => 'Syphilis Rapid Test', 'name_en' => 'Syphilis Rapid Test', 'price' => 500],
                    ['name' => 'HBs Ag', 'name_en' => 'HBs Ag', 'price' => 200],
                ],
            ],
            [
                'name' => 'Ковид антитела',
                'name_en' => 'COVID Antibodies',
                'analyses' => [
                    ['name' => 'SARS-CoV-2 IgG II', 'name_en' => 'SARS-CoV-2 IgG II', 'price' => 1000],
                ],
            ],
            [
                'name' => 'Крвна слика и диференцијална крвна слика',
                'name_en' => 'Complete Blood Count and Differential',
                'analyses' => [
                    ['name' => 'Крвна слика и диференцијална крвна слика', 'name_en' => 'Complete Blood Count and Differential', 'price' => 300],
                ],
            ],
            [
                'name' => 'Реуматолошки анализи',
                'name_en' => 'Rheumatological Analyses',
                'analyses' => [
                    ['name' => 'CRP', 'name_en' => 'CRP', 'price' => 200],
                    ['name' => 'Reuma фактор (RF)', 'name_en' => 'Rheumatoid Factor (RF)', 'price' => 200],
                    ['name' => 'Алкална фосфатаза', 'name_en' => 'Alkaline Phosphatase', 'price' => 150],
                ],
            ],
            [
                'name' => 'Седиментација на еритроцити',
                'name_en' => 'Erythrocyte Sedimentation',
                'analyses' => [
                    ['name' => 'Седиментација на еритроцити', 'name_en' => 'Erythrocyte Sedimentation Rate', 'price' => 100],
                ],
            ],
            [
                'name' => 'Серумски тумурски маркери',
                'name_en' => 'Serum Tumor Markers',
                'analyses' => [
                    ['name' => 'Helicobacter pylori', 'name_en' => 'Helicobacter pylori', 'price' => 600],
                    ['name' => 'PSA', 'name_en' => 'PSA', 'price' => 500],
                    ['name' => 'Фекално окултно крварење', 'name_en' => 'Fecal Occult Blood', 'price' => 500],
                ],
            ],
            [
                'name' => 'Тест за бременост',
                'name_en' => 'Pregnancy Test',
                'analyses' => [
                    ['name' => 'Тест за бременост', 'name_en' => 'Pregnancy Test', 'price' => 600],
                ],
            ],
            [
                'name' => 'Хемостаза',
                'name_en' => 'Hemostasis',
                'analyses' => [
                    ['name' => 'Д-димери', 'name_en' => 'D-Dimers', 'price' => 1000],
                ],
            ],
            [
                'name' => 'Хормонален статус',
                'name_en' => 'Hormonal Status',
                'analyses' => [
                    ['name' => 'TSH', 'name_en' => 'TSH', 'price' => 500],
                    ['name' => 'FT4', 'name_en' => 'FT4', 'price' => 500],
                    ['name' => 'FSH', 'name_en' => 'FSH', 'price' => 600],
                    ['name' => 'LH', 'name_en' => 'LH', 'price' => 600],
                    ['name' => 'Прогестерон', 'name_en' => 'Progesterone', 'price' => 600],
                    ['name' => 'Тестостерон', 'name_en' => 'Testosterone', 'price' => 1200],
                    ['name' => 'E2 (естроген)', 'name_en' => 'E2 (Estrogen)', 'price' => 600],
                    ['name' => 'Пролактин', 'name_en' => 'Prolactin', 'price' => 600],
                ],
            ],
        ];

        $categoryOrder = 0;
        foreach ($categories as $categoryData) {
            $category = LabAnalysisCategory::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'order' => $categoryOrder++,
                'is_active' => true,
            ]);

            // Add English translation
            $category->translations()->create([
                'locale' => 'en',
                'field' => 'name',
                'value' => $categoryData['name_en'],
            ]);

            $analysisOrder = 0;
            foreach ($categoryData['analyses'] as $analysisData) {
                $analysis = LabAnalysis::create([
                    'category_id' => $category->id,
                    'name' => $analysisData['name'],
                    'price' => $analysisData['price'],
                    'order' => $analysisOrder++,
                    'is_active' => true,
                ]);

                // Add English translation
                $analysis->translations()->create([
                    'locale' => 'en',
                    'field' => 'name',
                    'value' => $analysisData['name_en'],
                ]);
            }
        }
    }
}
