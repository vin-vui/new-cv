<template>

    <section id="projects" aria-labelledby="projects">
        <div class="sticky top-0 backdrop-blur-sm bg-slate/30 z-30">
            <h4
                class="flex items-center py-5 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>projets</span>
            </h4>
        </div>
        <ol class="flex flex-col gap-y-8 group/list">
            <li v-for="project in projects" @click="showModal(project)"
                class="relative group p-4 cursor-pointer rounded-md transition-all duration-200 motion-reduce:transition-none hover:bg-amber-400/10 hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] hover:drop-shadow-lg hover:!opacity-100 group-hover/list:opacity-50">
                <div class="flex gap-4 items-start md:flex-row flex-col">
                    <!-- img -->
                    <div class="md:basis-1/4">
                        <img :src="project.logo" :alt="project.title" class="w-full h-full object-contain">
                    </div>
                    <!-- content -->
                    <div class="md:basis-3/4 flex flex-col">
                        <!-- header -->
                        <div class="flex justify-between md:flex-row flex-col">
                            <!-- main informations -->
                            <div class="">
                                <div class="font-medium leading-snug text-slate-200">
                                    <h3
                                        class="leading-tight text-slate-200 group-hover:text-amber-400/80 text-lg font-medium tracking-tight sm:text-xl">
                                        {{ project.title }}</h3>
                                    <div>
                                        <span class="text-slate-500">{{ project.client }}</span>
                                        <span class="text-xs text-slate-600"> — Client</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500">{{ project.job }}</span>
                                        <span class="text-xs text-slate-600"> — Poste</span>
                                    </div>
                                </div>
                            </div>
                            <!-- dates -->
                            <div class="flex md:block mt-4 mb-2 -ml-2 md:my-0 md:-ml-20">
                                <div v-if="project.end_date !== null"
                                    class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 text-xs font-semibold uppercase tracking-wide whitespace-nowrap">
                                    {{ formatDate(project.start_date) }} — {{ formatDate(project.end_date) }}
                                </div>
                                <div v-if="project.end_date === null"
                                    class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 text-xs font-semibold uppercase tracking-wide whitespace-nowrap">
                                    {{ formatDate(project.start_date) }} — aujourd'hui
                                </div>
                            </div>
                        </div>
                        <!-- description -->
                        <div class="mt-2 text-sm leading-normal">{{ project.description }}</div>
                        <!-- skills -->
                        <div class="my-6 flex flex-wrap gap-y-2 gap-x-1">
                            <div v-for="skill in project.skills"
                                class="bg-amber-400/10 group-hover:bg-amber-400/30 px-2 py-0.5 rounded-full text-xs">
                                <div class="flex items-center gap-1">
                                    <img :src="skill.img" :alt="skill.title" class="h-3">
                                    <div class="group-hover:text-slate-300">{{ skill.title }}</div>
                                </div>
                            </div>
                        </div>
                        <!-- links -->
                        <div class="flex justify-between md:flex-row flex-col">
                            <!-- external links -->
                            <div class="flex gap-2">
                                <tippy v-if="project.github" content="GitHub du projet">
                                    <a :href="project.github" target="_blank" aria-label="Voir le projet sur GitHub"
                                        rel="noopener noreferrer" class="text-slate-400 hover:text-slate-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6"
                                            aria-hidden="true" focusable="false">
                                            <path fill="currentColor"
                                                d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33c.85 0 1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2Z" />
                                        </svg>
                                    </a>
                                </tippy>
                                <tippy v-if="project.url" content="Visiter le site web projet">
                                    <a :href="project.url" target="_blank"
                                        aria-label="Ouvrir l'URL du projet dans un nouvel onglet" role="link"
                                        name="openProjectUrl" rel="noopener noreferrer"
                                        class="text-slate-400 hover:text-slate-200 flex items-center gap-1">
                                        <ArrowTopRightOnSquareIcon class="size-6" aria-hidden="true" />
                                        {{ cleanURL(project.url) }}
                                    </a>
                                </tippy>
                            </div>
                            <!-- discover project -->
                            <div class="group-hover:text-amber-400/80 flex items-center self-end whitespace-nowrap">
                                <svg class="mr-4 size-5 group-hover:translate-x-2 transition-all duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887q.375-.375.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75q0 .375-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1q-.375-.375-.375-.888t.375-.887z" />
                                </svg>
                                découvrir le projet
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ol>
    </section>

    <ProjectModal :project="selectedProject" :show="isModalVisible" @close="closeModal" />

</template>

<script>
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/20/solid'
import ProjectModal from '@/Pages/Front/ProjectModal.vue'

export default {
    components: {
        ArrowTopRightOnSquareIcon,
        ProjectModal,
    },

    props: {
        projects: {
            type: Object,
        },
    },

    data() {
        return {
            isModalVisible: false,
            selectedProject: null,
        }
    },

    methods: {
        formatDate(date) {
            const lang = 'fr-FR'
            const options = { year: 'numeric', month: 'long' };
            const dateFormatter = new Intl.DateTimeFormat(lang, options);
            return dateFormatter.format(new Date(date));
        },
        cleanURL(url) {
            return url.replace(/^https?:\/\//, '').replace(/\/$/, '');
        },
        showModal(project) {
            this.isModalVisible = true;
            this.selectedProject = project;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
}
</script>
