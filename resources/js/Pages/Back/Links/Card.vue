<template>
    <div class="bg-white shadow rounded-lg hover:shadow-xl hover:scale-105 cursor-pointer transition-all duration-200">
        <div class="flex p-2">
            <div v-html="link.img" class="w-16 flex items-center justify-center"></div>
            <div class="w-full p-4 flex flex-col justify-between">
                <div class="">
                    <h3 class="text-xl">{{ link.title }}</h3>
                </div>
                <div class="">
                    <span class="underline text-green-400 text-sm flex items-center">
                        <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4 mr-1" aria-hidden="true" />
                        {{ link.url }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        ArrowTopRightOnSquareIcon
    },

    props: {
        link: {
            type: Object,
        },
    },
}
</script>
