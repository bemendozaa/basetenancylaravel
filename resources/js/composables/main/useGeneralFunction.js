import NProgress from 'nprogress'

export function useGeneralFunction() 
{

    const showNProgress = () => NProgress.start()

    const hideNProgress = () => NProgress.done()

    const parseValidationErros = (error, validationErrors) => {
        
        if (error.response.status === 422) 
        {
            validationErrors.value = error.response.data.errors
        } 
        else 
        {
            console.log(error)
        }
    }

    return {
        showNProgress,
        hideNProgress,
        parseValidationErros
    }
}