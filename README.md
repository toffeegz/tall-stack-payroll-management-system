<p align="center"><img src="https://i.im.ge/2022/04/25/lvswsy.png" width="400"></p>


# Getting Started
## TALL STACK
Payroll Management System is a web application using TALL stack (TailwindCSS, AlpineJS, Livewire, and Laravel)

## About Payroll Management System

Payroll Management System is a web application using Laravel. The main objective of the system is to automatically compute for the salary of the project, and non-project employees accurately. 

Specifically, it aims to include the following modules:
-	employee and project module which includes:
1.	managing of the employees’ personal information;
2.	creating of new projects with project details and deployed employees; 
3.	request application for loan
-	attendance and leave module which includes:
1.	recording of employees’ attendance (including the overtime and under time);
2.	reviewing of recorded attendance;
3.	managing of the leave entry;
4.	displaying of employees who are on-leave;
-	short-term loan (cash advance) module which includes:
1.	recording of employees’ loans; and
2.	managing of loans through installment;
-	payroll module which includes:
1.	compute and generate payroll per cut-off;
2.	generate payslip for each employee; 
-	settings module which can be used to manage the system’s content including:
1.	departments, 
2.	designations with daily rate, 
3.	employees with automatic user register,
4.	leave types,
5.	holidays, and 
6.	contribution table;
-	reports module which can be used to generate: 
1.	salary slips,
2.	employee lists,
3.	deductions and contributions report,
4.	short-term loan report, and
5.	employee details report.

## Features
- Auto-generate of Payroll Period Bi-Monthly and Weekly with send email list of generated payout dates to Administrator.
- Email payslip to employee

## New Updates as of July 12, 2023
- Allowing Multiple Rates for Employees in a Payroll Period
In the latest update of our payroll app, we have introduced a new feature that allows employees to have multiple rates within a payroll period. Previously, the app only considered the most recent rate when calculating payroll for a given period. However, with this update, employees can now update their rates during a payroll period, and the app will accurately calculate their earnings based on the respective rates for each time segment.

For example, let's say an employee's payroll period is from March 11th to March 25th. If the employee changes their rate from March 11th to March 20th to $2000 per day and then updates it to $3000 per day from March 21st to March 25th, the payroll app will consider these rate changes and compute the employee's earnings accordingly.

We believe this enhancement will provide more flexibility and accuracy in payroll calculations, accommodating the dynamic nature of rate changes within a payroll period. If you have any questions or need assistance with this new feature, please refer to the updated documentation or contact our support team.

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone git@github.com:toffeegz/payroll-management-system-aero.git

Switch to the repo folder

    cd payroll-management-system

Install all the dependencies using composer

    composer install

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Install all Dev dependencies 

    npm install

Run to compile assets (mix)

    npm run dev

Check database/seeders/DatabaseSeeder.php 
Users are also generated, you can uncomment it and modify the administrator info,
Modify the CompanyInformationSeeder class
Then Run

    php artisan db:seed

Set Email credentials in .env file

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME="${APP_NAME}"

Start the local development server

    php artisan serve
    
Start the queue job

    php artisan queue:work
    
Start the queue job

    php artisan queue:work
    
Start the schedule

    php artisan schedule:work
    
You can now access the server at http://localhost:8000

## IMPORTANT
Make sure to run queue jobs and scheduler for system to generate weekly and semimonthly payroll periods, employee payslip.

## About the Developer

Gezryl Beato Gallego (toffeegz) is a Full Stack Developer based in Philippines. 
- Laravel
- Vue.JS
- React.JS
- Typescript
- Tailwind
- Livewire
- Bootstrap
- AWS

## Visit my Profile
- [LinkedIn](https://www.linkedin.com/in/gezryl-clariz-beato-078312139/)
- [Github](https://github.com/toffeegz)
- [Facebook](https://www.facebook.com/toffeegz/)
