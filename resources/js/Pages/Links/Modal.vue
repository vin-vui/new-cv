<template>
    <TransitionRoot as="template">
        <Dialog as="div" class="relative z-10" @close="close">

            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 backdrop-blur-md bg-white/20 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">

                            <DialogTitle as="h3"
                                class=" text-base text-center font-semibold leading-6 text-gray-50 py-2 rounded-lg"
                                :class="{ 'bg-yellow-600': link != null, 'bg-green-600': link == null }">
                                <span v-if="link != null">Update Link</span>
                                <span v-else>Add Link</span>
                            </DialogTitle>

                            <div class="mt-3 sm:mt-5 flex flex-col gap-4">
                                <form @submit.prevent="submit" enctype="multipart/form-data"
                                    class="flex flex-col w-full gap-4">
                                    <input type="hidden" v-model="form.id">
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Title" />
                                        <input type="text" v-model="form.title">
                                        <InputError :message="form.errors.title" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Url Externe" />
                                        <input type="text" v-model="form.url">
                                        <InputError :message="form.errors.url" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="SVG Icon" />
                                        <input type="text" v-model="form.img">
                                        <InputError :message="form.errors.img" />
                                    </div>

                                    <div class="flex items-center justify-between gap-4 mt-4">
                                        <button type="button"
                                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            @click="close">
                                            <ArrowLeftIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                            Go back
                                        </button>
                                        <button :loading="form.processing" :disabled="form.processing"
                                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                            <CheckIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div v-if="link != null" class="flex justify-end mt-4">
                                <VueConfirmationButton class="text-red-600 hover:text-red-800 transition-all duration-200"
                                    :messages="customMessages" v-on:confirmation-success="deleteLink">
                                </VueConfirmationButton>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import VueConfirmationButton from '@/Components/VueConfirmationButton.vue';
import { CheckIcon, ArrowLeftIcon } from '@heroicons/vue/20/solid';

export default {
    name: 'LinkModal',

    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        InputLabel,
        InputError,
        VueConfirmationButton,
        CheckIcon, ArrowLeftIcon
    },

    props: {
        link: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: '',
                img: '',
                url: '',
            }),
            preview: '',
            customMessages: [
                'Delete Link',
                'Are you sure?',
                'Done!'
            ],
        };
    },

    watch: {
        link: {
            handler() {
                this.form.id = this.link?.id;
                this.form.title = this.link?.title;
                this.form.img = this.link?.img;
                this.form.url = this.link?.url;
            },
            deep: true
        }
    },

    methods: {
        submit() {
            this.form.post(route('links.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        deleteLink() {
            this.form.delete(route('links.destroy', this.link), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        close() {
            this.form.clearErrors()
            this.$emit('close')
        },
    },
};
</script>
