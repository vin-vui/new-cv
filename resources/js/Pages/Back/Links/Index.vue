<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 gap-6">
                <LinkCard v-for="link in links" :key="link.id" :link="link" @click="showModal(link)" />
            </div>
        </div>

        <button type="button" @click="showModal(null)"
            class="fixed z-40 bottom-6 right-6 inline-flex items-center gap-x-2 rounded-full bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
            Add Link
        </button>

        <LinkModal :link="selectedLink" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import LinkCard from '@/Pages/Back/Links/Card.vue'
import LinkModal from '@/Pages/Back/Links/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        LinkCard,
        LinkModal,
        PlusCircleIcon
    },

    props: {
        links: {
            type: Array,
        },
    },

    data() {
        return {
            isModalVisible: false,
            selectedLink: null,
        }
    },

    methods: {
        showModal(link) {
            this.isModalVisible = true;
            this.selectedLink = link;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
}
</script>
