import { GetBackendUrl } from "@/utils/GetBackendUrl";
import axios from "axios";

export async function useNewAuthor (name: string) {
    const url = GetBackendUrl();
    const status = await axios.post(url + '/author/add', {
        name: name,
      }).then(response=> {
          return response.status;   
      }).catch(error => {
          console.error(error.response.data)
      });

    return status;
}
