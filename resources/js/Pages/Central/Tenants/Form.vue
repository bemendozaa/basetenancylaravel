<script setup>
    import { ref, watch } from 'vue'
    import { FwbButton, FwbModal, FwbInput } from 'flowbite-vue'
    import { useTenants } from '@/composables/central/tenants'
    const { getRecord, record } = useTenants()
    

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
    const name = ref('')

    const emit = defineEmits([
        'update:showModal',
    ])
    
    const closeModal = () => {
        emit('update:showModal', false)
    }

    watch(
        ()=> props.showModal,
        (newValue) => {
            if(newValue) openModal(newValue)
        }
    )

    const openModal = async () => {

        const id = props.recordId
        modalTitle.value = id ? 'Actualizar tenant' : 'Nuevo tenant'

        if(id)
        {
            await getRecord(id)
        }

    }
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
                v-model="name"
                placeholder="enter your first name"
                label="First name"
            />
        </template>
        <template #footer>
            <div class="flex justify-end">
                <fwb-button @click="closeModal" color="alternative" class="mx-2">
                    Cancelar
                </fwb-button>
                <fwb-button @click="closeModal" color="default">
                    Guardar
                </fwb-button>
            </div>
        </template>
    </fwb-modal>
</template>