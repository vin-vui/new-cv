<template>
    <AppLayout>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Projets
                </h2>
                <button type="button"  @click="showModal(null)"
                    class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                    Add Project
                </button>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-1 gap-4">
                <ProjectCard v-for="project in projects" :key="project.id" :project="project" @click="showModal(project)" />
            </div>
        </div>

        <ProjectModal :project="selectedProject" :skills="skills" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProjectCard from '@/Pages/Projects/Card.vue'
import ProjectModal from '@/Pages/Projects/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        ProjectCard,
        ProjectModal,
        PlusCircleIcon
    },

    props: {
        projects: {
            type: Array,
        },
        skills: {
            type: Array,
        },
    },

    data() {
        return {
            isModalVisible: false,
            selectedProject: null,
        }
    },

    methods: {
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
