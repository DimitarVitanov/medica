<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class BlogContentSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'slug' => 'kovid-19',
                'content_mk' => '<p class="lead">Коронавирусна болест (КОВИД-19) е заразна болест предизвикана од новооткриен коронавирус.</p>

<p>Повеќето луѓе заразени со вирусот КОВИД-19 ќе доживеат блага до умерена респираторна болест и ќе закрепнат без да бараат посебен третман. Постарите лица и оние со основни медицински проблеми како кардиоваскуларни болести, дијабетес, хронични респираторни болести и рак имаат поголема веројатност да развијат сериозна болест.</p>

<h4>Превенција</h4>
<p>Најдобар начин да се спречи и забави преносот е да бидете добро информирани за вирусот КОВИД-19, болеста што ја предизвикува и како се шири. Заштитете се себеси и другите од инфекција со миење на рацете или користење на средство за дезинфекција на база на алкохол и не допирање на лицето.</p>

<h4>Како се шири вирусот?</h4>
<p>Вирусот КОВИД-19 се шири првенствено преку капки плунка или исцедок од носот кога заразено лице кашла или кива, затоа е важно да практикувате респираторна етикета (на пример, со кашлање во свиткан лакт).</p>

<h4>Третман</h4>
<p>Во моментов, нема специфични вакцини или третмани за КОВИД-19. Сепак, има многу тековни клинички испитувања кои оценуваат потенцијални третмани.</p>',
                'content_en' => '<p class="lead">Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.</p>

<p>Most people infected with the COVID-19 virus will experience mild to moderate respiratory illness and recover without requiring special treatment. Older people and those with underlying medical problems like cardiovascular disease, diabetes, chronic respiratory disease, and cancer are more likely to develop serious illness.</p>

<h4>Prevention</h4>
<p>The best way to prevent and slow down transmission is to be well informed about the COVID-19 virus, the disease it causes and how it spreads. Protect yourself and others from infection by washing your hands or using an alcohol-based rub frequently and not touching your face.</p>

<h4>How does the virus spread?</h4>
<p>The COVID-19 virus spreads primarily through droplets of saliva or discharge from the nose when an infected person coughs or sneezes, so it\'s important that you also practice respiratory etiquette (for example, by coughing into a flexed elbow).</p>

