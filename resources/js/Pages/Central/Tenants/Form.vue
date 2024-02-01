<script setup>
    import { ref, watch } from 'vue'
    import { FwbButton, FwbModal, FwbInput, FwbSpinner } from 'flowbite-vue'
    import InputError from '@/Components/InputError.vue'

    import { useTenants } from '@/composables/central/tenants'
import EventBus from '@/Libs/EventBus';
    const { record, validationErrors, responseData, isLoading, getRecord, storeRecord } = useTenants()
    
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
    const form = ref({})

    watch(
        ()=> props.showModal,
        (newValue) => {
            if(newValue) openModal(newValue)
        }
    )

    const initForm = () => {
        form.value = {
            subdomain: '',
        }
    }

    const emit = defineEmits([
        'update:showModal',
    ])
    
    const closeModal = () => {
        initForm()
        emit('update:showModal', false)
    }


    const openModal = async () => {
        const id = props.recordId
        modalTitle.value = id ? 'Actualizar tenant' : 'Nuevo tenant'

        if(id)
        {
            form.value = await getRecord(id)
        }
    }

    EventBus.on('storeRecord', ()=>{
        console.log("storeRecord")
        closeModal()
    })


    const saveRecord = () => storeRecord({ ...form.value })

    initForm()

</script>

<template>

    <fwb-modal v-if="showModal" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg">
                {{ modalTitle }}
            </div>
        </template>
        <template #body>
            <fwb-input
                v-model="form.subdomain"
                label="Subdominio"
                :validation-status="validationErrors.subdomain ? 'error' : ''"
            />
            <input-error v-if="validationErrors.subdomain" :message="validationErrors.subdomain[0]"></input-error>
        </template>
        <template #footer>
            <div class="flex justify-end">
                <fwb-button @click="closeModal" color="alternative" class="mx-2">
                    Cancelar
                </fwb-button>
                <fwb-button @click="saveRecord" color="default">
                    <fwb-spinner size="4"  v-if="isLoading" style="display: inline;" class="mx-1"/>
                    Guardar
                </fwb-button>
            </div>
        </template>
    </fwb-modal>
</template>