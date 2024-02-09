<script setup>

    import { ref } from 'vue'
    import { FwbButton } from 'flowbite-vue'
    
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import RecordForm from '@/Pages/Tenant/Items/Form.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Delete from '@/Components/Delete.vue'
    import { useMainStore } from '@/Stores/main.js'


    const showModal = ref(false)
    const showModalDelete = ref(false)
    const recordId = ref(null)
    const resource = ref('items')
    const urlDelete = ref('')

    const clickNewRecord = (id = null) => {
        recordId.value = id
        showModal.value = true
    }
    
    const clickDelete = (id = null) => {
        urlDelete.value = `/${resource.value}/${id}`
        showModalDelete.value = true
    }


</script>

<template>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Productos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="flex items-center gap-4 mt-3 mb-5">
                            <fwb-button color="default" @click="clickNewRecord()">Nuevo</fwb-button>
                        </div>
                        <hr>

                        <DataTable
                            class="mt-5"
                            :resource="resource"
                            :columns="4"
                        >
                            <template v-slot:head>
                                <tr>
                                    <th class="border border-slate-300 py-2">#</th>
                                    <th class="border border-slate-300 py-2">Nombre</th>
                                    <th class="border border-slate-300 py-2">Precio</th>
                                    <th class="border border-slate-300 py-2"></th>
                                </tr>
                            </template>

                            <template #body="{ index, row }">
                                <tr>
                                    <td class="border border-slate-300 px-3">
                                        {{ index }}
                                    </td>
                                    <td class="border border-slate-300 px-3">
                                        {{ row.name }}
                                    </td>
                                    <td class="border border-slate-300 px-3">
                                        {{  row.price }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">
                                        
                                        <fwb-button color="default" size="sm" class="mx-2" @click="clickNewRecord(row.id)">Actualizar</fwb-button>

                                        <fwb-button color="red" size="sm" @click="clickDelete(row.id)">Eliminar</fwb-button>

                                    </td>
                                </tr>
                            </template>

                        </DataTable>

                    </div>
                </div>
            </div>
        </div>
        
        <record-form 
            v-model:showModal="showModal"
            :recordId="recordId"
        >
        </record-form>
        
        <delete 
            v-model:showModal="showModalDelete"
            :url="urlDelete"
        >
        </delete>

    </AuthenticatedLayout>
</template>
