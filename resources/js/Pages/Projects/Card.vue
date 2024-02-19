<template>
    <div class="bg-white rounded-lg hover:shadow-xl cursor-pointer transition-all duration-200">
        <div class="flex">
            <div class="flex-none rounded-l-lg">
                <img :src="project.logo" :alt="project.title" class="object-contain w-32 h-32 my-auto p-2" />
            </div>
            <div class="w-full p-4 flex flex-col justify-between">
                <div class="flex justify-between">
                    <div class="">
                        <h3 class="text-xl">{{ project.title }}</h3>
                        <div class="flex flex-col">
                            <div class="">
                                <span class="text-sm text-gray-300 w-18 mr-2">Client</span> {{ project.client }}
                            </div>
                            <div class="">
                                <span class="text-sm text-gray-300 w-18 mr-2">Rôle</span> {{ project.job }}
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-1 rounded-md">
                        {{ moment(project.start_date) }} - {{ moment(project.end_date) }}
                    </div>
                    </div>
                </div>
                <div class="flex gap-8 mt-4">
                    <a v-if="project.url" :href="project.url" target="_blank"
                        class="underline text-green-400 text-sm flex items-center">
                        <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4 mr-1" aria-hidden="true" />
                        {{ project.url }}
                    </a>
                    <a v-if="project.github" :href="project.github" target="_blank"
                        class="underline text-green-400 text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                            class="w-4 h-4 mr-1">
                            <path fill="currentColor"
                                d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33c.85 0 1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2Z" />
                        </svg>
                        {{ project.github }}
                    </a>
                </div>
                <div class="text-gray-400 whitespace-pre-wrap mt-4 mb-6">
                    {{ project.description }}
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="text-sm text-gray-300">Compétences</div>
                    <div v-for="skill in project.skills"
                        class="bg-gray-100 border-gray-400 text-gray-800 px-2 py-0.5 rounded-md text-xs flex items-center gap-1">
                        <img :src="skill.img" :alt="skill.title" class="h-3">
                        <div class="">{{ skill.title }}</div>
                    </div>
                </div>
                <div class="flex justify-between gap-4 max-w-full flex-wrap">
                    <img v-if="project.illustration_1" :src="project.illustration_1" :alt="project.title" class="h-48 object-cover rounded-md mt-4" />
                    <img v-if="project.illustration_2" :src="project.illustration_2" :alt="project.title" class="h-48 object-cover rounded-md mt-4" />
                    <img v-if="project.illustration_3" :src="project.illustration_3" :alt="project.title" class="h-48 object-cover rounded-md mt-4" />
                    <img v-if="project.illustration_4" :src="project.illustration_4" :alt="project.title" class="h-48 object-cover rounded-md mt-4" />
                </div>
            </div>
        </div>
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
        project: {
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
