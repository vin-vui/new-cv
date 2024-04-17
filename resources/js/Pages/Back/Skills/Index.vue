<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-4 gap-4">
                <SkillCard v-for="skill in skills" :key="skill.id" :skill="skill" @click="showModal(skill)" />
            </div>
        </div>

        <button v-if="!isModalVisible" type="button" @click="showModal(null)" class="btn-add">
            <PlusCircleIcon class="size-6" aria-hidden="true" />
            ajouter une compétence
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
