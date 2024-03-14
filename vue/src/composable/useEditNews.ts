import { GetBackendUrl } from "@/utils/GetBackendUrl";
import axios from "axios";

type NewEditValuesType = {
    title: string,
    content: string,
}

export async function useEditNews (values: NewEditValuesType) {
    const url = GetBackendUrl();
    const status = await axios.post(url + '/news/edit', {
        title: values.title,
        content: values.content,
      }).then(response=> {
          return response.status;   
      }).catch(error => {
          console.error(error.response.data)
      });

    return status;
}
