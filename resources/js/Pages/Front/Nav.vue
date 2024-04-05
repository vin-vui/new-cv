<template>
    <div class="flex grow flex-col gap-y-5 md:pl-8 overflow-y-auto py-8">
        <div class="hidden md:flex">
            <Hero :about="about" />
        </div>
        <nav class="flex flex-1 flex-col mt-16">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="space-y-1">
                        <li v-for="item in navigationWithCurrent" :key="item.name">
                            <a class="group flex items-center py-3" :href="item.href"
                                @click.prevent="scrollToSection(item.href)">
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
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import Hero from '@/Pages/Front/Hero.vue'

export default {
    components: {
        Hero,
    },

    props: {
        about: Object,
        links: Object,
        user: Object,
        skills: Object,
        projects: Object,
        formations: Object,
    },

    setup() {
        const currentAnchor = ref(window.location.hash);

        const updateAnchor = () => {
            currentAnchor.value = window.location.hash;
        };

        const navigation = ref([
            { name: 'à propos de moi', href: '#about' },
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

        return {
            currentAnchor,
            navigationWithCurrent,
            scrollToSection,
        };
    },
};
</script>
