<template>
    <GuestLayout :title="title">

        <!-- Mobile button to show/hide the menu -->
        <div class="fixed top-4 right-4 z-40 shadow-sm lg:hidden">
            <button type="button" class="text-slate-200 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="size-8" aria-hidden="true" />
            </button>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full" enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                        leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                                leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-slate-900 px-6 pb-2">
                                <Nav :about="about" :user="user" :links="links" @closeNav="sidebarOpen = false" />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col">
            <Nav :about="about" :user="user" :links="links" />
        </div>

        <!-- Content -->
        <div class="lg:pl-72 relative">
            <div class="min-h-screen">
                <div class="max-w-7xl mx-auto md:px-6 lg:px-8 relative flex flex-col gap-24">

                    <div class="md:hidden block px-8 mt-12">
                        <Hero :about="about" />
                    </div>

                    <div class="-mt-8 bg-no-repeat bg-center h-96 bg-cover bg-local flex flex-col-reverse" :style="{ backgroundImage: 'url(' + about.img + ')' }">
                        <div class="flex justify-center sm:py-16 pt-16 pb-8 px-8 bg-gradient-to-b from-transparent to-slate-900 select-none text-4xl font-bold tracking-tight text-slate-200 sm:text-5xl">
                            Bienvenue sur mon webfolio
                        </div>
                    </div>

                    <About :about="about" :profile_photo_url="user.profile_photo_url" />
                    <Skills :skills="skills" />
                    <Projects :projects="projects" />
                    <Formations :formations="formations" />
                    <Contact :email="user.email" :who="about.title" :phone="about.phone" />

                    <div class="max-w-lg">
                        <p class="text-sm">
                            Design inspiré par la formidable <a href="https://brittanychiang.com" aria-label="Lien vers le webfolio de Brittany Chiang" target="_blank" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Brittany Chiang</a>,
                            codé avec 💛 sur <a href="https://code.visualstudio.com" aria-label="Lien vers les site de VSCode" target="_blank" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Visual Studio Code</a>
                            par <a href="https://vinvui.com" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Vinvui</a>.
                            Construit en utilisant <a href="https://laravel.com" aria-label="Lien vers le site de Laravel" target="_blank" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Laravel</a>,
                            <a href="https://v3.vuejs.org" aria-label="Lien vers le site de Vue.js" target="_blank" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Vue.js</a>
                            et <a href="https://tailwindcss.com" aria-label="Lien vers le site de Tailwind CSS" target="_blank" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Tailwind CSS</a>.
                            Déployé sur <a href="https://www.digitalocean.com/" class="whitespace-nowrap font-semibold hover:text-amber-400/80">DigitalOcean</a>
                            avec <a href="https://forge.laravel.com" aria-label="Lien vers le site de Forge" target="_blank" class="whitespace-nowrap font-semibold hover:text-amber-400/80">Forge</a>.
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </GuestLayout>
</template>

<script>
import { ref } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import About from '@/Pages/Front/About.vue';
import Skills from '@/Pages/Front/Skills.vue';
import Projects from '@/Pages/Front/Projects.vue';
import Formations from '@/Pages/Front/Formations.vue';
import Hero from '@/Pages/Front/Hero.vue';
import Nav from '@/Pages/Front/Nav.vue';
import Contact from '@/Pages/Front/Contact.vue';

export default {
    components: {
        GuestLayout,
        About,
        Skills,
        Projects,
        Formations,
        Hero,
        Nav,
        Contact,
        Dialog,
        DialogPanel,
        TransitionChild,
        TransitionRoot,
        Bars3Icon, XMarkIcon,
    },

    props: {
        title: String,
        about: Object,
        links: Object,
        user: Object,
        skills: Object,
        projects: Object,
        formations: Object,
    },

    setup(props) {
        const title = `${props.about.title} - ${props.about.subtitle}`;
        const sidebarOpen = ref(false);

        return {
            title,
            sidebarOpen,
        };
    },
};
</script>
