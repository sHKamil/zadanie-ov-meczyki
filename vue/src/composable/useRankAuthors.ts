import { GetBackendUrl } from "@/utils/GetBackendUrl";
import type { AuthorInRank } from '@/utils/GetRank';
import { useFetch, type UseFetchReturn, type AfterFetchContext } from "@vueuse/core";
import { watchEffect } from "vue";

export function useRankAuthors (top: number) {
    const url = GetBackendUrl();
    const authors = useFetch(url + '/author/top/' + top, {
        afterFetch(ctx: AfterFetchContext<AuthorInRank[]>) {
            return ctx;
        }
    }).get().json() as UseFetchReturn<AuthorInRank[]>;

    return { authors };
}