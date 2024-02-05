<script setup>
    import { ref, watch } from 'vue'
    import { FwbButton, FwbModal, FwbInput, FwbSpinner } from 'flowbite-vue'

    import InputError from '@/Components/InputError.vue'
    import LoadingBody from '@/Components/LoadingBody.vue'
    import { useTenants } from '@/composables/central/tenants'
    import EventBus from '@/Libs/EventBus'

    const { deleteRecord, isLoading, isLoadingButton } = useTenants()
    
    const props = defineProps({
        recordId: {
            type: String,
            default: null
        },
        showModal: {
            type: Boolean,
            required: true
        },
    })


    const emit = defineEmits([
        'update:showModal',
    ])

    const closeModal = () => emit('update:showModal', false)


    EventBus.on('deleteRecord', ()=>{
        closeModal()
    })


    const destroy = () => deleteRecord(props.recordId)


</script>

<template>

    <fwb-modal v-if="showModal" @close="closeModal" >

        <template #header>
            <p class="font-bold text-xl">Eliminar</p>
        </template>
        <template #body>
            <loading-body :isLoading="isLoading">
                <p class="text-lg">¿Está seguro de eliminar el registro?</p>
            </loading-body>
        </template>
        <template #footer>
            <div class="flex justify-end">
                <fwb-button @click="closeModal" color="alternative" class="mx-2">
                    Cancelar
                </fwb-button>
                <fwb-button @click="destroy" color="red" :disabled="isLoadingButton">
                    <fwb-spinner size="4" v-if="isLoadingButton"  class="inline mx-1"/>
                    Eliminar
                </fwb-button>
            </div>
        </template>
    </fwb-modal>
</template>