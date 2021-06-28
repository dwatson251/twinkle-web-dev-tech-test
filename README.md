# Twinkl - Web Dev - Web Support (WS) tech exercise V1

Welcome to the WS tech exercise.

---

## About the application

This is a small project, developed using MVC principles.

The Backend is PHP:
- It is primarily bespoke code.
- Includes [Laravel database & routing](https://laravel.com/docs/7.x/routing) libraries for routing and DB abstraction.
- Includes [League/Plates](https://platesphp.com/) library to provide view templates system.  

The Frontend is JS ES6 / ES2015:
- Uses combination of [Webpack](https://webpack.js.org/guides/getting-started/) and [Babel](https://babeljs.io/docs/en/configuration) to transpile to native JS and CSS.
- Uses SCSS / SASS for stylesheets.

---

## Getting started

To get started you will require the following installed:

1. Local PHP environment (v7.2) - [XAMPP](https://www.apachefriends.org/download.html) from apache friends is one we used.
2. Local MYSQL server - [XAMPP](https://www.apachefriends.org/download.html) from apache friends can provide this.
3. Node (^ v11.15.*)
4. NPM (^ v6.7)
5. Composer (^ v1.9)

## Initialising app

### Database

SQL scripts for the DB structure used in this test, can be found: "**backend/database**". Please execute the scripts via your MYSQL server / IDE.

### Code

1. Open Terminal / Command prompt / Bash UI
2. Navigate to "twinkl-onboard-mid-web-dev/backend", and execute `composer install` to install PHP dependencies.
3. Navigate to "twinkl-onboard-mid-web-dev/frontend", and execute `npm install` to install JS dependencies.
4. Execute `npm run build` to build the distributables into the "/public" folder.

---

## Exercises

### 1.

There is a bug when loading the application, please debug and resolve so the users appear on the main page.

### 2.

Not all of the available users appear on the dashboard and there is a duplicate user. The DB data is currently correct, please investigate the code and amend the bug causing a limited amount of users and a duplicate to appear.

### 3.

There is a bug when clicking "Add User", please resolve to enable a widget to appear for creating a user.

### 4.

Currently the "Update" button for existing users is not operational. Please implement the JS & PHP required to update a user's details.

### 5.

Currently the SQL schema for the database & tables (see **./database/tables**) have not been optimised for queries. Please amend the schema so ensure optimum performance on the most common queries / operations. 
 
