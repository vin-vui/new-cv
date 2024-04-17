<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 gap-4">
                <FormationCard v-for="formation in formations" :key="formation.id" :formation="formation" @click="showModal(formation)" />
            </div>
        </div>

        <button v-if="!isModalVisible" type="button" @click="showModal(null)" class="btn-add">
            <PlusCircleIcon class="size-6" aria-hidden="true" />
            Add Formation
        </button>

        <FormationModal :formation="selectedFormation" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import FormationCard from '@/Pages/Back/Formations/Card.vue'
import FormationModal from '@/Pages/Back/Formations/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        FormationCard,
        FormationModal,
        PlusCircleIcon
    },

    props: {
        formations: {
            type: Array,
        },
    },

    data() {
        return {
            isModalVisible: false,
            selectedFormation: null,
        }
    },

    methods: {
        showModal(formation) {
            this.isModalVisible = true;
            this.selectedFormation = formation;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
}
</script>
