<script setup>

    import { Head } from '@inertiajs/vue3'
    import ItemIndex from '@/Pages/Tenant/Items/Index.vue'
    import { useMainStore } from '@/Stores/main.js'

    const props = defineProps({
        isTenant: {
            type: Boolean,
            required:true
        },
    })

    useMainStore().setMainConfig({
        isTenant: props.isTenant,
    })

</script>

<template>
    <Head title="Dashboard" />

    <item-index></item-index>
</template>
