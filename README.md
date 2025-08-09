# Mockup for Lácteos Superior

This project is a virtual catalog for "Lácteos Superior" a brand of Inversiones Fasulac Ltda. The mockup was created to analyze and address some of the brand's needs. It includes features for managing queries, orders, and products, and is programmed in PHP, JavaScript, HTML, and Tailwind CSS. Initially, the database was in Oracle SQL but has been migrated to MySQL.

**Disclamer**: All photos, names, logos referring to "Lácteos Superior" are property of Inversiones Fasulac Ltda and the other trademark logos are the owners of their own logos. "Lácteos Superior" is a brand of Inversiones Faulac Ltda.

## Features

- **Virtual Catalog**: Browse and view products with comments and valoratys.
- **Query Management**: Handle customer inquiries.
- **Order Management**: Process and manage orders.
- **Product Management**: Create, Read, Update and Delete products and categories.

## Technologies Used

- PHP
- JavaScript
- HTML
- Tailwind CSS
- MySQL

## Screenshots

**Landing Page**
![Landing page 1](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/3331dcf6-6502-4442-90e4-b15ca5cae1e2)

![Landing page 2](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/741b5433-1df0-465d-8be0-35356a33e8ad)

![Landing page 3](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/92a199c7-0be7-4a0c-9fb3-12b1ada0f681)

**Catalogue**
![catalogue](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/46c70139-8d68-4648-ae5c-b9f70d3c998f)

**View Product**
![view product](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/41d937ad-c3fe-4fd9-9712-2ae8a4f17358)

![view product 2](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/b1aaee74-6f3d-433a-a524-79844775675e)

**Details Order**
![confirm order](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/6d3d038d-11b0-4607-9925-c2cc6d220f99)

**Product Management**
![admin panel of products](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/ef8b4e6b-e944-4e9e-9d50-923900896e5a)

**Categories Management**
![categories form](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/9cb8a510-4d81-4ddc-860b-852347d1e09b)

**Contact Form**
![contact form](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/4e51fee1-ddde-476c-bc97-59e8a8b64323)

**Consultations**
![consultation](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/0a62746e-b352-4aa4-8087-bc2d55899c91)

**Details About the Order**
![details about the order](https://github.com/JoseDHernandez/cinema-in-java/assets/128190435/f1747917-87d5-4e4e-aa45-1346cb82da64)

## Installation

1.  Clone the repository:
    `git clone https://github.com/JoseDHernandez/Lacteos-superior`
2.  Import `lacteos.sql` (the sql archive) to you sql database manager
3.  Modify the variables in `DATABASE.php` as follows: `$_SERVER` is the server route, `$_DATABASE_NAME` is the database name, `$_USER_DB` is the database user, and `$_PASSWORD_DB` is the password for your account according to the user (`$_USER_DB`).
4.  Enter the URL of your host. For example: `http://localhost/Lacteos/`
5.  In the `usuario` database table, you can view the credentials for accessing the application. The `contrasena` column represents the password, and the `email` column represents the email address. Below, you will find the test accounts.

    - Admin account:

      - Email address: ana@example.com
      - Password: securepass

    - Client account:
      - Email address: juan@example.com
      - Password: password

## Author

<p>
This project is developed by José Hernández.  <a href="https://github.com/JoseDHernandez" target="blank"><img align="center"
         src="https://img.shields.io/badge/github-181717.svg?style=for-the-badge&logo=github&logoColor=white"
         alt="GitHub" height="30"/></a>
</p>

## License

All photos, names, logos referring to "Lácteos Superior" are property of Inversiones Fasulac Ltda and the other trademark logos are the owners of their own logos. "Lácteos Superior" is a brand of Inversiones Faulac Ltda.

<p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://github.com/JoseDHernandez/Lacteos-superior">Mockup for Lácteos Superior</a> by <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/JoseDHernandez">José David Hernández Hortúa</a> is licensed under <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-NC-ND 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1" alt=""><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1" alt=""><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nc.svg?ref=chooser-v1" alt=""><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nd.svg?ref=chooser-v1" alt=""></a></p>
