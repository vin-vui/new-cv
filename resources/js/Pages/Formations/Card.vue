<template>
    <div class="bg-white rounded-lg hover:shadow-xl cursor-pointer transition-all duration-200">
        <div class="flex">
            <div class="w-full p-4 flex flex-col">
                <div class="flex justify-between">
                    <div class="">
                        <h3 class="text-xl">{{ formation.title }}</h3>
                        <div class="text-green-400 italic">
                            {{ formation.school }}
                        </div>
                    </div>
                    <div class="">
                        <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-1 rounded-md">{{ formation.year }}</span>
                    </div>
                </div>
                <div class="text-gray-600 mt-3 whitespace-pre-wrap">{{ formation.description }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        formation: {
            type: Object,
        },
    },
}
</script>
