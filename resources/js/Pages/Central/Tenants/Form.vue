<script setup>
    import { ref, watch } from 'vue'
    import { FwbButton, FwbModal, FwbInput, FwbSpinner } from 'flowbite-vue'
    import { useToast } from 'vue-toastification'

    import InputError from '@/Components/InputError.vue'
    import LoadingBody from '@/Components/LoadingBody.vue'
    import { useTenants } from '@/composables/central/tenants'


    const emit = defineEmits([
        'update:showModal',
    ])

    const { form, validationErrors, responseData, httpExecuted, isLoading, isLoadingButton, initForm, getRecord, storeRecord } = useTenants()
    const toast = useToast()
    

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


    const modalTitle = ref('')

    watch(httpExecuted, (value) => processHttpResponse(value))

    watch(
        ()=> props.showModal,
        (newValue) => {
            if(newValue) openModal(newValue)
        }
    )

    
    const closeModal = () => {
        initForm()
        emit('update:showModal', false)
    }


    const openModal = async () => {
        const id = props.recordId
        modalTitle.value = id ? 'Actualizar tenant' : 'Nuevo tenant'

        if(id)
        {
            await getRecord(id)
        }
    }


    const processHttpResponse = (value) => {

        if(!value) return

        httpExecuted.value = false

        if(responseData.value.success)
        {
            toast.success(responseData.value.message)
            closeModal()
            return
        }

        toast.error(responseData.value.message)
    }


    const saveRecord = () => storeRecord()

    initForm()

</script>

<template>

    <fwb-modal v-if="showModal" @close="closeModal" >

        <template #header>
            {{ modalTitle }}
        </template>
        <template #body>
            <loading-body :isLoading="isLoading">

                <fwb-input
                    v-model="form.subdomain"
                    label="Subdominio"
                    :validation-status="validationErrors.subdomain ? 'error' : ''"
                    />
                <input-error v-if="validationErrors.subdomain" :message="validationErrors.subdomain[0]"></input-error>
                
                <fwb-input
                    v-model="form.email"
                    label="Correo electrónico"
                    :validation-status="validationErrors.email ? 'error' : ''"
                    />
                <input-error v-if="validationErrors.email" :message="validationErrors.email[0]"></input-error>
                
                <fwb-input
                    v-model="form.password"
                    label="Contraseña"
                    :validation-status="validationErrors.password ? 'error' : ''"
                    />
                <input-error v-if="validationErrors.password" :message="validationErrors.password[0]"></input-error>

            </loading-body>
        </template>
        <template #footer>
            <div class="flex justify-end">
                <fwb-button @click="closeModal" color="alternative" class="mx-2">
                    Cancelar
                </fwb-button>
                <fwb-button @click="saveRecord" color="default" :disabled="isLoadingButton">
                    <fwb-spinner size="4" v-if="isLoadingButton"  class="inline mx-1"/>
                    Guardar
                </fwb-button>
            </div>
        </template>
    </fwb-modal>
</template>