<h4>Treatment</h4>
<p>At this time, there are no specific vaccines or treatments for COVID-19. However, there are many ongoing clinical trials evaluating potential treatments.</p>',
            ],
            [
                'slug' => 'mezoterapija',
                'content_mk' => '<p class="lead">Мезотерапијата е медицинска техника на уфрлување на различни активни супстанции во слоевите на кожата и поткожното масно ткиво.</p>

<p>Оваа процедура се користи за подмладување на кожата, третман на целулит, опаѓање на коса и многу други естетски и медицински состојби.</p>

<h4>Видови мезотерапија</h4>
<ul>
<li><strong>MESOGLOW</strong> - Третман за сјај и хидратација на кожата</li>
<li><strong>MESOLIFT</strong> - Третман за подмладување и затегнување на кожата</li>
</ul>

<h4>Придобивки</h4>
<p>Мезотерапијата помага во:</p>
<ul>
<li>Подобрување на текстурата и тонот на кожата</li>
<li>Намалување на фини линии и брчки</li>
<li>Хидратација на кожата</li>
<li>Стимулирање на производството на колаген</li>
</ul>

<h4>Цени</h4>
<p><strong>MESOGLOW:</strong> 1900 ден.<br>
<strong>MESOLIFT:</strong> 4800 ден.</p>',
                'content_en' => '<p class="lead">Mesotherapy is a medical technique of injecting various active substances into the layers of the skin and subcutaneous fatty tissue.</p>

<p>This procedure is used for skin rejuvenation, cellulite treatment, hair loss and many other aesthetic and medical conditions.</p>

<h4>Types of Mesotherapy</h4>
<ul>
<li><strong>MESOGLOW</strong> - Treatment for skin glow and hydration</li>
<li><strong>MESOLIFT</strong> - Treatment for skin rejuvenation and tightening</li>
</ul>

<h4>Benefits</h4>
<p>Mesotherapy helps with:</p>
<ul>
<li>Improving skin texture and tone</li>
<li>Reducing fine lines and wrinkles</li>
<li>Skin hydration</li>
<li>Stimulating collagen production</li>
</ul>

<h4>Prices</h4>
<p><strong>MESOGLOW:</strong> 1900 MKD<br>
<strong>MESOLIFT:</strong> 4800 MKD</p>',
            ],
            [
                'slug' => 'dexa-scan',
                'content_mk' => '<p class="lead">DEXA скен (Dual-Energy X-ray Absorptiometry) често се користи за да помогне во дијагностицирање на здравствени проблеми поврзани со коските, како што е остеопорозата.</p>

<p>Ова е брз, безболен и неинвазивен тест кој мери густината на коските и помага да се процени ризикот од фрактури.</p>

<h4>Зошто е важен DEXA скен?</h4>
<p>DEXA скенот е златен стандард за:</p>
<ul>
<li>Дијагностицирање на остеопороза</li>
<li>Проценка на ризик од фрактури</li>
<li>Следење на ефективноста на третманот</li>
<li>Мерење на телесната композиција</li>
</ul>

<h4>Кој треба да направи DEXA скен?</h4>
<p>Препорачуваме DEXA скен за:</p>
<ul>
<li>Жени над 65 години</li>
<li>Мажи над 70 години</li>
<li>Лица со фактори на ризик за остеопороза</li>
<li>Лица кои примаат терапија за остеопороза</li>
</ul>

<h4>Процедура</h4>
<p>Скенирањето трае само 10-15 минути и не бара посебна подготовка. Резултатите се достапни веднаш по прегледот.</p>',
                'content_en' => '<p class="lead">DEXA scan (Dual-Energy X-ray Absorptiometry) is often used to help diagnose health problems related to bones, such as osteoporosis.</p>

<p>This is a quick, painless and non-invasive test that measures bone density and helps assess the risk of fractures.</p>

<h4>Why is DEXA scan important?</h4>
<p>DEXA scan is the gold standard for:</p>
<ul>
<li>Diagnosing osteoporosis</li>
<li>Assessing fracture risk</li>
<li>Monitoring treatment effectiveness</li>
<li>Measuring body composition</li>
</ul>

<h4>Who should get a DEXA scan?</h4>
<p>We recommend DEXA scan for:</p>
<ul>
<li>Women over 65 years old</li>
<li>Men over 70 years old</li>
<li>Individuals with risk factors for osteoporosis</li>
<li>Individuals receiving osteoporosis therapy</li>
</ul>

<h4>Procedure</h4>
<p>The scan takes only 10-15 minutes and requires no special preparation. Results are available immediately after the examination.</p>',
            ],
        ];

        foreach ($blogs as $blogData) {
            $blog = Blog::where('slug', $blogData['slug'])->first();
            
            if ($blog) {
                // Update the main content field (Macedonian)
                $blog->update([
                    'content' => $blogData['content_mk'],
                ]);

                // Add/Update English translation for description field
                Translation::updateOrCreate(
                    [
                        'translatable_type' => Blog::class,
                        'translatable_id' => $blog->id,
                        'locale' => 'en',
                        'field' => 'description',
                    ],
                    [
                        'value' => $blogData['content_en'],
                    ]
                );

                // Also add content translation for consistency
                Translation::updateOrCreate(
                    [
                        'translatable_type' => Blog::class,
                        'translatable_id' => $blog->id,
                        'locale' => 'en',
                        'field' => 'content',
                    ],
                    [
                        'value' => $blogData['content_en'],
                    ]
                );

                $this->command->info("Updated blog: {$blogData['slug']}");
            } else {
                $this->command->warn("Blog not found: {$blogData['slug']}");
            }
        }

        $this->command->info('Blog content seeder completed!');
    }
}
