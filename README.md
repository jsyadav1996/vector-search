## Project Setup guide

- Clone repository "git clone https://github.com/jsyadav1996/vector-search.git"
- cd to repository and do "composer install" and "npm install"
- Create .env file in root folder, copy from .env.example
- Set the DB_USERNAME, DB_PASSWORD, and COHERE_API_KEY in .env file.
- Run the migration using command "php artisan migrate"
- Run the project with command "composer run dev".

## Import excel file

- Put the excel file in "storage/app" path. **Use the same file with same name from email** i.e "Lynx_Keyword_Enhanced_Services.xlsx"
- Run the import command "php artisan import:categories"

## Access/test the semantic search functionality

- Access "/search" page.
- Put some text and see.

**For COHERE_API_KEY, check in email.**