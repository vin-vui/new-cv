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
                                :class="{ 'bg-yellow-400': project != null, 'bg-green-400': project == null }">
                                <span v-if="project != null">Update Project</span>
                                <span v-else>Add Project</span>
                            </DialogTitle>

                            <div class="flex flex-col gap-4 p-4">
                                <form @submit.prevent="submit" enctype="multipart/form-data"
                                    class="flex flex-col w-full gap-4">

                                    <div class="flex gap-8">
                                        <!-- form -->
                                        <div class="flex flex-col gap-2 basis-2/5">
                                            <input type="hidden" v-model="form.id">
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Title" />
                                                <input type="text" v-model="form.title">
                                                <InputError :message="form.errors.title" />
                                            </div>

                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Url Externe" />
                                                <input type="url" v-model="form.url">
                                                <InputError :message="form.errors.url" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Description" />
                                                <textarea class="" v-model="form.description"></textarea>
                                                <InputError :message="form.errors.description" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Client" />
                                                <input type="text" v-model="form.client">
                                                <InputError :message="form.errors.client" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Job" />
                                                <input type="text" v-model="form.job">
                                                <InputError :message="form.errors.job" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Github" />
                                                <input type="url" v-model="form.github">
                                                <InputError :message="form.errors.github" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Start Date" />
                                                <input type="date" v-model="form.start_date">
                                                <InputError :message="form.errors.start_date" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="End Date" />
                                                <input type="date" v-model="form.end_date">
                                                <InputError :message="form.errors.end_date" />
                                            </div>

                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Skills" />
                                                <div class="flex gap-2 flex-wrap">
                                                    <div v-for="skill in skills" class="flex items-center gap-1">
                                                        <input type="checkbox" :id="skill.id" :value="skill.id"
                                                            v-model="form.skills">
                                                        <label :for="skill.id">{{ skill.title }}</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-4 mt-4 border px-4 py-2 bg-blue-400 text-gray-50 rounded-md">
                                                <input type="checkbox" id="checkbox" v-model="form.is_printable" />
                                                <label for="checkbox">Printable</label>
                                            </div>
                                        </div>

                                        <!-- Illustrations -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="flex flex-col justify-start col-span-2">
                                                <InputLabel value="Logo" />
                                                <input type="file" accept="image/*" ref="photo"
                                                    @change="previewLogo">
                                                <img v-if="pwLogo" :src="pwLogo" class="object-contain h-32 mt-4 border" />
                                                <InputError :message="form.errors.logo" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Image 1" />
                                                <input type="file" accept="image/*" ref="image1"
                                                    @change="previewImage1">
                                                <img v-if="pwImage1" :src="pwImage1"
                                                    class="object-contain h-32 mt-4 border" />
                                                <InputError :message="form.errors.illustration_1" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Image 2" />
                                                <input type="file" accept="image/*" ref="image2"
                                                    @change="previewImage2">
                                                <img v-if="pwImage2" :src="pwImage2"
                                                    class="object-contain h-32 mt-4 border" />
                                                <InputError :message="form.errors.illustration_2" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Image 3" />
                                                <input type="file" accept="image/*" ref="image3"
                                                    @change="previewImage3">
                                                <img v-if="pwImage3" :src="pwImage3"
                                                    class="object-contain h-32 mt-4 border" />
                                                <InputError :message="form.errors.illustration_3" />
                                            </div>
                                            <div class="flex flex-col justify-start">
                                                <InputLabel value="Image 4" />
                                                <input type="file" accept="image/*" ref="image4"
                                                    @change="previewImage4">
                                                <img v-if="pwImage4" :src="pwImage4"
                                                    class="object-contain h-32 mt-4 border" />
                                                <InputError :message="form.errors.illustration_4" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-4 mt-4">
                                        <button type="button"
                                            class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            @click="close">
                                            <ArrowLeftIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                            Go back
                                        </button>
                                        <button :loading="form.processing" :disabled="form.processing"
                                            class="inline-flex justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                            <CheckIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div v-if="project != null" class="flex justify-end mt-4">
                                <VueConfirmationButton class="text-red-600 hover:text-red-800 transition-all duration-200"
                                    :messages="customMessages" v-on:confirmation-success="deleteProject">
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
    name: 'ProjectModal',

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
        project: {
            type: Object,
        },
        skills: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: '',
                logo: null,
                illustration_1: null,
                illustration_2: null,
                illustration_3: null,
                illustration_4: null,
                url: '',
                description: '',
                client: '',
                job: '',
                github: '',
                start_date: '',
                end_date: '',
                is_printable: '',
                skills: ref([]),
            }),
            pwLogo: '',
            pwImage1: '',
            pwImage2: '',
            pwImage3: '',
            pwImage4: '',
            customMessages: [
                'Delete Project',
                'Are you sure?',
                'Done!'
            ],
        };
    },

    watch: {
        project: {
            handler() {
                this.form.id = this.project?.id;
                this.form.title = this.project?.title;
                this.form.logo = this.project?.logo;
                this.pwLogo = this.project?.logo;
                this.form.illustration_1 = this.project?.illustration_1;
                this.pwImage1 = this.project?.illustration_1;
                this.form.illustration_2 = this.project?.illustration_2;
                this.pwImage2 = this.project?.illustration_2;
                this.form.illustration_3 = this.project?.illustration_3;
                this.pwImage3 = this.project?.illustration_3;
                this.form.illustration_4 = this.project?.illustration_4;
                this.pwImage4 = this.project?.illustration_4;
                this.form.url = this.project?.url;
                this.form.description = this.project?.description;
                this.form.client = this.project?.client;
                this.form.job = this.project?.job;
                this.form.github = this.project?.github;
                this.form.start_date = this.project?.start_date;
                this.form.end_date = this.project?.end_date;
                this.form.is_printable = this.project?.is_printable;
                this.form.skills = this.project?.skills.map(skill => skill.id);
            },
            deep: true
        }
    },

    methods: {
        submit() {
            if (this.$refs.photo) {
                if (this.$refs.photo.files[0] !== undefined) {
                    this.form.logo = this.$refs.photo.files[0];
                } else {
                    this.form.logo = this.project?.logo;
                }
            }
            if (this.$refs.image1) {
                if (this.$refs.image1.files[0] !== undefined) {
                    this.form.illustration_1 = this.$refs.image1.files[0];
                } else {
                    this.form.illustration_1 = this.project?.illustration_1;
                }
            }
            if (this.$refs.image2) {
                if (this.$refs.image2.files[0] !== undefined) {
                    this.form.illustration_2 = this.$refs.image2.files[0];
                } else {
                    this.form.illustration_2 = this.project?.illustration_2;
                }
            }
            if (this.$refs.image3) {
                if (this.$refs.image3.files[0] !== undefined) {
                    this.form.illustration_3 = this.$refs.image3.files[0];
                } else {
                    this.form.illustration_3 = this.project?.illustration_3;
                }
            }
            if (this.$refs.image4) {
                if (this.$refs.image4.files[0] !== undefined) {
                    this.form.illustration_4 = this.$refs.image4.files[0];
                } else {
                    this.form.illustration_4 = this.project?.illustration_4;
                }
            }
            this.form.post(route('projects.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        deleteProject() {
            this.form.delete(route('projects.destroy', this.project), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        previewLogo(e) {
            this.pwLogo = URL.createObjectURL(e.target.files[0]);
        },
        previewImage1(e) {
            this.pwImage1 = URL.createObjectURL(e.target.files[0]);
        },
        previewImage2(e) {
            this.pwImage2 = URL.createObjectURL(e.target.files[0]);
        },
        previewImage3(e) {
            this.pwImage3 = URL.createObjectURL(e.target.files[0]);
        },
        previewImage4(e) {
            this.pwImage4 = URL.createObjectURL(e.target.files[0]);
        },
        close() {
            this.form.clearErrors()
            this.$emit('close')
        },
    },
};
</script>
