import { ref } from 'vue'

import EventBus from '../../Libs/EventBus'
import  http from '@/helpers/http'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'

const { showNProgress, hideNProgress, parseValidationErros } = useGeneralFunction()


export function useTenants() 
{
    const form = ref({})
    const validationErrors = ref({})
    const isLoading = ref(false)
    const isLoadingButton = ref(false)
    const resource = ref('tenants')
    const responseData = ref({})
    const httpExecuted = ref(false)

    const initForm = () => {

        form.value = {
            subdomain: '',
            email: '',
            password: '',
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
                    httpExecuted.value = true

                })
                .catch(error => {
                    parseValidationErros(error, validationErrors)
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
        httpExecuted,
        getRecord,
        initForm,
        storeRecord,
    }

}