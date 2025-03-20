# Before running the Python service, ensure you have the following installed

Requirement              | Description
------------------------ | ---------------------------------------------------------------------------------------------
**Python 3.9 or higher** | [Download Python](https://www.python.org/downloads/)
**PostgreSQL**           | [Install PostgreSQL](https://www.postgresql.org/download/) and ensure the service is running.
**Git** (optional)       | [Download Git](https://git-scm.com/downloads)

# Python Service

This is the Python service for the project. It provides a Flask-based API to interact with the PostgreSQL database.

## **Setup**

### **1\. Clone the Repository**

If you haven't already, clone the project repository:

```bash
git clone <https://github.com your-username/your-repo.git> cd your-repo
```

### **2\. Navigate to the Python Service Directory**

```bash
cd python-app
```

### **3\. Set Up a Virtual Environment**

Create and activate a virtual environment:

- **On macOS/Linux:**

```bash
python -m venv venv
source venv/bin/activate
```

- **On Windows:**

```bash
python -m venv venv
venv\Scripts\activate
```

### **4\. Install Dependencies**

Install the required Python packages:

```bash
pip install -r requirements.txt
```

## **Configuration**

### **1\. Database Connection**

Ensure the PostgreSQL database is running and update the connection details in main.py:

```python
conn = psycopg2.connect(
    dbname="todo_app",
    user="postgres",
    password="secret",
    host="localhost",
    port="5432"
)
```

### **2\. Environment Variables**

If your project uses environment variables, create a .env file in the python-app directory:

```env
DB_NAME=todo_app
DB_USER=postgres
DB_PASSWORD=secret
DB_HOST=localhost
DB_PORT=5432
```

Update main.py to read from the .env file:

```python
import os
from dotenv import load_dotenv

load_dotenv()

conn = psycopg2.connect(
    dbname=os.getenv("DB_NAME"),
    user=os.getenv("DB_USER"),
    password=os.getenv("DB_PASSWORD"),
    host=os.getenv("DB_HOST"),
    port=os.getenv("DB_PORT")
)
```

## **Running the Service**

### **1\. Start the Python Service**

Run the Flask application:

```bash
python main.py
```

### **2\. Access the API**

The Python service will be available at:

```
http://localhost:5000/tasks
```

## **API Endpoints**

### **GET /tasks**

- **Description**: Fetch all tasks from the database.
- **Response**:

  ```json
  {
  "tasks": [
    {
      "id": 1,
      "title": "Task 1",
      "description": "Description for Task 1",
      "completed": false
    }
  ]
  }
  ```

## **Troubleshooting**

### **1\. Internal Server Error**

- Ensure the PostgreSQL service is running.
- Verify the database connection details in main.py.
- Check the Flask logs for detailed error messages.

### **2\. Missing Dependencies**

Ensure all dependencies are installed:

```bash
pip install -r requirements.txt
```

### **3\. Virtual Environment Issues**

- If the virtual environment is not activating, ensure Python is installed correctly and the venv module is available:

```bash
python -m ensurepip --upgrade
```

## **License**

This project is licensed under the MIT License. See the **LICENSE** file for details.

--------------------------------------------------------------------------------

### **Key Features of the README**

1. **Prerequisites**: Lists the required software (Python, PostgreSQL, Git).
2. **Setup**: Provides step-by-step instructions for setting up the virtual environment and installing dependencies.
3. **Configuration**: Explains how to configure the database connection and environment variables.
4. **Running the Service**: Describes how to start the Python service and access the API.
5. **API Endpoints**: Documents the available API endpoints.
6. **Troubleshooting**: Provides solutions for common issues.
7. **License**: Includes a placeholder for the project license.

--------------------------------------------------------------------------------

### **Example Project Structure**

--------------------------------------------------------------------------------

```
your-repo/
├── python-app/
│ ├── venv/ # Virtual environment (ignored)
│ ├── main.py # Main Python script
│ ├── requirements.txt # Python dependencies
│ ├── .env # Environment variables (ignored)
│ └── README.md # This README file
├── app/ # Laravel application
├── ...
└── .gitignore
```

--------------------------------------------------------------------------------

Let me know if you need further assistance!
