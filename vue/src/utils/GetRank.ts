import axios from "axios";
import { GetBackendUrl } from "./GetBackendUrl";

export type AuthorInRank = {
  id: number,
  name: string,
  news_count: number
}

export async function GetAuthorsInRank(top :number) : Promise<AuthorInRank[]> {
  let authors: AuthorInRank[] = [];
  const backend_domain = GetBackendUrl();
  const data = await axios.get(backend_domain + '/author/top/' + top);
        data.data.forEach((author: AuthorInRank) => authors.push(author));

  return authors;
}
