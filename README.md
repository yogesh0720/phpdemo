# Build a REST API in PHP

**Prerequisites:** PHP, Composer, MySQL, Postman

## Getting Started

Clone this project using the following commands:

```
git@github.com:yogesh0720/phpdemo.git
cd phpdemo
```

### Configure the application

Create the database and table for the project:

```
CREATE DATABASE `phpdemo_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `post_title_IDX` (`title`) USING BTREE,
   KEY `post_author_IDX` (`author`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1011574 DEFAULT CHARSET=utf8;
```

Edit the `.env` file and enter your database details:

```
.env
```
### Configure the application
Create fake sample data using by the `postFaker.php` file

1 Million (10,00,000) record will be created.

Please execute the on different php server.

```
e.g.
http://localhost:8888/postFaker.php
```


## Development

Install the project dependencies and start the PHP server:

```
composer install
```

```
php -S localhost:8000 -t api
```


## Your APIs

| API               |    CRUD    |                                Description |
| :---------------- | :--------: | -----------------------------------------: |
| GET /post        |  **READ**  |        Get all the Posts from `post` table |
| GET /post/{id}    |  **READ**  |        Get a single Post from `post` table |
| POST /post        | **CREATE** | Create a Post and insert into `post` table |
| PUT /post/{id}    | **UPDATE** |            Update the Post in `post` table |
| DELETE /post/{id} | **DELETE** |            Delete a Post from `post` table |

Test the API endpoints using [Postman](https://www.postman.com/).
Loading [http://localhost:8000/post](http://localhost:8000/post) 
