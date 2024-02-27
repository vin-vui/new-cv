<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 gap-4">
                <FormationCard v-for="formation in formations" :key="formation.id" :formation="formation" @click="showModal(formation)" />
            </div>
        </div>

        <button type="button" @click="showModal(null)"
            class="fixed bottom-6 z-40 right-6 inline-flex items-center gap-x-2 rounded-full bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
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
