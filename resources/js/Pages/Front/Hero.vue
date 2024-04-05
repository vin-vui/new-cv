<template>
    <div class="flex flex-col items-start pointer-events-none">
        <h1 class="text-4xl font-bold tracking-tight text-slate-200 sm:text-5xl">{{ about.title }}</h1>
        <h2 class="mt-3 text-lg font-medium tracking-tight text-slate-200 sm:text-xl">{{ about.subtitle }}</h2>
        <h3 class="mt-4 max-w-xs leading-normal text-slate-400">{{ about.catch_phrase }}</h3>
    </div>
</template>

<script>
export default {
    props: {
        about: {
            type: Object,
        },
    },
}
</script>
