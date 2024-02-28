<script setup>

import { ref, onMounted } from 'vue'
import { FwbInput, FwbPagination, FwbSelect } from 'flowbite-vue'
import EventBus from '../Libs/EventBus'
import LoadingBody from '@/Components/LoadingBody.vue'
import { useDataTable } from '@/composables/main/useDataTable'

const props = defineProps({
    resource: {
        type: String,
        required: true,
    },
    columns: {
        type: Number,
        required: true,
    },
    simpleDataTable: {
        type: Boolean,
        required: false,
        default: false,
    },
})

EventBus.on('reloadData', () => getRecords())

const context = { resource: props.resource }

const { getRecords, records, isLoading, pagination, customIndex, searchColumns, searchForm, getSearchColumns } = useDataTable(context)

onMounted(async () => {
    
    if(!props.simpleDataTable) await getSearchColumns()
    
    await getRecords()
})

const changeColumn = () => searchForm.value.value = ''

</script>

<template>

    <loading-body :isLoading="isLoading">
        
        <div class="flex mb-3" v-if="!simpleDataTable">
            <div class="w-1/5">
                <fwb-select
                    v-model="searchForm.column"
                    :options="searchColumns"
                    @change="changeColumn"
                />
            </div>

            <div class="w-1/3">
                <fwb-input
                    v-model="searchForm.value"
                    @input="getRecords"
                    class="ml-1"
                    placeholder="Buscar"
                >
                </fwb-input>
            </div>
        </div>
    
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    
                    <slot
                        name="head"
                    >
                    </slot>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    <slot
                        name="body"
                        v-for="(row, index) in records"
                        :row="row"
                        :index="customIndex(index)"
                    >
                    </slot>
                    
                    <tr v-if="records.length === 0">
                        <td class="border border-slate-300 px-4 py-2 text-center" :colspan="columns">
                            Sin datos
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-5">

            <fwb-pagination 
                v-model="pagination.current_page" 
                :total-pages="pagination.last_page"
                :per-page="pagination.per_page" 
                previous-label="<<<" 
                next-label=">>>"
                @update:model-value="getRecords()"
                >
            </fwb-pagination>

            <p class="mt-2 font-bold" v-if="records.length > 0">
                Mostrando {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }}
            </p>

        </div>
    </loading-body>

</template>
