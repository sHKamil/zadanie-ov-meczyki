# Content of the recruitment task
```
Data structure

1. News entity with at least title, text and creation date fields.
2. News author entity with at least name field.
3. Articles can have multiple authors

API Endpoints
1. Get article by some id
2. Get all articles for given author
3. Get top 3 authors that wrote the most articles last week.

Requirements:
1. You should include README file with everything we need to know on how to run and "use" your
project.
2. All necessary initial database operations (such as creating tables, inserting fixtures, etc.) should
be done in a single .sql file if needed
3. HTML form should allow us to at least add / edit news articles. List of authors can be hardcoded
into database.
```

# Requirements
- Docker (i was using 25.0.2 version)

# How to start
1. Clone repository
2. Go to the main directory of downloaded repository ``` cd path/to/repository ```
3. ``` docker compose up -d --build ```
