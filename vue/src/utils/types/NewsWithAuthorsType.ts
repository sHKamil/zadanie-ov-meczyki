import type { NewsType } from "./NewsType"
import type { AuthorType } from "./AuthorType"

export type NewsWithAuthorsType = NewsType & {
    authors: Array<AuthorType>
  }
