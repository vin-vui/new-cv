<template>
    <perfect-scrollbar class="bg-primary">

        <Head :title="title" />

        <Banner />

        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                    leave-to="opacity-0">
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
                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-2 ring-1 ring-white/10">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-8 w-auto"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                        alt="Your Company" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <a :href="item.href"
                                                        :class="[item.current ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <component :is="item.icon" class="h-6 w-6 shrink-0"
                                                            aria-hidden="true" />
                                                        {{ item.name }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                                <li v-for="team in teams" :key="team.name">
                                                    <a :href="team.href"
                                                        :class="[team.current ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <span
                                                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">{{
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
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-64 lg:flex-col ">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto pt-4 overflow-x-hidden">
                <a :href="route('profile.show')"
                    class="flex items-center gap-2 mr-6 bg-gray-100 rounded-r-full focus:outline-none focus:border-gray-300 transition">
                    <img class="size-20 rounded-r-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-500 to-amber-500 text-xl font-semibold">{{ $page.props.auth.user.name }}'s CV</span>
                </a>
                <nav class="flex flex-1 flex-col pl-6">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name" class="relative">
                                    <a :href="item.href"
                                        :class="[item.current ? 'bg-gray-100 text-gray-800 active' : 'text-gray-50 hover:text-gray-800 hover:bg-gray-100/50', 'capitalize group flex gap-x-3 rounded-l-full p-4 text-sm leading-6 font-semibold transition-all duration-200']">
                                        <component :is="item.icon" class="size-6 stroke-2 shrink-0 text-amber-400" aria-hidden="true" />
                                        {{ item.name }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="-ml-6 mt-auto mb-4 mr-6">
                            <form @submit.prevent="logout">
                                <button as="button" class="flex gap-2 items-center justify-start w-full pl-8 rounded-r-full py-4 hover:bg-red-600 hover:text-white text-sm leading-6 font-semibold transition-all duration-200">
                                    <PowerIcon class="size-6" aria-hidden="true" />
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-gray-900 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-gray-400 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
            <div class="flex-1 text-sm font-semibold leading-6 text-white">Dashboard</div>
            <a href="#">
                <span class="sr-only">Your profile</span>
                <img class="h-8 w-8 rounded-full bg-gray-800"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="" />
            </a>
        </div>

        <main class="lg:pl-64 py-4">
            <div class="rounded-3xl mr-4 p-10 min-h-screen bg-gray-100">
                <slot />
            </div>
        </main>

    </perfect-scrollbar>
</template>

<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { Bars3Icon, AcademicCapIcon, FolderIcon, HomeIcon, UsersIcon, XMarkIcon, ArrowTopRightOnSquareIcon, Cog6ToothIcon, PowerIcon} from '@heroicons/vue/24/outline'

defineProps({
    title: String,
});

const navigation = [
    { name: 'dashboard', href: route('dashboard'), icon: HomeIcon, current: route().current('dashboard') },
    { name: 'à propos', href: route('about.index'), icon: UsersIcon, current: route().current('about.index') },
    { name: 'compétences', href: route('skills.index'), icon: Cog6ToothIcon, current: route().current('skills.index') },
    { name: 'formations', href: route('formations.index'), icon: AcademicCapIcon, current: route().current('formations.index') },
    { name: 'liens externes', href: route('links.index'), icon: ArrowTopRightOnSquareIcon, current: route().current('links.index') },
    { name: 'projets', href: route('projects.index'), icon: FolderIcon, current: route().current('projects.index') },
]

const title = 'Senior Fullstack Developer'
const sidebarOpen = ref(false)
const logout = () => {
    router.post(route('logout'));
};

</script>
