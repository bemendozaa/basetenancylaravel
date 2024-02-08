<script setup>

    import { ref } from 'vue'
    import { FwbButton, FwbModal, FwbSpinner } from 'flowbite-vue'
    import { useToast } from 'vue-toastification'

    import EventBus from '@/Libs/EventBus'
    import { useDelete } from '@/composables/main/useDelete'


    const { deleteRecord, isLoading, isLoadingButton } = useDelete()
    const toast = useToast()
    

    const props = defineProps({
        url: {
            type: String,
            required: true
        },
        showModal: {
            type: Boolean,
            required: true
        },
    })


    const emit = defineEmits([
        'update:showModal',
    ])

    EventBus.on('deleteRecord', (responseData) => processDestroy(responseData))


    const closeModal = () => emit('update:showModal', false)


    const processDestroy = (responseData) => {
        
        if(responseData.value.success)
        {
            toast.success(responseData.value.message)
            closeModal()
            return
        }

        toast.error(responseData.value.message)
    }
    

    const destroy = () => deleteRecord(props.url)


</script>

<template>

    <fwb-modal v-if="showModal" @close="closeModal" >

        <template #header>
            <p class="font-bold text-xl">Eliminar</p>
        </template>
        <template #body>
            <p class="text-lg">¿Está seguro de eliminar el registro?</p>
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