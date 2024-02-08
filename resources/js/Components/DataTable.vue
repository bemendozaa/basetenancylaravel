<script setup>

import { ref, onMounted } from 'vue'
import { FwbPagination } from 'flowbite-vue'

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
})

EventBus.on('reloadData', () => getRecords())

const context = { resource: props.resource }

const { getRecords, records, isLoading, pagination, customIndex } = useDataTable(context)

onMounted(() => {
    getRecords()
})

</script>

<template>

    <loading-body :isLoading="isLoading">
        <table class="border-collapse border border-slate-400" style="width: 100%;">
            <thead>
                <slot
                    name="head"
                >
                </slot>
            </thead>
            <tbody>
                
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

            <p class="mt-2 font-bold">
                Mostrando {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }}
            </p>

        </div>
    </loading-body>

</template>
