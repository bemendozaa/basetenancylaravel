import NProgress from 'nprogress'

export function useGeneralFunction() 
{

    function showNProgress() 
    {
        NProgress.start()
    }

    function hideNProgress() 
    {
        NProgress.done()
    }

    return {
        showNProgress,
        hideNProgress,
    }
}