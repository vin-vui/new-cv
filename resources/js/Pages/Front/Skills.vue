<template>
    <div>
        <div id="skills" class="sticky top-0 backdrop-blur-sm bg-slate/30">
            <h4 class="flex items-center py-3 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>compétences</span>
            </h4>
        </div>
        <div class="flex flex-wrap group/list">
            <a :href="skill.url" target="_blank" v-for="skill in skills" :key="skill.id" class="relative group lg:hover:!opacity-100 lg:group-hover/list:opacity-50 py-5 px-8 cursor-pointer hover:bg-amber-400/10 rounded-md transition-all duration-200 motion-reduce:transition-none ">
                <div class="flex flex-col items-center gap-3">
                    <img :src="skill.img" :alt="'logo de '+skill.title" class="size-12">
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
}
</script>
