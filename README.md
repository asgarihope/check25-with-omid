# Check25-With-Omid Code Challenge Project 🚀

This project is part of a code challenge for Check24. It involves implementing an insurance service with two providers, ACME and OMID. The project demonstrates the use of the Strategy Design Pattern.

---

## Requirements

- **PHP 8.1+** (Because we like it fresh and shiny!)
- **Composer** (For all those fancy packages)
- **Git** (To clone like a pro)
- **Popcorn** (For enjoying the code-reading experience! 🍿)

---

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/asgarihope/check25-with-omid.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd check25-with-omid
   ```

3. Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

   **Note:** The .env file has been cleared for security reasons. No secrets here! 🤫

4. Set up the database:

   - Create a small database and update the `.env` file with your database credentials:

     ```bash
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=check25_with_omid
     DB_USERNAME=root
     DB_PASSWORD=
     ```

   **Note:** No data related to the code challenge is stored in the database. It’s just for session and stuff. 😅

5. Install dependencies:

   ```bash
   composer install
   ```

6. Set the available insurance provider in the `.env` file:

   ```bash
   INSURANCE_SERVICE_AVAILABLE=
   ```

   You can set this to either ACME or OMID.

---

## Usage

### Example Requests

Two example request files are provided in the `storage/app/private/` directory:

- `example1.json`
- `example2.json`

You can modify these files or create new ones. If you create new files, make sure to name them correctly as you will need to reference them in the next steps. Naming is important, just like naming your pets! 🐶

### Running the Insurance Service

To get the expected output, run the following commands:

1. ```bash
   php artisan insurance --file=example1.json
   ```

2. ```bash
   php artisan insurance --file=example2.json
   ```

### Switching Providers

You can switch between the two providers (ACME and OMID) by changing the `INSURANCE_SERVICE_AVAILABLE` value in the `.env` file.

- **OMID Provider:** Outputs JSON. (Because JSON is life! 😎)
- **ACME Provider:** Outputs XML. (For those who like it old-school. 📜)

### Running Tests

To run the tests, use the following command:

```php
php artisan test
```

---

## Contributing

If you would like to contribute to this project, please note that this repository will be deleted after new friends become colleagues to prevent misuse. So, enjoy it while it lasts! 🎉

---

## Final Thoughts

I added an extra insurance provider (OMID) just to show off my Strategy Design Pattern skills. Was it necessary? Maybe not. Did it make me feel good? Absolutely! 😌

Also, I might have over-engineered a bit with the Repository Pattern and CRUD operations, but hey, it’s better to show what you can do, right? 😉

Now, go grab some popcorn and enjoy the code! 🍿✨
