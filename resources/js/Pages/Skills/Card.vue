<template>
    <div class="bg-white shadow rounded-lg hover:shadow-xl hover:scale-105 cursor-pointer transition-all duration-200">
        <div class="flex">
            <div class="flex-none rounded-l-lg">
                <img :src="skill.img" :alt="skill.title" class="object-contain w-32 h-32 my-auto p-2" />
            </div>
            <div class="w-full p-4 flex flex-col justify-between">
                <div class="">
                    <h3 class="text-xl">{{ skill.title }}</h3>
                </div>
                <div class="flex justify-end">
                    <span :class="getClass()" class="rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset">{{ skill.level }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        skill: {
            type: Object,
        },
    },
    methods: {
        getClass() {
            if (this.skill.level === 'beginner') {
                return 'bg-red-50 text-red-700 ring-red-600/10';
            } else if (this.skill.level === 'intermediate') {
                return 'bg-yellow-50 text-yellow-700 ring-yellow-600/10';
            } else if (this.skill.level === 'advanced') {
                return 'bg-blue-50 text-blue-700 ring-blue-600/10';
            } else if (this.skill.level === 'expert') {
                return 'bg-green-50 text-green-700 ring-green-600/10';
            }
        },
    },
}
</script>
