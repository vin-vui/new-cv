<template>
    <perfect-scrollbar class="bg-slate-900 leading-relaxed text-slate-400 antialiased">

        <div class="light"></div>

        <Head :title="title" />

        <main class="py-8">
            <slot />
        </main>

    </perfect-scrollbar>
</template>

<script setup>

import { Head } from '@inertiajs/vue3';

defineProps({
    title: String,
});

const title = 'Senior Fullstack Developer'

</script>
