import { ref } from 'vue'
import queryString from 'query-string'

import  http from '@/helpers/http'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'
const { showNProgress, hideNProgress } = useGeneralFunction()


export function useDataTable(context) 
{
    const isLoading = ref(false)
    const records = ref([])

    const search = ref({
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
            ...search.value
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
        isLoading,
        pagination,
        records,
        customIndex,
        getRecords,
    }
}