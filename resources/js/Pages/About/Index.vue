<template>
    <AppLayout>

        <div class="max-w-7xl mx-auto">
            test
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout,
    },

    props: {
        about: {
            type: Array,
        },
    },
}
</script>
