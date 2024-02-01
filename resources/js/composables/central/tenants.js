import { reactive, ref } from 'vue'

import EventBus from '../../Libs/EventBus'
import  http from '@/helpers/http'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'

const { showNProgress, hideNProgress, parseValidationErros } = useGeneralFunction()


export function useTenants() 
{
    const validationErrors = ref({})
    const isLoading = ref(false)
    const resource = ref('tenants')
    const records = ref([])
    const responseData = ref({
        success: false,
        message: null
    })

    
    const getRecord = async (id) => {
        
        showNProgress()

        const response = await http.get(`/${resource.value}/record/${id}`)
        
        hideNProgress()
        
        return response.data.data
                
    }


    const getRecords = () => {
        
        showNProgress()

        http.get(`/${resource.value}/records`)
            .then( (response) => {
                records.value = response.data
            })
            .finally(() => hideNProgress())

    }

    
    const storeRecord = (form) => {
        
        showNProgress()
        isLoading.value = true

        http.post(`/${resource.value}`, form)
            .then( (response) => {

                responseData.value = response.data
                EventBus.emit('reloadData')
                EventBus.emit('storeRecord')

            })
            .catch(error => {
                parseValidationErros(error, validationErrors)
            })
            .finally(() => {
                hideNProgress()
                isLoading.value = false
            })
    }


    const deleteRecord = (id) => {

        showNProgress()
        
        http.delete(`/${resource.value}/${id}`)
            .then( (response) => {
                
                responseData.value = response.data
                EventBus.emit('reloadData')

            })
            .finally(() => hideNProgress())
    }
    

    return {
        isLoading,
        records,
        getRecord,
        getRecords,
        deleteRecord,
        storeRecord,
        validationErrors,
        responseData,
    }

}