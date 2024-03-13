import type { NewsType } from "./NewsType"
import type { AuthorType } from "./AuthorType"

export type AuthorWtihArticlesType = AuthorType & {
    articles: Array<NewsType>
  }
