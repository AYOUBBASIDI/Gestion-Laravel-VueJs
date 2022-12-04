# Gestion-Laravel-VueJs

## How to run the project

1. Clone the project

```bash
git clone
```

2. Enter Frontend

```bash
cd frontend
```

2. Install dependencies

```bash
npm install
```

2. Run the Frontend

```bash
npm run dev
```

2. Enter Backend

```bash
cd backend
```

3. Install dependencies 

```bash
composer install
```

3. Run

```bash
cp .env.example .env or copy .env.example .env
```

3. Run

```generate key
Run php artisan key:generate
```

2. Run the Backend

```bash
php artisan serve
```

## Endpoints

<table>
    <tr>
        <th>Method</th>
        <th>Endpoint</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>POST</td>
        <td>/api/v1/register</td>
        <td>Register a user</td>
    </tr>
    <tr>
        <td>POST</td>
        <td>/api/v1/login</td>
        <td>Login a user</td>
    </tr>
</table>

## How to use the project

1. Open postman <br />
2. Send a POST request to `/api/v1/register` to register a user <br />

   - The request body should be in JSON format <br />
   - The request body should contain the following fields exemple: <br />
     {
        "name" : "Admin",
        "role" : "Admin",
        "email" : "admin@gmail",
        "username" : "admin",
        "password" : "adminadmin",
        "password_confirmation" : "adminadmin"
    }

3. Send a POST request to `/api/v1/login` to login a user <br />
   - The request body should be in JSON format <br />
   - The request body should contain the following fields exemple: <br />
     {
        "username" : "admin",
        "password" : "adminadmin"
      }

## Author

- [Ayoub Bsd](https://github.com/AYOUBBASIDI "Ayoub Basidi")
