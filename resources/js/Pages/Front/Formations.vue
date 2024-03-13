<template>
    <section id="formations" aria-labelledby="formations">
        <div class="sticky top-0 backdrop-blur-sm bg-slate/30 z-40">
            <h4 class="flex items-center py-3 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>formations</span>
            </h4>
        </div>
        <ol class="flex flex-col gap-y-4 group/list">
            <li v-for="formation in formations"
                class="relative group p-4 cursor-pointer rounded-md transition-all duration-200 motion-reduce:transition-none hover:bg-amber-400/10 hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] hover:drop-shadow-lg">
                <div class="flex justify-between gap-4">
                    <div class="flex gap-4">
                        <div class="flex flex-col justify-between">
                            <h3 class="font-medium leading-snug text-slate-200">
                                <div class="leading-tight text-slate-200 group-hover:text-amber-300 text-base">{{ formation.title }}</div>
                                <div class="text-slate-500">{{ formation.school }}</div>
                            </h3>
                            <div class="mt-2 text-sm leading-normal whitespace-pre-wrap">{{ formation.description }}</div>
                        </div>
                    </div>
                    <div
                        class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 self-start text-xs font-semibold uppercase tracking-wide">
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
