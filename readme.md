Szenario:
Imagine your friend - the owner of a small book shop - asks you for a simple representation of his latest sales.
He provides you a simple plain json export file.

What you need to do?:
- Design a database scheme for optimized storage
- Read the json data and save it to the database using php
- Create a simple page with filters for customer, product and price
- Output the filtered results in a table below the filters
- Add a last row for the total price of all filtered entries

Additional information:
The shop system changed the timezone of the sales date.
Prior to version 1.0.17+60 it was Europe/Berlin.
Afterwards it is UTC. Please provide a tested class for the version comparison.

Environment:
PHP 7, MySQL / MariaDB

This code challenge shouldn't take more than 90 minutes.
KISS - Keep it simple stupid performant and secure!

Please code in plain PHP, no Framework allowed!

How to start the project

- Run 
 ``docker compose up``

- Run ``docker exec -it php bash``

### Inside the container
- Run  ``cd /scripts && php migration.php``
- Run ``cd /scripts && php seeder.php``

### Run app in browser
- Open ``http://localhost:80`` in your browser