# 🍱 MBG (Makan Bergizi Gratis) Database System

![SQL](https://img.shields.io/badge/Language-Structured_Query_Language-blue)
![Database](https://img.shields.io/badge/Database-MySQL%2FPostgreSQL-orange)
![Design](https://img.shields.io/badge/Architecture-3rd_Normal_Form-green)

> **A relational database architecture designed to manage supply chain, distribution, and nutritional tracking for the National Free Nutritious Meal program.**

---

## 🏛️ System Overview

This project focuses on the **backend data layer** required to support a large-scale logistics program. The database handles complex relationships between:
* **Beneficiaries:** Students/Recipients data.
* **Providers:** Kitchens, Catering services, and Suppliers.
* **Logistics:** Menu distribution, Delivery tracking, and Schedules.
* **Nutritional Value:** Caloric and nutritional breakdown of meals.

The schema is designed to ensure **Data Integrity** and minimize redundancy, strictly following **3rd Normal Form (3NF)** principles.

---

## 📐 Entity Relationship Diagram (ERD)

The core architecture of the system. This diagram illustrates how the `Distribution` tables link `Recipients` with `Providers` while tracking `Menus`.

![Database Schema](erd_schema.png)
*(Please ensure you upload your ERD image and name it erd_schema.png)*

---

## ⚙️ Key Technical Features

### 1. Data Normalization
* Designed to **3NF** standards to eliminate data anomalies.
* Separation of `Menus` and `Ingredients` allows for flexible inventory tracking.

### 2. Constraints & Integrity
* **Foreign Keys:** Enforced referential integrity (e.g., A `Distribution` record cannot exist without a valid `Provider_ID`).
* **Data Types:** Optimized column types (e.g., using `DECIMAL` for budget/cost to avoid floating-point errors).

### 3. Business Logic (Stored Procedures/Views)
*(Edit this section based on your actual code)*
* **Automated Reporting:** Includes SQL scripts/Views to aggregate daily distribution costs per region.
* **Audit Trails:** Logs timestamps for every status change in delivery.

---

## 📂 Repository Structure

```bash
├── 📄 ddl.sql           # Data Definition Language (Create Tables, Constraints)
├── 📄 seed.sql          # Dummy Data for Testing
├── 📄 queries.sql       # Analytical Queries (Reports)
├── 🖼️ erd_schema.png    # Visual Schema Representation
└── 📄 README.md         # Documentation
```

🚀 How to Import
1. Clone the Repository

```Bash

git clone [https://github.com/zaghokun/MBG-database-project.git](https://github.com/zaghokun/MBG-database-project.git)
```
2. Import to Database

Via CLI:

```Bash

mysql -u username -p database_name < ddl.sql
mysql -u username -p database_name < seed.sql
```
Via GUI: Import the .sql files directly into DBeaver, phpMyAdmin, or MySQL Workbench.

📝 License
Designed for educational and portfolio purposes.
