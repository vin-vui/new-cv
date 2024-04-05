<template>
    <section id="about" aria-labelledby="abouts" class="-mt-16">
        <div class="sticky top-0 backdrop-blur-sm bg-slate/30 z-30">
            <h4 class="flex items-center py-5 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>à propos de moi</span>
            </h4>
        </div>
        <div class="flex flex-col-reverse md:flex-row gap-8 items-center md:items-start">
            <div class="whitespace-pre-wrap md:pl-8 md:pr-0 sm:px-4 px-8 pointer-events-none">
                {{ about.description }}
            </div>
            <div>
                <img :src="user.profile_photo_url" :alt="about.title" class="rounded-custom md:-mt-20 z-20 sm:z-30 md:w-[80rem] md:h-auto h-48 relative">
            </div>
        </div>
    </section>
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
