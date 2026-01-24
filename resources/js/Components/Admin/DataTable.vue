<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    columns: Array,
    emptyText: {
        type: String,
        default: 'Нема податоци'
    }
});
</script>

<template>
    <div class="data-table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th v-for="col in columns" :key="col.key" :class="col.class">
                        {{ col.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <slot />
                <tr v-if="!$slots.default" class="empty-row">
                    <td :colspan="columns.length">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                            <p>{{ emptyText }}</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.data-table-wrapper {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f9fafb;
}

.data-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e5e7eb;
}

.data-table th.text-end {
    text-align: right;
}

.data-table th.text-center {
    text-align: center;
}

.data-table :deep(td) {
    padding: 1rem 1.25rem;
    font-size: 0.9rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.data-table :deep(tr:last-child td) {
    border-bottom: none;
}

.data-table :deep(tr:hover td) {
    background: #f9fafb;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    color: #9ca3af;
}

.empty-state svg {
    margin-bottom: 1rem;
    opacity: 0.4;
}

.empty-state p {
    margin: 0;
    font-size: 0.9rem;
}
</style>
