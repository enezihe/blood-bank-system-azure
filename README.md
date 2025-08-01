
## Blood Bank System on Azure (GitHub Actions + Azure App Service Deployment)

This project is a PHP-based Blood Bank & Donation Management System, now hosted and deployed automatically via **GitHub Actions** to **Azure App Service**.

### Live Site

[https://bloodbank-webapp.azurewebsites.net](https://bloodbank-webapp.azurewebsites.net)

###  Technologies Used

* PHP 8.2
* MySQL
* GitHub Actions CI/CD
* Azure App Service
* Azure MySQL Flexible Server (or XAMPP for local)

---

### Local Development (Optional - For Contributors Only)

If you want to run this project locally:

1. Install **XAMPP** or a similar local PHP-MySQL environment.
2. Clone the repo:

   ```bash
   git clone https://github.com/enezihe/blood-bank-system-azure.git
   ```
3. Place the folder inside `htdocs/` directory.
4. Import the database from the `sql/` folder using phpMyAdmin.
5. Navigate to `http://localhost/index.php`.

---

###  Deployment to Azure

The app is deployed automatically using **GitHub Actions** on every push to the `master` branch.

#### GitHub Workflow Highlights:

* PHP setup and Composer install (if needed)
* Deploys app to Azure App Service
* Uses publish profile secret stored in GitHub Secrets

>  All application files are  located in the **root directory** 
