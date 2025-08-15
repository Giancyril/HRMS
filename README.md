# Optima HR

## Project Overview

Optima HR is a web-based Human Resources Management System (HRMS) built using the CodeIgniter framework. It is designed to help organizations efficiently manage their workforce, from employee records to payroll and project management. The system provides a centralized platform for administrators and employees to access key information and perform various HR-related tasks.

## Key Features

* **Dashboard:** A central dashboard provides a quick overview of key metrics, including the number of employees, pending leave applications, running projects, and payslips.

* **Organization Management:** Manage departments and designations.

* **Employee Management:** Manage employee information, including personal details, contact information, and job descriptions.

* **Attendance Management:** Track employee attendance with reports.

* **Leave Management:** Allows employees to apply for leave and managers to approve or deny requests.

* **Project Management:** Track ongoing projects, including start and end dates.

* **Payroll:** Manage and generate payslips for all employees.

* **Asset Management:** A system to track and manage company assets assigned to employees.

* **Loan Management:** Handle employee loan applications, approvals, and repayment tracking.

* **Notice Management:** A quick notice board to share important messages from management.

* **Analytics:** Provides data-driven insights with charts and reports on departments and designations.

## Technology Stack

* **Framework:** CodeIgniter

* **Backend:** PHP

* **Frontend:** HTML, CSS, JavaScript (likely using a UI framework like Bootstrap)

* **Database:** MySQL

## Getting Started

Follow these steps to set up and run the project on your local machine.

### Prerequisites

* XAMPP, WAMP, or any other stack that includes Apache and MySQL.

* A web browser (Chrome, Firefox, etc.).

### Installation

1.  **Clone the Repository:**

    ```
    git clone [your-repository-url]
    
    ```

2.  **Move to Web Server Directory:**
    Place the project folder (`HR-ERP-main`) in your web server's root directory (e.g., `C:\xampp\htdocs\`).

3.  **Database Setup:**

    * Create a new database in phpMyAdmin named `hr_erp`.

    * Import the SQL file (usually located in a `database` or `sql` folder within the project) into the new database.

4.  **Configuration:**

    * Open `application/config/database.php` and update the database credentials if necessary.

    * Open `application/config/config.php` and set the `$config['base_url']` to your local URL (e.g., `http://localhost/HR-ERP-main/`).

5.  **Run the Project:**

    * Start your Apache and MySQL servers.

    * Open your web browser and navigate to `http://localhost/HR-ERP-main/` to access the application.

## Git Branching Strategy

This project uses a feature-based branching strategy. All new work should be done on a dedicated feature branch. **Note that the `main` branch is currently outdated and does not contain the latest features.**

* `main`: The default branch, representing the stable, production-ready version of the code.

* `feature/`: Branches for new features, bug fixes, or enhancements (e.g., `feature/auth`, `feature/experimental`, `feature/homepage`).

