# Zems

Краткое описание проекта

## Installation

```bash
git clone git@github.com:NicolayNicolay/zems.git zems
cd zems
composer install
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```

```bash
php artisan key:generate
php artisan storage:link
```

```bash
npm install
```

```bash
npm run build
```

For development mode, use the command

```bash
npm run dev
```
Для базового наполнения проекта данными можно либо выгрузить бэкап базы данных из корня проекта, либо выполнить команду (данные тестовые, поэтому могут быть далеки от реально затраченного времени):
```bash
php artisan db:seed --class=ProjectsSeeder
```

