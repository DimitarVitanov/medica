<script setup>
import { ref } from 'vue';

const form = ref({
    name: '',
    email: '',
    phone: '',
    service: '',
    message: '',
});

const services = [
    'Општа Медицина',
    'Гинекологија и Акушерство',
    'Психијатрија',
    'Естетска Медицина',
    'Лабораторија',
    'Медицина на Труд',
];

const submitForm = () => {
    console.log('Form submitted:', form.value);
    // Handle form submission
};
</script>

<template>
    <section class="contact-section py-5">
        <div class="container py-4">
            <div class="row g-5 align-items-center">
                <!-- Left Side - Info -->
                <div class="col-lg-5">
                    <span class="badge bg-purple-light text-purple rounded-pill px-3 py-2 mb-3">Контакт</span>
                    <h2 class="display-6 fw-bold text-dark mb-3">
                        Закажете <span class="text-purple">термин</span>
                    </h2>
                    <p class="text-muted mb-4">
                        Пополнете ја формата и нашиот тим ќе ве контактира во најкраток можен рок за да го закажеме вашиот преглед.
                    </p>
                    
                    <!-- Contact Cards -->
                    <div class="d-flex flex-column gap-3">
                        <!-- Phone -->
                        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 shadow-sm">
                            <div class="icon-box bg-purple-light rounded-3 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Телефон</p>
                                <p class="fw-semibold mb-0">034-360-444</p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 shadow-sm">
                            <div class="icon-box bg-purple-light rounded-3 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Е-пошта</p>
                                <p class="fw-semibold mb-0">info@medica.mk</p>
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 shadow-sm">
                            <div class="icon-box bg-purple-light rounded-3 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Адреса</p>
                                <p class="fw-semibold mb-0">Вањо Китанов бр. 19, Струмица</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-lg-5">
                        <form @submit.prevent="submitForm">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label small fw-semibold">Име и презиме</label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-lg rounded-3 border-light-subtle" 
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Вашето име"
                                        required
                                    >
                                </div>
                                
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-semibold">Е-пошта</label>
                                    <input 
                                        type="email" 
                                        class="form-control form-control-lg rounded-3 border-light-subtle" 
                                        id="email"
                                        v-model="form.email"
                                        placeholder="vashata@email.com"
                                        required
                                    >
                                </div>
                                
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label small fw-semibold">Телефон</label>
                                    <input 
                                        type="tel" 
                                        class="form-control form-control-lg rounded-3 border-light-subtle" 
                                        id="phone"
                                        v-model="form.phone"
                                        placeholder="07X XXX XXX"
                                    >
                                </div>
                                
                                <!-- Service -->
                                <div class="col-md-6">
                                    <label for="service" class="form-label small fw-semibold">Услуга</label>
                                    <select 
                                        class="form-select form-select-lg rounded-3 border-light-subtle" 
                                        id="service"
                                        v-model="form.service"
                                    >
                                        <option value="" disabled selected>Изберете услуга</option>
                                        <option v-for="service in services" :key="service" :value="service">
                                            {{ service }}
                                        </option>
                                    </select>
                                </div>
                                
                                <!-- Message -->
                                <div class="col-12">
                                    <label for="message" class="form-label small fw-semibold">Порака</label>
                                    <textarea 
                                        class="form-control form-control-lg rounded-3 border-light-subtle" 
                                        id="message"
                                        v-model="form.message"
                                        rows="4"
                                        placeholder="Опишете ги вашите симптоми или прашања..."
                                    ></textarea>
                                </div>
                                
                                <!-- Submit -->
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-purple btn-lg rounded-pill px-5 py-3 d-inline-flex align-items-center justify-content-center gap-2">
                                        <span>Испрати барање</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="flex-shrink-0">
                                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.contact-section {
    background: linear-gradient(180deg, #F8F5FC 0%, #FFFFFF 100%);
}

.text-purple {
    color: #6B4C9A !important;
}

.bg-purple-light {
    background-color: rgba(107, 76, 154, 0.1) !important;
}

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(107, 76, 154, 0.3);
}

.form-control:focus,
.form-select:focus {
    border-color: #8B6BAE;
    box-shadow: 0 0 0 0.25rem rgba(107, 76, 154, 0.15);
}

.form-control,
.form-select {
    padding: 0.875rem 1rem;
    background-color: #FAFAFA;
}

.form-control::placeholder {
    color: #aaa;
}

.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    background: #fff;
}

@media (max-width: 991px) {
    .display-6 {
        font-size: 1.75rem;
    }
}

@media (min-width: 768px) {
    .w-md-auto {
        width: auto !important;
    }
}
</style>
