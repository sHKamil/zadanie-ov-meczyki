import { GetBackendUrl } from "@/utils/GetBackendUrl";
import type { AuthorWtihArticlesType } from "@/utils/types/AuthorWtihArticlesType"; 
import { useFetch, type UseFetchReturn, type AfterFetchContext } from "@vueuse/core";

export function useAuthors () {
    const url = GetBackendUrl();
    const authors = useFetch(url + '/authors', {
        afterFetch(ctx: AfterFetchContext<AuthorWtihArticlesType[]>) {
            return ctx;
        }
    }).get().json() as UseFetchReturn<AuthorWtihArticlesType[]>;
    
    return { authors };
}
