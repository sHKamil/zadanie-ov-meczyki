import type { AuthorType } from "./AuthorType"

export type AuthorInRank = AuthorType & {
  news_count: number
}
