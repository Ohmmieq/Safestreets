The system operates across three core architectural components:
1. **The Ingestion Pipeline:** Manages client-side traffic reporting inputs, isolating spatial variables (GPS), temporal variables (timestamps), and binary payloads (media uploads).
2. **The Relational Storage Layer:** A structured, transactional MySQL database engineered to enforce strict data normalization and data integrity across high-concurrency reporting events.
3. **The Executive Monitoring Dashboard:** A secure, authenticated control panel that dynamically queries the database layer to visualize incident distribution arrays based on administrative security permissions.

## 🛠️ Technical Capabilities & System Features

### 1. Telemetry & Spatial Data Processing (Google Maps & GPS API)
* **Live Telemetry Ingestion:** Leverages native browser Geolocation APIs to pull high-precision client-side latitude and longitude variables at the precise moment of submission.
* **Dynamic Mapping Canvas:** Integrates the Google Maps JavaScript API to convert raw decimal coordinates into persistent visual markers on a live-updating operations dashboard.

### 2. Full-Stack Data Ingestion (PHP & JavaScript)
* **Asynchronous State Handling:** Utilizes vanilla JavaScript to validate reporting forms on the client side, mitigating incomplete payload transmission errors before hitting server memory.
* **Server-Side Data Sanitization:** Implements structural PHP backend validation, scrubbing incoming string data variables to block SQL Injection (`SQLi`) and Cross-Site Scripting (`XSS`) threats.

### 3. Structural Data Management (MySQL Relational Design)
* **Normalized Relational Schema:** Engineered with distinct foreign key constraints linking users, reports, media logs, and resolution metrics to prevent data fragmentation.
* **Sub-Second Index Queries:** Database indexing optimized for spatial and temporal attributes, ensuring near-instantaneous retrieval of high-priority violation events during concurrent dashboard refreshes.

### 4. System Security & Operational Control (RBAC & Auth)
* **Role-Based Access Control (RBAC):** Restricts interface access programmatically. Citizens are isolated to the data entry pipeline, while administrative nodes are partitioned into localized and county-level surveillance clearance layers.
* **OTP Factor Authentication:** Protects administrative logins by executing a temporary, time-sensitive One-Time Password validation system to block unauthorized backend access.

## 💾 Core Tech Stack
* **Frontend Architecture:** HTML5, CSS3, JavaScript (Vanilla ES6)
* **Backend Core Engine:** PHP (Hypertext Preprocessor)
* **Database & Ledger Layer:** MySQL Relational Database Management System (RDBMS)
* **API Infrastructure Integration:** Google Maps Platform (Maps JavaScript API, Geolocation API)

## 🔧 Operational Deployment & Installation

To run this local infrastructure instance for evaluation:

1. **Clone the Application Directory:**
   ```bash
   git clone https://github.com
   cd Safestreets
   ```

2. **Initialize Local Database Environment:**
   * Import the provided `.sql` relational schema schema dump into your local MySQL server instance (e.g., via XAMPP/WAMP or native CLI).
   * Update the backend structural database connection configuration parameters inside your database connector script (`config.php` or equivalent).

3. **Deploy to Local Web Server Webroot:**
   * Move the project directory to your local web server's public root folder (e.g., `/opt/lampp/htdocs/` or `C:\xampp\htdocs\`).
   * Open any browser and target your loopback address interface: `http://localhost/Safestreets`

---
*Engineered and maintained independently by Naomi Kabiru as part of practical IT Infrastructure and Full-Stack Architecture optimizations at Kabarak Univer
