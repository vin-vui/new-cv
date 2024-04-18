<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto">
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="item in stats" :key="item.id"
                    class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                    <dt>
                        <div class="absolute rounded-md bg-gradient-to-tr from-cyan-500 to-amber-500 p-3">
                            <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                        </div>
                        <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
                    </dt>
                    <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                        <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm">
                                <a :href="item.link" class="font-medium text-amber-500 hover:text-amber-700">View all<span class="sr-only"> {{ item.name }} stats</span></a>
                            </div>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import {AcademicCapIcon, FolderIcon, ArrowTopRightOnSquareIcon, Cog6ToothIcon} from '@heroicons/vue/24/outline'

export default {
    components: {
        AppLayout
    },

    props: {
        skills_count: {
            type: Number,
        },
        formations_count: {
            type: Number,
        },
        links_count: {
            type: Number,
        },
        projects_count: {
            type: Number,
        },
    },

    data() {
        return {
            stats: [
                { name: 'Compétences', stat: this.skills_count, icon: Cog6ToothIcon, link: '/skills'},
                { name: 'Formations', stat: this.formations_count, icon: AcademicCapIcon, link: '/formations'},
                { name: 'Liens', stat: this.links_count, icon: ArrowTopRightOnSquareIcon, link: '/links'},
                { name: 'Projets', stat: this.projects_count, icon: FolderIcon, link: '/projects'},
            ]
        };
    }
}
</script>
