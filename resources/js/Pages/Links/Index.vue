<template>
    <AppLayout>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Liens Externes
                </h2>
                <button type="button"  @click="showModal(null)"
                    class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                    Add Link
                </button>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-2 gap-4">
                <LinkCard v-for="link in links" :key="link.id" :link="link" @click="showModal(link)" />
            </div>
        </div>

        <LinkModal :link="selectedLink" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import LinkCard from '@/Pages/Links/Card.vue'
import LinkModal from '@/Pages/Links/Modal.vue'
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
