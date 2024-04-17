<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col-reverse gap-4">
                <ProjectCard v-for="project in projects" :key="project.id" :project="project" @click="showModal(project)" />
            </div>
        </div>

        <button v-if="!isModalVisible" type="button" @click="showModal(null)" class="btn-add">
            <PlusCircleIcon class="size-6" aria-hidden="true" />
            Add Project
        </button>

        <ProjectModal :project="selectedProject" :skills="skills" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProjectCard from '@/Pages/Back/Projects/Card.vue'
import ProjectModal from '@/Pages/Back/Projects/Modal.vue'
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
