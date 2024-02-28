import { ref } from 'vue'
import queryString from 'query-string'

import  http from '@/helpers/http'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'
const { showNProgress, hideNProgress } = useGeneralFunction()


export function useDataTable(context) 
{
    const isLoading = ref(false)
    const records = ref([])
    const searchColumns = ref([])

    const searchForm = ref({
        column: '',
        value: ''
    })

    const pagination = ref({
        current_page: 1
    })


    const customIndex = (index) => (pagination.value.per_page * (pagination.value.current_page - 1)) + index + 1

    
    const getQueryParameters = () => {

        return queryString.stringify({
            page: pagination.value.current_page,
            ...searchForm.value
        })
    }

    const getSearchColumns = async () => {
        
        showNProgress()
        isLoading.value = true

        await http.get(`/${context.resource}/columns`)
                .then( (response) => {
                    searchColumns.value = response.data
                    searchForm.value.column = searchColumns.value.length > 0 ? searchColumns.value[0].value : ''
                })
                .finally(() => {
                    hideNProgress()
                    isLoading.value = false
                })
    }

    
    const getRecords = async () => {
        
        showNProgress()
        isLoading.value = true

        await http.get(`/${context.resource}/records?${getQueryParameters()}`)
                .then( (response) => {
                    records.value = response.data.data
                    pagination.value = response.data.meta
                    pagination.per_page = parseInt(response.data.meta.per_page)
                })
                .finally(() => {
                    hideNProgress()
                    isLoading.value = false
                })

    }

    return {
        searchColumns,
        searchForm,
        isLoading,
        pagination,
        records,
        customIndex,
        getRecords,
        getSearchColumns
    }
}