import { reactive, ref } from 'vue'

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
    const records = ref([])
    const responseData = ref({
        success: false,
        message: null
    })

    const pagination = ref({})

    
    const customIndex = (index) => {
        return (pagination.per_page * (pagination.current_page - 1)) + index + 1
    }

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


    const getRecords = () => {
        
        showLoading()

        http.get(`/${resource.value}/records`)
            .then( (response) => {
                records.value = response.data.data
                
                pagination.value = response.data.meta
                pagination.per_page = parseInt(response.data.meta.per_page)
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


    const storeRecord = () => {
        
        showNProgress()
        isLoadingButton.value = true

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
                isLoadingButton.value = false
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
        initForm,
        isLoading,
        isLoadingButton,
        records,
        getRecord,
        getRecords,
        deleteRecord,
        storeRecord,
        validationErrors,
        responseData,
        form,
        pagination,
        customIndex
    }

}