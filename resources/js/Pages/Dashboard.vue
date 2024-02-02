<script setup>

    import { Head } from '@inertiajs/vue3'
    import { reactive, ref } from 'vue'
    import { FwbButton,FwbPagination  } from 'flowbite-vue'
    
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TenantForm from '@/Pages/Central/Tenants/Form.vue'
    import EventBus from '../Libs/EventBus'
    import LoadingBody from '@/Components/LoadingBody.vue'

    import { useTenants } from '@/composables/central/tenants'

    const { getRecords, records, deleteRecord, isLoading, pagination, customIndex } = useTenants()

    const showModal = ref(false)
    const recordId = ref(null)

    const clickNewRecord = (id = null) => {
        recordId.value = id
        showModal.value = true
    }

    getRecords()

    EventBus.on('reloadData', ()=>{

        console.log("on reloadData")
        getRecords()
    })

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <loading-body :isLoading="isLoading">

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <div class="flex items-center gap-4 mt-3">
                                <fwb-button color="default" @click="clickNewRecord()">Nuevo</fwb-button>
                            </div>

                            <br>
                            <hr>
                            <br>

                            <table class="border-collapse border border-slate-400" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="border border-slate-300 py-2">id</th>
                                        <th class="border border-slate-300 py-2">name</th>
                                        <th class="border border-slate-300 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in records">
                                        <td class="border border-slate-300 px-3">
                                            {{ row.id }}
                                        </td>
                                        <td class="border border-slate-300 px-3">
                                            {{  row.tenancy_db_name }}
                                        </td>
                                        <td class="border border-slate-300 px-4 py-2">
                                            
                                            <fwb-button color="default" size="sm" class="mx-2" @click="clickNewRecord(row.id)">Actualizar</fwb-button>

                                            <fwb-button color="red" size="sm" @click="deleteRecord(row.id)">Eliminar</fwb-button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-5">
                                <fwb-pagination 
                                    v-model="pagination.current_page" 
                                    :total-pages="pagination.last_page" 
                                    :per-page="pagination.per_page" 
                                    previous-label="<<<" 
                                    next-label=">>>"
                                    >
                                </fwb-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </loading-body>
        
        <tenant-form 
            v-model:showModal="showModal"
            :recordId="recordId"
        >
        </tenant-form>

    </AuthenticatedLayout>
</template>
