import { reactive, ref } from 'vue'

import EventBus from '../../Libs/EventBus'
import  http from '@/helpers/http'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'
// import queryString from 'query-string'

const { showNProgress, hideNProgress, parseValidationErros } = useGeneralFunction()


export function useTenants() 
{
    const form = ref({})
    const validationErrors = ref({})
    const isLoading = ref(false)
    const isLoadingButton = ref(false)
    const resource = ref('tenants')
    const responseData = ref({
        success: false,
        message: null
    })

    const initForm = () => {

        form.value = {
            subdomain: '',
        }

        validationErrors.value = {}
    }


    const getRecord = async (id) => {
        
        showLoading()

        await http.get(`/${resource.value}/record/${id}`)
            .then( (response) => {
                form.value = response.data.data
            })
            .finally(() => {
                hideLoading()
            })
    }


    const showLoading = () => {
        showNProgress()
        isLoading.value = true
    }

    
    const hideLoading = () => {
        hideNProgress()
        isLoading.value = false
    }


    const storeRecord = async () => {
        
        showNProgress()
        isLoadingButton.value = true

        await http.post(`/${resource.value}`, form.value)
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
                    isLoadingButton.value = false
                })
    }


    const deleteRecord = (id) => {

        showNProgress()
        isLoadingButton.value = true
        
        http.delete(`/${resource.value}/${id}`)
            .then( (response) => {
                
                responseData.value = response.data
                EventBus.emit('reloadData')
                EventBus.emit('deleteRecord')

            })
            .finally(() => {
                hideNProgress()
                isLoadingButton.value = false
            })
    }
    

    return {
        form,
        isLoading,
        isLoadingButton,
        responseData,
        validationErrors,
        deleteRecord,
        getRecord,
        initForm,
        storeRecord,
    }

}