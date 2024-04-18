<template>
    <section id="contact" aria-labelledby="contact">
        <div class="sticky top-0 backdrop-blur-sm bg-slate/30 z-30">
            <h4
                class="flex items-center py-5 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>contact</span>
            </h4>
        </div>
        <a :href="`mailto:${email}`" :title="`Envoyer un email à ${who}`" :aria-label="`Envoyer un email à ${who}`" target="_blank">
            <div class="relative group p-4 cursor-pointer rounded-md transition-all duration-200 motion-reduce:transition-none hover:bg-amber-400/10 hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] hover:drop-shadow-lg hover:!opacity-100 group-hover/list:opacity-50">
                <p class="text-lg font-medium tracking-tight text-slate-200 sm:text-xl">Prêt à transformer tes idées en réalité ?</p>
                <p class="text-slate-500">Contacte-moi dès aujourd'hui et discutons ensemble de ton projet !</p>
                <div class="mt-2 flex flex-col md:flex-row md:items-center gap-1">
                    <div class="text-base font-semibold leading-normal flex items-center gap-1">Tu peux <a :href="`mailto:${email}`" :title="`Envoyer un email à ${who}`" :aria-label="`Envoyer un email à ${who}`" target="_blank" class="text-yellow-500 flex items-center gap-1">m'envoyer un email <PaperAirplaneIcon class="size-5 -rotate-45 group-hover:-translate-y-1 group-hover:translate-x-1 transition-all divide-purple-200" /></a></div>
                    <div class="text-xs text-slate-600"> — parce que soyons honnêtes, personne n'aime les formulaires</div>
                </div>
                <div class="mt-1 flex flex-col md:flex-row md:items-center gap-1">
                    <div class="text-base font-semibold leading-normal flex items-center gap-1">Ou me téléphoner au {{ phone }}</div>
                    <div class="text-xs text-slate-600"> — avec un taux de réponse de 95% environ</div>
                </div>
            </div>
        </a>
    </section>
</template>

<script>
import { PaperAirplaneIcon } from '@heroicons/vue/24/outline';
export default {
    components: {
        PaperAirplaneIcon
    },
    props: {
        email: {
            type: String,
        },
        who: {
            type: String,
        },
        phone: {
            type: String,
        },
    },
}
</script>
