<template>
    <div class="pointer-events-none -mt-16">
        <div id="about" class="sticky top-0 backdrop-blur-sm bg-slate/30 z-40">
            <h4 class="flex items-center py-3 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>à propos de moi</span>
            </h4>
        </div>
        <div class="flex gap-8">
            <div class="whitespace-pre-wrap pl-8">
                {{ about .description }}
            </div>
            <div>
                <img :src="user.profile_photo_url" :alt="about.title" class="rounded-custom -mt-20 z-50 w-[80rem] relative">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        about: {
            type: Object,
        },
        user: {
            type: Object,
        },
    },
}
</script>
