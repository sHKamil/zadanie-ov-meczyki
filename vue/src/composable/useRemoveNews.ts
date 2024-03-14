import { GetBackendUrl } from "@/utils/GetBackendUrl";
import axios from "axios";

export async function useRemoveNews (id: number) {
    const url = GetBackendUrl();
    const status = await axios.post(url + '/news/delete', {
        id: id,
      }).then(response=> {
          return response.status;   
      }).catch(error => {
          console.error(error.response.data)
      });

    return status;
}
