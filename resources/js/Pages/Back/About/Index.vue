<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col gap-4 p-4">
                <form @submit.prevent="submit" enctype="multipart/form-data" class="flex flex-col w-full gap-4">
                    <input type="hidden" v-model="form.id">
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Nom" />
                        <input type="text" v-model="form.title" class="input-primary">
                        <InputError :message="form.errors.title" />
                    </div>
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Fonction" />
                        <input type="text" v-model="form.subtitle" class="input-primary">
                        <InputError :message="form.errors.subtitle" />
                    </div>
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Catch Phrase" />
                        <input type="text" v-model="form.catch_phrase" class="input-primary">
                        <InputError :message="form.errors.catch_phrase" />
                    </div>
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Image de couverture" />
                        <div
                            class="mt-2 flex justify-center rounded-3xl border-2 border-dashed border-gray-200 bg-white px-6 py-10">
                            <div class="text-center">
                                <img v-if="preview" :src="preview" class="object-contain h-32 mt-4" />
                                <PhotoIcon v-else class="mx-auto size-12 text-gray-300" aria-hidden="true" />
                                <div class="mt-4 flex justify-center text-sm leading-6 text-gray-600">
                                    <label for="file-upload"
                                        class="relative cursor-pointer px-2 rounded-3xl bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Téléverser une image</span>
                                        <input id="file-upload" type="file" accept="image/*" ref="photo"
                                            @change="previewImage" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF jusqu'à 10Mb</p>
                            </div>
                        </div>
                        <InputError :message="form.errors.img" />
                    </div>
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Adresse" />
                        <input type="text" v-model="form.address" class="input-primary">
                        <InputError :message="form.errors.address" />
                    </div>
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Téléphone" />
                        <input type="text" v-model="form.phone" class="input-primary">
                        <InputError :message="form.errors.phone" />
                    </div>
                    <div class="flex flex-col justify-start">
                        <InputLabel value="Email" />
                        <input type="text" v-model="form.email" class="input-primary">
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="flex gap-6">
                        <div class="basis-1/2 flex flex-col justify-start">
                            <InputLabel value="Description" />
                            <textarea v-model="form.description" rows="15" class="textarea-primary"></textarea>
                            <InputError :message="form.errors.description" />
                        </div>
                        <div class="basis-1/2 mt-6 prose prose-slate max-w-none" v-html="renderedMarkdown"></div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button :loading="form.processing" :disabled="form.processing" class="btn-submit">
                            <CheckIcon class="mr-1 size-6" aria-hidden="true" />
                            enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </AppLayout>
</template>

<script>
import { marked } from 'marked';
import AppLayout from '@/Layouts/AppLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import { CheckIcon, PhotoIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        InputLabel,
        InputError,
        CheckIcon,
        PhotoIcon
    },

    props: {
        about: {
            type: Array,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: '',
                catch_phrase: '',
                img: null,
                subtitle: '',
                description: '',
                address: '',
                phone: '',
                email: '',
            }),
            preview: '',
            customMessages: [
                'Delete about',
                'Are you sure?',
                'Done!'
            ],
        };
    },

    computed: {
        renderedMarkdown() {
            if (this.form.description) {
                return marked(this.form.description);
            }
            return '';
        }
    },

    methods: {
        submit() {
            if (this.$refs.photo) {
                if (this.$refs.photo.files[0] !== undefined) {
                    this.form.img = this.$refs.photo.files[0];
                } else {
                    this.form.img = this.about.img;
                }
            }
            this.form.post(route('about.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.preview = URL.createObjectURL(file);
        },
    },

    mounted() {
        this.form.id = this.about?.id;
        this.form.title = this.about?.title;
        this.form.catch_phrase = this.about?.catch_phrase;
        this.form.img = this.about?.img;
        this.preview = this.about?.img;
        this.form.subtitle = this.about?.subtitle;
        this.form.description = this.about?.description;
        this.form.address = this.about?.address;
        this.form.phone = this.about?.phone;
        this.form.email = this.about?.email;
    }
}
</script>

<style scoped>
/* Vous pouvez ajouter des styles spécifiques pour le rendu du Markdown */
.prose img {
    max-width: 100%;
}

.prose a {
    color: #3b82f6;
    text-decoration: underline;
}
</style>
