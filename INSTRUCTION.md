# 1. Navigate to the project directory
cd ../../technicalChallenge

# 2. Install Node.js dependencies
npm install

# 3. Install PHP dependencies
sudo apt install php8.3-curl php8.3-xml php8.3-mbstring php8.3-sqlite3
composer install

# 4. Create the environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Build the assets
npm run build

# 7. Prep SQLite DB
php artisan migrate

# 8. Start the local development server
php artisan serve
