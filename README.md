# Employee Training And Knowledge Base Platform

The **Employee Training Knowledge Base Platform** is a web-based application designed to streamline and manage employee training programs within an organization. It serves as a centralized repository for training materials, schedules, and progress tracking, facilitating efficient knowledge dissemination and skill development.

## Features

- **Centralized Repository**: Store and organize all training materials in one accessible location.
- **Training Schedules**: Manage and share training calendars with employees.
- **Progress Tracking**: Monitor employee participation and completion rates.
- **User Management**: Administer user roles and permissions effectively.

## Technologies Used

- **Backend**: PHP
- **Frontend**: React.js
- **Database**: SQLite

## Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/poojaDEvrari/Employee-Training-Knowledge-Base-Platform.git
   ```
Navigate to the Project Directory:

```bash
cd Employee-Training-Knowledge-Base-Platform
```

Install Dependencies: Ensure you have Composer installed, then run:

```bash
composer install
```

Set Up the Database:
Create a MySQL database named employee_training.
Import the provided SQL file located in the db directory to set up the necessary tables.

Configure the Application:
Rename the config.sample.php file to config.php.
Update the database credentials and other configuration settings in config.php as needed.

Start the Development Server:

```bash
php -S localhost:8000
```

Access the application by navigating to http://localhost:8000 in your web browser.

Usage
Admin Panel: Accessible at http://localhost:8000/admin. Here, administrators can manage users, upload training materials, and schedule sessions.
Employee Dashboard: Employees can log in to view assigned trainings, track their progress, and access available resources.
