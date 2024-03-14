import { GetBackendUrl } from "@/utils/GetBackendUrl";
import axios from "axios";

export async function useAddAuthorToNews (article_id: number, author_id: number) {
    const url = GetBackendUrl();
    const status = await axios.post(url + '/news/author/add', {
        article_id: article_id,
        author_id:author_id,
      }).then(response=> {
          return response.status;   
      }).catch(error => {
          console.error(error.response.data)
      });

    return status;
}
