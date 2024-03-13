<template>
    <div class="light z-50"></div>

    <div class="bg-slate-900 leading-relaxed text-slate-400 antialiased">

        <Head :title="title" />

        <main class="py-8">
            <slot />
        </main>

    </div>
</template>

<script setup>

import { Head } from '@inertiajs/vue3';

defineProps({
    title: String,
});

const title = 'Senior Fullstack Developer'

</script>
