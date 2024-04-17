<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 gap-6">
                <LinkCard v-for="link in links" :key="link.id" :link="link" @click="showModal(link)" />
            </div>
        </div>

        <button v-if="!isModalVisible" type="button" @click="showModal(null)" class="btn-add">
            <PlusCircleIcon class="size-6" aria-hidden="true" />
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
