<template>
    <div>
        <div id="projects" class="sticky top-0 backdrop-blur-sm bg-slate/30 z-40">
            <h4 class="flex items-center py-3 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>projets</span>
            </h4>
        </div>
        <ol class="flex flex-col gap-y-4 group/list">
            <li v-for="project in projects"
                class="relative group p-4 cursor-pointer rounded-md transition-all duration-200 motion-reduce:transition-none hover:bg-amber-400/10 hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] hover:drop-shadow-lg">
                <div class="flex justify-between gap-4">
                    <div class="flex gap-4">
                        <div class="">
                            <img :src="project.logo" :alt="project.title" class="w-full h-60 object-cover rounded-lg">
                        </div>
                        <div class="flex flex-col justify-between">
                            <div>
                                <h3 class="font-medium leading-snug text-slate-200">
                                    <div class="leading-tight text-slate-200 group-hover:text-amber-300 text-base">{{ project.title }}</div>
                                    <div class="text-slate-500">{{ project.client }}</div>
                                    <div class="text-slate-500">{{ project.job }}</div>
                                </h3>
                                <div class="mt-2 text-sm leading-normal">{{ project.description }}</div>
                            </div>
                            <div>
                                <div class="flex flex-wrap gap-2">
                                    <div v-for="skill in project.skills"
                                        class="bg-gray-100 border-gray-400 text-gray-800 px-2 py-0.5 rounded-full text-xs">
                                        <tippy :content="skill.level" class="flex items-center gap-1">
                                            <img :src="skill.img" :alt="skill.title" class="h-3">
                                            <div class="">{{ skill.title }}</div>
                                        </tippy>
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <tippy content="URL du Projet">
                                        <a v-if="project.url" :href="project.url" target="_blank"
                                            class="text-slate-400 hover:text-slate-200">
                                            <ArrowTopRightOnSquareIcon class="size-8" aria-hidden="true" />
                                        </a>
                                    </tippy>
                                    <tippy content="GitHub">
                                        <a v-if="project.github" :href="project.github" target="_blank"
                                            class="text-slate-400 hover:text-slate-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-8">
                                                <path fill="currentColor"
                                                    d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33c.85 0 1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2Z" />
                                            </svg>
                                        </a>
                                    </tippy>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between">
                        <div
                            class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 flex justify-center text-xs font-semibold uppercase tracking-wide">
                            {{ moment(project.start_date) }} — {{ moment(project.end_date) }}
                        </div>
                        <div class="group-hover:text-amber-400 flex items-center self-end">
                            <svg class="mr-4 size-5 group-hover:translate-x-2 transition-all duration-200"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887q.375-.375.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75q0 .375-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1q-.375-.375-.375-.888t.375-.887z" />
                            </svg>
                            découvrir le projet
                        </div>
                    </div>
                </div>
            </li>
        </ol>
    </div>
</template>

<script>
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/20/solid'
import moment from 'moment'

export default {
    components: {
        ArrowTopRightOnSquareIcon,
    },
    props: {
        projects: {
            type: Object,
        },
    },
    methods: {
        moment(date) {
            return moment(date).format('MMMM Y');
        }
    }
}
</script>
