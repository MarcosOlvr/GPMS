<h1 align="center"> GPMS </h1>

## Setup
- PHP (_Laravel_)
- MySQL
- VueJs

## Install
1. Clone the repository
```
$ git clone  https://github.com/MarcosOlvr/gpms
```

2. Access the folder
```
$ cd gpms
```

3. Install PHP libraries
```
$ composer install
```

4. Install VueJs dependencies
```
$ npm i
```

### Migrations
1. Remember to change the DB infos in the .env file
2. Running migration
```
$ php artisan migrate
```
3. Running seeders
```
$ php artisan db:seed
```
### Run the app
``` 
$ php artisan serve
```
``` 
$ npm run dev
```

## Endpoints

### Get project
_GET /{project_id}_

### Get list of projects
_GET /list_

_GET /list?page={page}_

### Create project
_POST /store_

### Update project
_PUT /update/{project}_

### Delete project
_DELETE /delete/{project}_

## Frontend

### Project list
![project list](./images/img01.png)
![project list2](./images/img02.png)
If you don't have a project 
![projects not found](./images/img06.png)

### Create a project
![create a project](./images/img03.png)

### Edit a project
![edit a project](./images/img04.png)

### Delete a project
![delete a project](./images/img05.png)