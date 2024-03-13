import { GetBackendUrl } from "@/utils/GetBackendUrl";
import axios from "axios";

type NewNewsValuesType = {
    title: string,
    content: string,
    author: number
}

export async function useNewNews (values: NewNewsValuesType) {
    const url = GetBackendUrl();
    const status = await axios.post(url + '/news/add', {
        title: values.title,
        content: values.content,
        authors: [values.author],
      }).then(response=> {
          return response.status;   
      }).catch(error => {
          console.error(error.response.data)
      });
    
    return status;
}
