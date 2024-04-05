<template>

    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-40" @close="close">

            <TransitionChild as="template"
                enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-yellow-500/10 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-hidden z-40">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <TransitionChild as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full" enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0" leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto w-screen max-w-5xl">

                                <div class="flex h-full flex-col overflow-y-auto bg-slate-900 pb-6 shadow-xl">
                                    <!-- banner -->
                                    <div class="bg-no-repeat bg-center h-52 bg-fit flex flex-col-reverse"
                                        :style="{ backgroundImage: 'url(' + project.logo + ')' }">
                                        <div
                                            class="flex pl-5 pt-24  bg-gradient-to-b from-transparent to-slate-900 select-none text-4xl font-bold tracking-tight text-slate-200 sm:text-5xl">
                                            {{ project.title }}
                                        </div>
                                    </div>
                                    <!-- informations and description -->
                                    <div class="relative mt-6 flex-1 px-6">
                                        <div class="font-medium leading-snug text-slate-200">
                                            <div class="flex items-baseline gap-1 group">
                                                <a :href="project.external_url" v-if="project.external_url" _target="blank" rel="noopener noreferrer" class="text-lg text-slate-400 group-hover:text-amber-300">
                                                    <span>{{ project.client }}</span>
                                                    <ArrowUpRightIcon class="size-4 inline-block transition-transform group-hover:-translate-y-1 group-hover:translate-x-1 motion-reduce:transition-none translate-y-px" />
                                                </a>
                                                <div v-else class="text-lg text-slate-400">{{ project.client }}</div>
                                                <div class="text-xs text-slate-600"> — Client</div>
                                            </div>
                                            <div>
                                                <span class="text-base text-slate-500">{{ project.job }}</span>
                                                <span class="text-xs text-slate-600"> — Poste</span>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex -ml-3">
                                            <div class="bg-amber-400/30 px-3 py-2 rounded-full text-slate-100 text-xs font-semibold uppercase tracking-wide whitespace-nowrap">
                                                {{ formatDate(project.start_date) }} — {{ formatDate(project.end_date) }}
                                            </div>
                                        </div>
                                        <div class="mt-6 text-base leading-normal text-slate-200">{{ project.description }}</div>
                                        <!-- External Links -->
                                        <div class="mt-6 flex flex-col gap-1 -ml-1">
                                            <div class="flex">
                                                <tippy v-if="project.github" content="GitHub du projet">
                                                    <a :href="project.github" target="_blank"
                                                        aria-label="Voir le projet sur GitHub" rel="noopener noreferrer"
                                                        class="text-slate-400 hover:text-slate-200 flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 w-8"
                                                            aria-hidden="true" focusable="false">
                                                            <path fill="currentColor"
                                                                d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33c.85 0 1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2Z" />
                                                        </svg>
                                                        Lien vers le code source
                                                    </a>
                                                </tippy>
                                            </div>
                                            <div class="flex">
                                                <tippy v-if="project.url" content="Visiter le site web projet">
                                                    <a :href="project.url" target="_blank"
                                                        aria-label="Ouvrir l'URL du projet dans un nouvel onglet" role="link"
                                                        name="openProjectUrl" rel="noopener noreferrer"
                                                        class="text-slate-400 hover:text-slate-200 flex items-center gap-1">
                                                        <ArrowTopRightOnSquareIcon class="h-8 w-8" aria-hidden="true" />
                                                        {{ cleanURL(project.url) }}
                                                    </a>
                                                </tippy>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- illustrations -->
                                    <div class="px-6 mt-8">
                                        <div class="flex -ml-3">
                                            <div class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 text-xs font-semibold uppercase tracking-wide whitespace-nowrap">
                                                Captures d'écran
                                            </div>
                                        </div>
                                        <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-2 mt-4">
                                            <div v-if="project.illustration_1" @click="showFullscreenImage(project.illustration_1)" class="cursor-pointer transition-all duration-200 hover:scale-105">
                                                <img :src="project.illustration_1" :alt="project.title" class="w-full h-full object-contain">
                                            </div>
                                            <div v-if="project.illustration_2" @click="showFullscreenImage(project.illustration_2)" class="cursor-pointer transition-all duration-200 hover:scale-105">
                                                <img :src="project.illustration_2" :alt="project.title" class="w-full h-full object-contain">
                                            </div>
                                            <div v-if="project.illustration_3" @click="showFullscreenImage(project.illustration_3)" class="cursor-pointer transition-all duration-200 hover:scale-105">
                                                <img :src="project.illustration_3" :alt="project.title" class="w-full h-full object-contain">
                                            </div>
                                            <div v-if="project.illustration_4" @click="showFullscreenImage(project.illustration_4)" class="cursor-pointer transition-all duration-200 hover:scale-105">
                                                <img :src="project.illustration_4" :alt="project.title" class="w-full h-full object-contain">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- skills -->
                                    <div class="md:px-6 mt-8">
                                        <div class="flex md:-ml-3 ml-3">
                                            <div class="bg-amber-400/10 px-3 py-2 rounded-full text-slate-100 text-xs font-semibold uppercase tracking-wide whitespace-nowrap">
                                                Stack Technique
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <ul class="list-none p-0 m-0 grid xl:grid-cols-6 sm:grid-cols-4 grid-cols-3">
                                                <li v-for="skill in project.skills" :key="skill.id"
                                                    class="relative group py-5 px-8 cursor-pointer rounded-md transition-all duration-200 motion-reduce:transition-none hover:bg-amber-400/10 hover:shadow-[inset_0_1px_0_0_rgba(252,211,77,0.1)] hover:drop-shadow-lg">
                                                    <a :href="skill.url" target="_blank" rel="noopener noreferrer"
                                                        class="text-slate-400 hover:text-slate-200 flex flex-col items-center gap-3">
                                                        <div class="flex flex-col items-center gap-3">
                                                            <img :src="skill.img" :alt="skill.title + ' compétence'" class="size-12">
                                                            <span class="font-semibold group-hover:text-amber-300">{{ skill.title }}</span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <TransitionRoot as="template" :show="fullscreenImageUrl != null">
                                    <TransitionChild as="template"
                                        enter="ease-out duration-500" enter-from="opacity-0" enter-to="opacity-100"
                                        leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                                        <div v-if="fullscreenImageUrl" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center" @click="closeFullscreenImage">
                                            <img :src="fullscreenImageUrl" class="max-w-full max-h-full">
                                        </div>
                                    </TransitionChild>
                                </TransitionRoot>

                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>

        </Dialog>
    </TransitionRoot>

</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon, ArrowUpRightIcon } from '@heroicons/vue/24/outline'
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/20/solid'

export default {
    name: 'ProjectModal',

    emits: ['close'],

    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        XMarkIcon, ArrowUpRightIcon, ArrowTopRightOnSquareIcon,
    },

    props: {
        project: {
            type: Object,
        },
        show: {
            type: Boolean,
        },
    },

    watch: {
        show(newState) {
            this.open = newState
        }
    },

    data() {
        return {
            fullscreenImageUrl: null,
            open: this.show,
        };
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
        showFullscreenImage(imageUrl) {
            this.fullscreenImageUrl = imageUrl
        },
        closeFullscreenImage() {
            this.fullscreenImageUrl = null
        },
        close() {
            this.$emit('close')
            this.open = false
        },
    },
};
</script>
