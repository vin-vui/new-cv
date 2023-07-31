<template>
    <TransitionRoot as="template" :show="isModalVisible">
        <Dialog as="div" class="relative z-10" @close="close">

            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div class="mt-3  sm:mt-5 flex flex-col gap-4">

                                <DialogTitle as="h3" class="text-base text-center font-semibold leading-6 text-gray-900">
                                    <span v-if="skill != null">Update Skill</span>
                                    <span v-else>Create Skill</span>
                                </DialogTitle>

                                <form @submit.prevent="submit" enctype="multipart/form-data"
                                    class="flex flex-col w-full gap-4">
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Title" />
                                        <input type="text" v-model="form.title">
                                        <InputError :message="form.errors.title" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Image" />
                                        <!-- <img :src="form.img" class="object-contain h-32" /> -->
                                        <input type="file" accept="image/jpeg, image/png, image/svg" @change="previewImage" ref="photo">
                                        <img v-if="url" :src="url" class="object-contain h-32 mt-4" />
                                        <InputError :message="form.errors.img" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Url Externe" />
                                        <input type="text" v-model="form.url">
                                        <InputError :message="form.errors.url" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Description" />
                                        <textarea class="" v-model="form.description"></textarea>
                                        <InputError :message="form.errors.description" />
                                    </div>
                                    <div class="flex flex-col justify-start">
                                        <select v-model="form.level">
                                            <option v-for="option in options" :key="option.value" :value="option.value">
                                                {{ option.text }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="flex items-center justify-between gap-8 mt-4">
                                        <button type="button"
                                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            @click="close">
                                            Go back
                                        </button>
                                        <button :loading="form.processing" :disabled="form.processing"
                                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Submit!
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

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
    },

    props: {
        skill: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                title: this.skill != null ? this.skill.title : '',
                img: this.skill != null ? this.skill.img : '',
                url: this.skill != null ? this.skill.url : '',
                description: this.skill != null ? this.skill.description : '',
                level: ref('advanced'),
                // _method: this.skill ? 'put' : 'post',
                _method: 'post',
            }),
            options: ref([
                { text: 'beginner', value: 'beginner' },
                { text: 'intermediate', value: 'intermediate' },
                { text: 'advanced', value: 'advanced' },
                { text: 'expert', value: 'expert' },
            ]),
            isModalVisible: ref(true),
        };
    },

    methods: {
        close() {
            this.$emit('close');
        },
        submit() {
            if (this.$refs.photo) {
                this.form.img = this.$refs.photo.files[0];
            }
            this.form.post(route('skills.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length
            });
        },
        previewImage(e) {
            // this.form.img = URL.createObjectURL(e.target.files[0]);
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        reset() {
            this.form.reset();
        }
    },
};
</script>
