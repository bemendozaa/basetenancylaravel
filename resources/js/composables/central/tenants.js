import { reactive, ref } from 'vue'
import { useGeneralFunction } from '@/composables/main/useGeneralFunction'
import  http from '@/helpers/http'
const { showNProgress, hideNProgress } = useGeneralFunction()


export function useTenants() 
{
    const isLoading = ref(false)
    const records = ref([])
    const record = ref({})

    const responseData = reactive({
        success: false,
        message: null
    })

    
    const getRecord = async (id) => {
        
        showNProgress()

        await http.get(`/tenants/record/${id}`)
                .then((response)=>{
                    record.value = response.data
                })
                .finally(()=>{
                    hideNProgress()
                })
    }


    const getRecords = () => {
        
        showNProgress()

        http.get('/tenants/records')
            .then((response)=>{
                records.value = response.data
            })
            .finally(()=>{
                hideNProgress()
            })
    }

    
    const store = (form) => {
        
        showNProgress()

        http.post('/tenants/store', form)
            .then( (response) => {
                if(response.data.success)
                {
                    console.log(response.data.message)
                    getRecords()
                }
                else
                {
                    console.log("no eliminado")
                }
            })
            .finally(()=>{
                hideNProgress()
            })
    }


    const deleteTenant = (id) => {
        console.log("deleteTenant")
        showNProgress()
        
        http.delete(`/tenants/${id}`)
            .then((response)=>{
                console.log(response)
    
                if(response.data.success)
                {
                    console.log(response.data.message)
                    getRecords()
                }
                else
                {
                    console.log("no eliminado")
                }
            })
            .finally(()=>{
                hideNProgress()
            })
    }
    

    return {
        isLoading,
        records,
        getRecords,
        record,
        getRecord,
        deleteTenant,
        store
    }
}