<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Translation;

class BlogTranslationSeeder extends Seeder
{
    public function run(): void
    {
        // English translations for blogs
        $translations = [
            'kovid-19' => [
                'title' => 'COVID-19',
                'short_description' => 'Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.',
                'description' => '<p class="lead">Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.</p>

<p>Most people infected with the COVID-19 virus will experience mild to moderate respiratory illness and recover without requiring special treatment. Older people and those with underlying medical problems like cardiovascular disease, diabetes, chronic respiratory disease, and cancer are more likely to develop serious illness.</p>

<h4>Prevention</h4>
<p>The best way to prevent and slow down transmission is to be well informed about the COVID-19 virus, the disease it causes and how it spreads. Protect yourself and others from infection by washing your hands or using an alcohol-based rub frequently and not touching your face.</p>

<h4>How does the virus spread?</h4>
<p>The COVID-19 virus spreads primarily through droplets of saliva or discharge from the nose when an infected person coughs or sneezes, so it\'s important that you also practice respiratory etiquette (for example, by coughing into a flexed elbow).</p>

<h4>Treatment</h4>
<p>At this time, there are no specific vaccines or treatments for COVID-19. However, there are many ongoing clinical trials evaluating potential treatments.</p>',
            ],
            'mezoterapija' => [
                'title' => 'Mesotherapy',
                'short_description' => 'Mesotherapy is a medical technique of injecting various active substances into the skin layers.',
                'description' => '<p class="lead">Mesotherapy is a medical technique of injecting various active substances into the layers of the skin and subcutaneous fatty tissue.</p>

<p>Today it is the most modern medical procedure in contemporary anti-aging medicine. Its goal is to extend our vitality, youth and all other attributes of good appearance.</p>

<h4>What is mesotherapy?</h4>
<p>It is a micro-injection therapy, treatments for refreshing, rejuvenation, hydration, tightening of the skin on the face, neck, décolletage and hands.</p>

<h4>Prices</h4>
<div class="bg-light p-4 rounded-3 mb-4">
    <p class="mb-2"><strong>MESOGLOW</strong> (Vitamins and hyaluronic acid)</p>
    <p class="mb-3">Regular price: <del>2400 MKD</del> <span class="text-success fw-bold">With discount: 1900 MKD</span></p>
    
    <p class="mb-2"><strong>MESOLIFT</strong> (Vitamins+Hyaluronic acid+Rich)</p>
    <p class="mb-0">Regular price: <del>6000 MKD</del> <span class="text-success fw-bold">With discount: 4800 MKD</span></p>
</div>

<h4>Contact Information</h4>
<ul>
    <li><strong>Phone:</strong> 070/214-016 and 034/320-444</li>
    <li><strong>Working hours:</strong> Monday to Friday from 12:00 to 17:00</li>
    <li><strong>Location:</strong> Bratstvo i Edinstvo str. 41 near General Hospital-Strumica</li>
</ul>',
            ],
            'dexa-scan' => [
                'title' => 'DEXA Scan',
                'short_description' => 'Bone density scanning, also known as DEXA, helps determine the risk of bone fractures.',
                'description' => '<p class="lead">Bone density scanning, also known as DEXA, helps determine the risk of bone fractures.</p>

<p>DEXA scan is often used to help diagnose bone-related health problems, such as osteoporosis, or to assess the risk of developing them.</p>

<h4>What is it used for?</h4>
<p>Total body bone density scanning can also be used to measure bone mass, fat and muscle in the body. This type of scanning is routinely used in children, but is only used as part of a research study in adults.</p>

<h4>How is a DEXA scan performed?</h4>
<p>You lie on your back on a flat, open X-ray table. While the scan is being performed, you need to be still so the images are not blurred. The scan will usually be performed by a radiographer, an X-ray imaging specialist.</p>

<p>During the scan, a large scanning frame will pass over your body to measure bone density in the center of the skeleton.</p>

<h4>Procedure</h4>
<p>As the scanning frame slowly moves over your body, a narrow beam of low-dose X-rays will pass through the part of your body being examined. This will usually be your hip and lower spine to check for weak bones (osteoporosis).</p>

<p>However, because bone density varies in different parts of the skeleton, more than one part of your body may be scanned. The forearm may be scanned for certain health problems, such as hyperparathyroidism, or if scanning is not possible on the forearm, scanning is done through the hip or spine.</p>

<h4>How does it work?</h4>
<p>Some of the X-rays passing through your body will be absorbed by tissue, such as fat. An X-ray detector in the scanning frame measures the amount of X-rays that have passed through your body. This information will be used to produce an image of the scanned area.</p>

<p><strong>The scan usually takes 10 to 20 minutes.</strong></p>',
            ],
        ];

        foreach ($translations as $slug => $fields) {
            $blog = Blog::where('slug', $slug)->first();
            if ($blog) {
                foreach ($fields as $field => $value) {
                    if (!empty($value)) {
                        Translation::updateOrCreate(
                            [
                                'translatable_type' => 'App\Models\Blog',
                                'translatable_id' => $blog->id,
                                'locale' => 'en',
                                'field' => $field,
                            ],
                            ['value' => $value]
                        );
                        $this->command->info("Added EN {$field} for blog: {$slug}");
                    }
                }
            }
        }

        $this->command->info('Blog translations completed!');
    }
}
