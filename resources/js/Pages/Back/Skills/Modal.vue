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
                                class="py-4 text-xl text-center font-semibold leading-6 text-gray-800 bg-opacity-80"
                                :class="{ 'bg-yellow-400': skill != null, 'bg-green-400': skill == null }">
                                <span v-if="skill != null">Update Skill</span>
                                <span v-else>Add Skill</span>
                            </DialogTitle>

                            <div class="flex flex-col gap-4 p-4">
                                <div class="flex flex-col w-full gap-4">
                                    <input type="hidden" v-model="form.id">

                                    <div class="flex gap-6">
                                        <div class="flex flex-col justify-start">
                                            <InputLabel value="Image" />
                                            <div
                                                class="mt-1 flex justify-center rounded-3xl outline-dashed outline-2 outline-offset-2 outline-gray-200 bg-slate-900 px-6 py-10">
                                                <div class="flex flex-col justify-center text-center">
                                                    <img v-if="preview" :src="preview" class="object-contain h-32" />
                                                    <PhotoIcon v-else class="mx-auto size-12 text-gray-300"
                                                        aria-hidden="true" />
                                                    <div class="mt-4 flex justify-center text-sm leading-6 text-gray-600">
                                                        <label for="file-upload"
                                                            class="relative cursor-pointer px-2 rounded-3xl bg-white font-semibold text-green-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-green-600 focus-within:ring-offset-2 hover:text-green-500">
                                                            <span>Upload a file</span>
                                                            <input id="file-upload" type="file" accept="image/*" ref="photo"
                                                                @change="previewImage" class="sr-only">
                                                        </label>
                                                    </div>
                                                    <p class="mt-2 text-xs leading-5 text-gray-600">PNG, JPG, GIF, SVG up to 10MB</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grow flex flex-col gap-4">
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Title" />
                                                <input type="text" v-model="form.title" class="input-primary">
                                                <InputError :message="form.errors.title" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Url Externe" />
                                                <input type="url" v-model="form.url" class="input-primary">
                                                <InputError :message="form.errors.url" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Description" />
                                                <textarea v-model="form.description" class="textarea-primary" rows="5"></textarea>
                                                <InputError :message="form.errors.description" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Level" />
                                                <select v-model="form.level" class="input-primary">
                                                    <option v-for="option in options" :key="option.value"
                                                        :value="option.value">
                                                        {{ option.text }}
                                                    </option>
                                                </select>
                                                <InputError :message="form.errors.level" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-4 mt-4">
                                        <button type="button"
                                            class="btn-go-back"
                                            @click="close">
                                            <ArrowLeftIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                            Go back
                                        </button>
                                        <div v-if="skill != null" class="">
                                            <VueConfirmationButton
                                                class="text-red-600 hover:text-red-800 transition-all duration-200 whitespace-nowrap"
                                                :messages="customMessages" v-on:confirmation-success="deleteSkill">
                                            </VueConfirmationButton>
                                        </div>
                                        <button type="button" @click="submit" :loading="form.processing" :disabled="form.processing" class="btn-submit">
                                            <CheckIcon class="mr-1 size-5" aria-hidden="true" />
                                            Submit
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
import VueConfirmationButton from '@/Components/VueConfirmationButton.vue'
import { CheckIcon, ArrowLeftIcon } from '@heroicons/vue/20/solid'

export default {
    name: 'SkillModal',

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
        skill: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: '',
                img: null,
                url: '',
                description: '',
                level: '',
            }),
            options: ref([
                { text: 'beginner', value: 'beginner' },
                { text: 'intermediate', value: 'intermediate' },
                { text: 'advanced', value: 'advanced' },
                { text: 'expert', value: 'expert' },
            ]),
            preview: '',
            customMessages: [
                'Delete Skill',
                'Are you sure?',
                'Done!'
            ],
        };
    },

    watch: {
        skill: {
            handler() {
                this.form.id = this.skill?.id;
                this.form.title = this.skill?.title;
                this.form.img = this.skill?.img;
                this.preview = this.skill?.img;
                this.form.url = this.skill?.url;
                this.form.description = this.skill?.description;
                this.form.level = ref(this.skill?.level);
            },
            deep: true
        }
    },

    methods: {
        submit() {
            if (this.$refs.photo) {
                if (this.$refs.photo.files[0] !== undefined) {
                    this.form.img = this.$refs.photo.files[0];
                } else {
                    this.form.img = this.skill.img;
                }
            }
            this.form.post(route('skills.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        deleteSkill() {
            this.form.delete(route('skills.destroy', this.skill), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.preview = URL.createObjectURL(file);
        },
        close() {
            this.form.clearErrors()
            this.$emit('close')
        },
    },
};
</script>
