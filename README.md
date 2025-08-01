Harika! Aşağıda **ikonları kaldırılmış sade bir `README.md`** versiyonu yer alıyor:

---

````markdown
# Blood Bank System on Azure (Terraform Deployment)

This project is a proof of concept (PoC) for deploying a cloud-native Blood Bank Management System using Terraform on Microsoft Azure. The infrastructure includes a web application and MySQL database, provisioned using Infrastructure as Code.

## Project Objective

To design and implement a secure, scalable, and cost-effective blood bank web application infrastructure in Azure, based on best practices and course guidelines.

## Technologies Used

- Azure Resource Group
- Azure Linux Web App (PHP 8.2)
- Azure App Service Plan (B1 SKU)
- Azure Flexible MySQL Server
- Terraform (IaC)
- Region: Canada Central

## Architecture Overview

User → Azure Linux Web App (PHP) → Azure MySQL Flexible Server → Data Storage

## Provisioned Resources

| Resource Type         | Name                  | Configuration                            |
|----------------------|-----------------------|-------------------------------------------|
| Resource Group        | rg-bloodbank-dev      | Region: Canada Central                    |
| App Service Plan      | bloodbank-plan        | Linux, B1 SKU                             |
| Linux Web App         | bloodbank-webapp      | PHP 8.2, HTTPS enabled                    |
| MySQL Flexible Server | blooddbserver         | Version 8.0.21, 32GB storage              |
| MySQL Database        | blood_donation        | Charset: utf8, Collation: utf8_unicode_ci |

## Deployment Instructions

1. Install Terraform and Azure CLI
2. Authenticate to Azure:
   ```bash
   az login
````

3. Initialize Terraform:

   ```bash
   terraform init
   ```
4. Review the plan:

   ```bash
   terraform plan
   ```
5. Apply the configuration:

   ```bash
   terraform apply
   ```

## Security Considerations

* HTTPS-only access to the web app
* TLS 1.2 enforced for all connections
* No local MySQL or FTP access enabled
* Public network access is limited

## Output

Once deployed, the app will be accessible at:

```
https://bloodbank-webapp.azurewebsites.net
```

## Author

* Nezihe 
