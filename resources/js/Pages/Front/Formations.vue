<template>
    <section id="formations" aria-labelledby="formations">
        <div class="sticky top-0 backdrop-blur-sm bg-slate/30 z-30">
            <h4 class="flex items-center py-5 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>formations</span>
            </h4>
        </div>
        <ol class="flex flex-col gap-y-4 md:group/list">
            <li v-for="formation in formations"
                class="relative group p-4 rounded-md transition-all duration-200 motion-reduce:transition-none md:hover:bg-amber-400/10 md:hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] md:hover:drop-shadow-lg md:hover:!opacity-100 md:group-hover/list:opacity-50">
                <div class="flex justify-between gap-4">
                    <div class="flex gap-4">
                        <div class="flex flex-col justify-between">
                            <h3 class="font-medium leading-snug text-slate-200">
                                <div class="leading-tight text-slate-200 group-hover:text-amber-300 text-lg font-medium tracking-tight sm:text-xl">{{ formation.title }}</div>
                                <div class="text-slate-500">{{ formation.school }}</div>
                            </h3>
                            <div class="mt-2 text-sm leading-normal whitespace-pre-wrap">{{ formation.description }}</div>
                        </div>
                    </div>
                    <div class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 self-start text-xs font-semibold uppercase tracking-wide whitespace-nowrap">
                        {{ formation.year }}
                    </div>
                </div>
            </li>
        </ol>
    </section>
</template>

<script>
export default {
    props: {
        formations: {
            type: Object,
        },
    },
}
</script>
