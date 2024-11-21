from flask import Flask, render_template, request, redirect, url_for
from datetime import datetime

app = Flask(__name__)

def calculate_result(mark):
    if mark >= 75:
        return "A"
    elif mark >= 65:
        return "B"
    elif mark >= 55:
        return "C"
    elif mark >= 35:
        return "S"
    else:
        return "W"

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/result', methods=['POST'])
def result():
    # Retrieve form data
    subjects = [request.form.get(f'subject{i}') for i in range(1, 10)]
    marks = [int(request.form.get(f'mark{i}', 0)) for i in range(1, 10)]

    # Calculate results
    grades = [calculate_result(mark) for mark in marks]

    # Combine subjects and grades
    results = list(zip(subjects, grades))

    # Get current date and time
    current_datetime = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    return render_template('result.html', results=results, datetime=current_datetime)

if __name__ == '__main__':
    app.run(debug=True)
