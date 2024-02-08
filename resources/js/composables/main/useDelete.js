import { ref } from 'vue'
import  http from '@/helpers/http'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'
import EventBus from '@/Libs/EventBus'
const { showNProgress, hideNProgress } = useGeneralFunction()


export function useDelete(url) 
{

    const responseData = ref({})
    const isLoadingButton = ref(false)


    const deleteRecord = (url) => {

        showNProgress()
        isLoadingButton.value = true
        
        http.delete(url)
            .then( (response) => {
                
                responseData.value = response.data
                EventBus.emit('reloadData')

            })
            .catch(error => {
                
                responseData.value = {
                    success: false,
                    message: error.response.data.message
                }

            })
            .finally(() => {
                EventBus.emit('deleteRecord', responseData)
                hideNProgress()
                isLoadingButton.value = false
            })
    }
    

    return {
        isLoadingButton,
        deleteRecord,
    }

}