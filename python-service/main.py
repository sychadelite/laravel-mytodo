import os
import logging
import psycopg2
from flask import Flask, jsonify, request, abort
from dotenv import load_dotenv

# Load .env file
dotenv_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "../.env"))
load_dotenv(dotenv_path)

app = Flask(__name__)

# Set up logging
logging.basicConfig(level=logging.DEBUG)

# Connect to database
def get_db_connection():
    try:
        conn = psycopg2.connect(
            dbname=os.getenv("DB_DATABASE", "postgres"),
            user=os.getenv("DB_USERNAME", "postgres"),
            password=os.getenv("DB_PASSWORD", ""),
            host=os.getenv("DB_HOST", "localhost"),
            port=os.getenv("DB_PORT", "5432")
        )
        logging.info("Connected to the database successfully!")
        return conn
    except Exception as e:
        logging.error(f"Error connecting to the database: {e}")
        return jsonify({"error": "Unable to connect to the database"}), 500

# Reusable function to transform a task
def transform_task(task):
    return {
        "id": task[0],
        "title": task[1],
        "description": task[2],
        "completed": task[3],
        "created_at": task[4].isoformat() if task[4] else None,
        "updated_at": task[5].isoformat() if task[5] else None
    }

# Reusable function to fetch tasks from the database
def fetch_tasks(query, params=None):
    try:
        with get_db_connection() as conn:
            with conn.cursor() as cur:
                cur.execute(query, params or ())
                return cur.fetchall()
    except Exception as e:
        logging.error(f"Error executing query: {e}")
        raise

# Base endpoint
@app.route('/', methods=['GET'])
def base():
    data = {
        "user": "anonymous"
    }

    return jsonify({"status": "true", "data": data}), 200

# Health check endpoint
@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({"status": "healthy"}), 200

# Single route for fetching tasks
@app.route('/tasks', methods=['GET'])
def get_tasks():
    try:
        # Get query parameters
        completed = request.args.get('completed', type=str)
        page = request.args.get('page', default=1, type=int)
        per_page = request.args.get('per_page', default=10, type=int)

        # Validate page and per_page
        if page < 1 or per_page < 1:
            abort(400, description="Page and per_page must be positive integers.")

        # Build the query based on the filter
        query = "SELECT * FROM tasks"
        params = []
        if completed is not None:
            query += " WHERE completed = %s"
            params.append(completed.lower() == 'true')

        # Add pagination
        query += " LIMIT %s OFFSET %s"
        params.extend([per_page, (page - 1) * per_page])

        # Fetch tasks from the database
        tasks = fetch_tasks(query, params)

        # Transform the data to use named keys
        transformed_tasks = [transform_task(task) for task in tasks]

        return jsonify({"data": transformed_tasks})
    except Exception as e:
        logging.error(f"Error fetching tasks: {e}")
        return jsonify({"error": str(e)}), 500

# Run locally
if __name__ == "__main__":
    app.run(debug=True)