<template>
    <div>
        <div id="skills" class="sticky top-0 backdrop-blur-sm bg-slate/30 z-40">
            <h4 class="flex items-center py-3 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>compétences</span>
            </h4>
        </div>
        <div ref="skillCardsContainer" class="grid xl:grid-cols-8 md:grid-cols-6 sm:grid-cols-4 grid-cols-3 gap-4">
            <a v-for="skill in skills" :href="skill.url" target="_blank" :key="skill.id" class="relative group py-5 px-8 cursor-pointer rounded-md transition-all duration-200 motion-reduce:transition-none hover:bg-amber-400/10 hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] hover:drop-shadow-lg">
                <div class="flex flex-col items-center gap-3">
                    <img :src="skill.img" :alt="'logo de la compétence '+skill.title" class="size-12">
                    <span class="font-semibold group-hover:text-amber-300">{{ skill.title }}</span>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        skills: {
            type: Object,
        },
    },
    // mounted() {
    //     this.$nextTick(() => {
    //         this.adjustCardsWidth();
    //     });
    // },
    // methods: {
    //     adjustCardsWidth() {
    //         let maxWidth = 0;
    //         const cards = this.$refs.skillCardsContainer.querySelectorAll('a');
    //         // Find the maximum width
    //         cards.forEach(card => {
    //             const cardWidth = card.offsetWidth;
    //             if (cardWidth > maxWidth) {
    //                 maxWidth = cardWidth;
    //             }
    //         });
    //         // Apply the maximum width to all elements
    //         cards.forEach(card => {
    //             card.style.width = maxWidth + 'px';
    //         });
    //     }
    // }
}
</script>
