<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { useTranslate } from '@/composables/useTranslate';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

const { t, locale } = useTranslate();
useScrollAnimation();

const props = defineProps({
    socialLinks: Object,
});
</script>

<template>
    <Head>
        <title v-if="locale === 'en'">Privacy Policy - PZU Poliklinika Medica</title>
        <title v-else>Политика на приватност - ПЗУ Поликлиника Медика</title>
    </Head>

    <div class="privacy-page">
        <Navbar :dark="true" :logo-height="80" />

        <!-- Header -->
        <header class="page-header">
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ t('footer.privacyPolicy') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ t('footer.privacyPolicy') }}</h1>
            </div>
        </header>

        <!-- Content -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="bg-white rounded-4 shadow-sm p-4 p-md-5">

                            <!-- Macedonian -->
                            <div v-if="locale !== 'en'">
                                <div class="company-info mb-5 p-4 bg-light rounded-3">
                                    <h5 class="fw-bold text-purple mb-3">Податоци за контролорот</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><strong>Назив:</strong> ПЗУ Поликлиника Медика</li>
                                        <li class="mb-2"><strong>Адреса:</strong> ул. Панче Пешев бр. 3, Струмица</li>
                                        <li class="mb-2"><strong>ЕМБС:</strong> 4833392</li>
                                        <li class="mb-2"><strong>ЕДБ:</strong> 4027994116762</li>
                                        <li class="mb-2"><strong>Е-пошта:</strong> info@medica.mk</li>
                                        <li><strong>Телефон:</strong> 034-360-444</li>
                                    </ul>
                                </div>

                                <h2 class="fw-bold mb-4">Политика на приватност</h2>
                                <p class="text-muted small mb-4"><em>Последно ажурирање: март 2026</em></p>

                                <p>ПЗУ Поликлиника Медика (во натамошниот текст „Медика", „ние" или „нас") ја цени вашата приватност и се обврзува да ги заштити вашите лични податоци во согласност со Законот за заштита на лични податоци на Република Северна Македонија и Општата регулатива за заштита на лични податоци (GDPR).</p>

                                <h4 class="fw-bold mt-5 mb-3">1. Кои податоци ги собираме</h4>
                                <p>Ние може да ги собираме и обработуваме следните категории на лични податоци:</p>
                                <ul class="privacy-list">
                                    <li><strong>Контакт информации:</strong> телефонски број, е-пошта адреса</li>
                                    <li><strong>Податоци од веб-страницата:</strong> е-пошта адреса (при претплата на билтен), податоци од контакт формата, колачиња (cookies) и податоци за користење на страницата</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">2. Цел на обработка на податоците</h4>
                                <p>Вашите лични податоци ги обработуваме за следните цели:</p>
                                <ul class="privacy-list">
                                    <li>Комуникација со пациентите</li>
                                    <li>Одговарање на прашања испратени преку контакт формата</li>
                                    <li>Подобрување на квалитетот на нашите услуги</li>
                                    <li>Исполнување на законски обврски</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">3. Правна основа за обработка</h4>
                                <p>Обработката на вашите лични податоци се заснова на:</p>
                                <ul class="privacy-list">
                                    <li><strong>Согласност:</strong> за претплата на билтен и маркетинг комуникации</li>
                                    <li><strong>Договорна обврска:</strong> за обезбедување на здравствени услуги</li>
                                    <li><strong>Законска обврска:</strong> за водење на медицинска документација и извештаи</li>
                                    <li><strong>Витален интерес:</strong> за заштита на здравјето и животот на пациентот</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">4. Споделување на податоци</h4>
                                <p>Вашите лични податоци не ги споделуваме со трети лица, освен во следните случаи:</p>
                                <ul class="privacy-list">
                                    <li>Со ваша изречна согласност</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">5. Чување на податоците</h4>
                                <p>Вашите лични податоци ги чуваме онолку колку е потребно за исполнување на целите за кои се собрани, или онолку колку е предвидено со закон.</p>

                                <h4 class="fw-bold mt-5 mb-3">6. Вашите права</h4>
                                <p>Согласно законодавството, вие имате право на:</p>
                                <ul class="privacy-list">
                                    <li><strong>Пристап:</strong> да побарате информации за тоа кои ваши лични податоци ги обработуваме</li>
                                    <li><strong>Исправка:</strong> да побарате корекција на неточни или нецелосни податоци</li>
                                    <li><strong>Бришење:</strong> да побарате бришење на вашите лични податоци (каде е законски дозволено)</li>
                                    <li><strong>Ограничување:</strong> да побарате ограничување на обработката на вашите податоци</li>
                                    <li><strong>Приговор:</strong> да поднесете приговор против обработката на вашите податоци</li>
                                    <li><strong>Преносливост:</strong> да побарате пренос на вашите податоци кон друг контролор</li>
                                    <li><strong>Повлекување на согласност:</strong> да ја повлечете вашата согласност во секое време (за претплата на билтен)</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">7. Безбедност на податоците</h4>
                                <p>Ние преземаме соодветни технички и организациски мерки за заштита на вашите лични податоци од неовластен пристап, губење, уништување или промена. Сите податоци се чуваат на заштитени сервери со ограничен пристап.</p>

                                <h4 class="fw-bold mt-5 mb-3">8. Контакт</h4>
                                <p>За сите прашања поврзани со заштитата на вашите лични податоци, можете да нè контактирате на:</p>
                                <div class="contact-box p-4 bg-light rounded-3 mt-3">
                                    <p class="mb-2"><strong>ПЗУ Поликлиника Медика</strong></p>
                                    <p class="mb-2">ул. Панче Пешев бр. 3, Струмица</p>
                                    <p class="mb-2">Телефон: 034-360-444</p>
                                    <p class="mb-0">Е-пошта: pzumedika@medica.mk</p>
                                </div>

                                <h4 class="fw-bold mt-5 mb-3">9. Промени на политиката</h4>
                                <p>Медика го задржува правото да ја ажурира оваа Политика на приватност во секое време. Секоја промена ќе биде објавена на оваа страница со ажуриран датум. Ви препорачуваме периодично да ја проверувате оваа страница за евентуални промени.</p>
                            </div>

                            <!-- English -->
                            <div v-else>
                                <div class="company-info mb-5 p-4 bg-light rounded-3">
                                    <h5 class="fw-bold text-purple mb-3">Data Controller Information</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><strong>Name:</strong> PZU Poliklinika Medica</li>
                                        <li class="mb-2"><strong>Address:</strong> Panche Peshev St. No. 3, Strumica</li>
                                        <li class="mb-2"><strong>EMBS:</strong> 4833392</li>
                                        <li class="mb-2"><strong>EDB (Tax Number):</strong> 4027994116762</li>
                                        <li class="mb-2"><strong>Email:</strong> info@medica.mk</li>
                                        <li><strong>Phone:</strong> 034-360-444</li>
                                    </ul>
                                </div>

                                <h2 class="fw-bold mb-4">Privacy Policy</h2>
                                <p class="text-muted small mb-4"><em>Last updated: March 2026</em></p>

                                <p>PZU Poliklinika Medica (hereinafter "Medica", "we" or "us") values your privacy and is committed to protecting your personal data in accordance with the Law on Personal Data Protection of the Republic of North Macedonia and the General Data Protection Regulation (GDPR).</p>

                                <h4 class="fw-bold mt-5 mb-3">1. What Data We Collect</h4>
                                <p>We may collect and process the following categories of personal data:</p>
                                <ul class="privacy-list">
                                    <li><strong>Contact information:</strong> phone number, email address</li>
                                    <li><strong>Website data:</strong> email address (when subscribing to our newsletter), contact form data, cookies and website usage data</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">2. Purpose of Data Processing</h4>
                                <p>We process your personal data for the following purposes:</p>
                                <ul class="privacy-list">
                                    <li>Providing healthcare services and medical examinations</li>
                                    <li>Responding to inquiries submitted through the contact form</li>
                                    <li>Improving the quality of our services</li>
                                    <li>Fulfilling legal obligations</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">3. Legal Basis for Processing</h4>
                                <p>The processing of your personal data is based on:</p>
                                <ul class="privacy-list">
                                    <li><strong>Consent:</strong> for newsletter subscriptions and marketing communications</li>
                                    <li><strong>Contractual obligation:</strong> for providing healthcare services</li>
                                    <li><strong>Legal obligation:</strong> for maintaining medical records and reports</li>
                                    <li><strong>Vital interest:</strong> for protecting the health and life of the patient</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">4. Data Sharing</h4>
                                <p>We do not share your personal data with third parties, except in the following cases:</p>
                                <ul class="privacy-list">
                                    <li>With your explicit consent</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">5. Data Retention</h4>
                                <p>We retain your personal data for as long as necessary to fulfill the purposes for which it was collected, or as required by law.</p>

                                <h4 class="fw-bold mt-5 mb-3">6. Your Rights</h4>
                                <p>In accordance with the legislation, you have the right to:</p>
                                <ul class="privacy-list">
                                    <li><strong>Access:</strong> request information about which of your personal data we process</li>
                                    <li><strong>Rectification:</strong> request correction of inaccurate or incomplete data</li>
                                    <li><strong>Erasure:</strong> request deletion of your personal data (where legally permitted)</li>
                                    <li><strong>Restriction:</strong> request restriction of processing of your data</li>
                                    <li><strong>Objection:</strong> object to the processing of your data</li>
                                    <li><strong>Portability:</strong> request transfer of your data to another controller</li>
                                    <li><strong>Withdrawal of consent:</strong> withdraw your consent at any time (for newsletter subscriptions)</li>
                                </ul>

                                <h4 class="fw-bold mt-5 mb-3">7. Data Security</h4>
                                <p>We take appropriate technical and organizational measures to protect your personal data from unauthorized access, loss, destruction or alteration. All data is stored on protected servers with restricted access.</p>

                                <h4 class="fw-bold mt-5 mb-3">8. Contact</h4>
                                <p>For all questions related to the protection of your personal data, you can contact us at:</p>
                                <div class="contact-box p-4 bg-light rounded-3 mt-3">
                                    <p class="mb-2"><strong>PZU Poliklinika Medica</strong></p>
                                    <p class="mb-2">Panche Peshev St. No. 3, Strumica</p>
                                    <p class="mb-2">Phone: 034-360-444</p>
                                    <p class="mb-0">Email: pzumedika@medica.mk</p>
                                </div>

                                <h4 class="fw-bold mt-5 mb-3">9. Changes to This Policy</h4>
                                <p>Medica reserves the right to update this Privacy Policy at any time. Any changes will be posted on this page with an updated date. We recommend that you periodically check this page for any changes.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <Footer :socialLinks="socialLinks" />
    </div>
</template>

<style scoped>
.privacy-page {
    min-height: 100vh;
    background: #F5F5F5;
}

.page-header {
    background: linear-gradient(135deg, #9B7BC0 0%, #B89AD4 100%);
    padding-top: 100px;
    padding-bottom: 2rem;
}

.text-purple {
    color: #6B4C9A !important;
}

.privacy-list {
    padding-left: 1.25rem;
    margin-bottom: 1rem;
}

.privacy-list li {
    padding: 0.4rem 0;
    line-height: 1.7;
    color: #444;
}

.privacy-list li strong {
    color: #1e293b;
}

h4 {
    color: #1e293b;
}

p {
    color: #444;
    line-height: 1.8;
}

.company-info {
    border-left: 4px solid #6B4C9A;
}

.contact-box {
    border-left: 4px solid #6B4C9A;
}

@media (max-width: 767px) {
    .display-4 {
        font-size: 2rem;
    }
}
</style>
