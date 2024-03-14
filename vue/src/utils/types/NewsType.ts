export type NewsType = {
    id: number,
    title: string,
    content: string,
    create_date: {
      date: string,
      timezone_type: number,
      timezone: string
    }
  }
