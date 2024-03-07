<template>
    <GuestLayout>

        <!-- Mobile button to show/hide the menu -->
        <div class="sticky top-0 z-40 flex items-center gap-x-6  px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-indigo-200 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
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
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-2">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=white"
                                        alt="Your Company" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <a :href="item.href"
                                                        :class="[item.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <component :is="item.icon"
                                                            :class="[item.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']"
                                                            aria-hidden="true" />
                                                        {{ item.name }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="text-xs font-semibold leading-6 text-indigo-200">Your teams
                                            </div>
                                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                                <li v-for="team in teams" :key="team.name">
                                                    <a :href="team.href"
                                                        :class="[team.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <span
                                                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">{{
                team.initial }}</span>
                                                        <span class="truncate">{{ team.name }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col py-8">
            <div class="flex grow flex-col gap-y-5 pl-8 overflow-y-auto">
                <div class="flex flex-col items-center pointer-events-none">
                    <h1 class="text-4xl font-bold tracking-tight text-slate-200 sm:text-5xl">{{ about.title }}</h1>
                    <h2 class="mt-3 text-lg font-medium tracking-tight text-slate-200 sm:text-xl">{{ about.subtitle }}
                    </h2>
                    <h3 class="mt-4 max-w-xs leading-normal">{{ about.catch_phrase }}</h3>
                </div>
                <nav class="flex flex-1 flex-col mt-16">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="space-y-1">
                                <li v-for="item in navigationWithCurrent" :key="item.name">
                                    <a class="group flex items-center py-3" :href="item.href" @click.prevent="scrollToSection(item.href)">
                                        <span
                                            :class="[item.current ? 'w-16 bg-slate-200' : ' w-8 bg-slate-600', 'mr-4 h-px group-focus-visible:w-16 group-focus-visible:bg-slate-200 transition-all group-hover:w-16 group-hover:bg-slate-200 motion-reduce:transition-none']"></span>
                                        <span
                                            :class="[item.current ? 'text-slate-200' : 'text-slate-500', 'text-xs font-bold uppercase tracking-widest group-focus-visible:text-slate-200 group-hover:text-slate-200 ']">{{
                item.name }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="mt-auto">
                            <ul class="flex flex-row gap-5">
                                <li v-for="link in links" :key="link.url">
                                    <tippy :content="link.title" class="flex items-center gap-1">
                                        <a :href="link.url" target="_blank" rel="noopener noreferrer">
                                            <span class="sr-only">{{ link.title }}</span>
                                            <span v-html="link.img" class="link"></span>
                                        </a>
                                    </tippy>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Content -->
        <div class="lg:pl-72 relative">
            <div class="min-h-screen">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative flex flex-col gap-24">
                    <div class="-mt-8 bg-no-repeat bg-center h-96 bg-cover bg-local"
                        :style="{ backgroundImage: 'url(' + about.img + ')' }"></div>
                    <About :about="about" :user="user" />
                    <Skills :skills="skills" />
                    <Projects :projects="projects" />
                    <Formations :formations="formations" />
                </div>
            </div>
        </div>

    </GuestLayout>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import About from '@/Pages/Front/About.vue';
import Skills from '@/Pages/Front/Skills.vue';
import Projects from '@/Pages/Front/Projects.vue';
import Formations from '@/Pages/Front/Formations.vue';
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

defineProps({
    title: String,
    about: Object,
    links: Object,
    user: Object,
    skills: Object,
    projects: Object,
    formations: Object,
});

const currentAnchor = ref(window.location.hash);

const updateAnchor = () => {
    currentAnchor.value = window.location.hash;
};

const navigation = ref([
    { name: 'à propos', href: '#about' },
    { name: 'compétences', href: '#skills' },
    { name: 'projets', href: '#projects' },
    { name: 'formations', href: '#formations' },
]);

const navigationWithCurrent = computed(() =>
    navigation.value.map(item => ({
        ...item,
        current: currentAnchor.value === item.href,
    }))
);

const title = 'Senior Fullstack Developer'
const sidebarOpen = ref(false)

const scrollToSection = (href) => {
  const sectionId = href.substring(1); // Supprime le "#" du href pour obtenir l'ID
  const section = document.getElementById(sectionId);

  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  }
};

const updateCurrentAnchor = () => {
  let currentSection = "";

  navigation.value.forEach((navItem) => {
    const sectionId = navItem.href.substring(1);
    const section = document.getElementById(sectionId);

    if (section) {
      const positionFromTop = section.getBoundingClientRect().top;

      if (positionFromTop - window.innerHeight < 0 && positionFromTop < window.innerHeight / 2) {
        currentSection = navItem.href;
      }
    }
  });

  currentAnchor.value = currentSection;
};

onMounted(() => {
    window.addEventListener('hashchange', updateAnchor);
    window.addEventListener('scroll', updateCurrentAnchor);
    updateCurrentAnchor();
});

onUnmounted(() => {
    window.removeEventListener('hashchange', updateAnchor);
    window.removeEventListener('scroll', updateCurrentAnchor);
});

</script>
