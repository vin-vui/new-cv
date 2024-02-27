<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-4 gap-4">
                <SkillCard v-for="skill in skills" :key="skill.id" :skill="skill" @click="showModal(skill)" />
            </div>
        </div>

        <button type="button" @click="showModal(null)"
            class="fixed z-40 bottom-6 right-6 inline-flex items-center gap-x-2 rounded-full bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
            Add Skill
        </button>

        <SkillModal :skill="selectedSkill" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import SkillCard from '@/Pages/Back/Skills/Card.vue'
import SkillModal from '@/Pages/Back/Skills/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        SkillCard,
        SkillModal,
        PlusCircleIcon
    },

    props: {
        skills: {
            type: Array,
        },
    },

    data() {
        return {
            isModalVisible: false,
            selectedSkill: null,
        }
    },

    methods: {
        showModal(skill) {
            this.isModalVisible = true;
            this.selectedSkill = skill;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
}
</script>
