<script setup>

    import { ref } from 'vue'
    import { FwbButton, FwbModal, FwbToast, FwbSpinner  } from 'flowbite-vue'

    import LoadingBody from '@/Components/LoadingBody.vue'
    import { useTenants } from '@/composables/central/tenants'
    import EventBus from '@/Libs/EventBus'

    const { deleteRecord, isLoading, isLoadingButton, responseData } = useTenants()
    
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

    // const toast = useToast()

    EventBus.on('deleteRecord', () => {

        console.log("e deleteRecord")
        const response = responseData.value
        
        if(response.success)
        {

            closeModal()
        }
    })


    const destroy = () => deleteRecord(props.recordId)


</script>

<template>

            
    <!-- <div class="xl:w-1/6 md:w-1/4 sm:w-1/4 fixed top-3 right-3 flex flex-col gap-2 z-50" v-if="responseData.success != undefined">
        <fwb-toast closable :type="responseData.success ? 'success' : 'danger'">
            {{ responseData.message }}
        </fwb-toast>
    </div> -->

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