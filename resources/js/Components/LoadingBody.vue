<script setup>

    defineProps({
        isLoading: {
            type: Boolean,
            required: true
        },
    })

</script>

<template>
    <div class="relative">
        <slot />

        <template v-if="isLoading">

            <div class="absolute top-0 start-0 w-full h-full bg-white/[.5] rounded-lg dark:bg-gray-800/[.4]"></div>
    
            <div class="absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <div class="animate-spin inline-block w-10 h-10 border-[4px] border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
                    <span class="sr-only">Cargando...</span>
                </div>
            </div>

        </template>
    </div>
</template>