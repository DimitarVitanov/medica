<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="guest-layout min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="text-center mb-4">
                        <Link href="/">
                            <img src="/images/logo.png" alt="Медика" class="guest-logo" height="80">
                        </Link>
                    </div>
                    
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.guest-layout {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
}

.guest-logo {
    filter: brightness(0) invert(1);
}
</style>
