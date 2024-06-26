<template>
    <TransitionRoot as="template">
        <Dialog as="div" class="relative z-50" @close="close">

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
                            class="relative rounded-3xl transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl ">

                            <DialogTitle as="h3"
                                :class="{ 'modal-title-update': link != null, 'modal-title-create': link == null }">
                                <span v-if="link != null">mise à jour d'un lien</span>
                                <span v-else>ajout d'un lien</span>
                            </DialogTitle>

                            <div class="flex flex-col gap-4 p-4">
                                <div class="flex flex-col w-full gap-4">
                                    <input type="hidden" v-model="form.id">
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Titre" />
                                        <input type="text" v-model="form.title" class="input-primary">
                                        <InputError :message="form.errors.title" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Url Externe" />
                                        <input type="text" v-model="form.url" class="input-primary">
                                        <InputError :message="form.errors.url" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Icône en SVG" />
                                        <input type="text" v-model="form.img" class="input-primary">
                                        <InputError :message="form.errors.img" />
                                    </div>

                                    <div class="flex items-center justify-between gap-4 mt-4">
                                        <button type="button" class="btn-go-back" @click="close">
                                            <ArrowLeftIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                            retour
                                        </button>
                                        <div v-if="link != null">
                                            <VueConfirmationButton
                                                class="text-red-600 hover:text-red-800 whitespace-nowrap transition-all duration-200"
                                                :messages="customMessages" v-on:confirmation-success="deleteLink">
                                            </VueConfirmationButton>
                                        </div>
                                        <button type="button" @click="submit" :loading="form.processing" :disabled="form.processing" class="btn-submit">
                                            <CheckIcon class="mr-1 size-5" aria-hidden="true" />
                                            enregistrer
                                        </button>
                                    </div>
                                </div>
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
                'Supprimer le lien',
                'Êtes-vous sûr ?',
                'Supprimé !'
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
