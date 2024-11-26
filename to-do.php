
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .task-form {
            text-align: center;
            margin-bottom: 20px;
        }
        .task-list {
            max-width: 400px;
            margin: 0 auto;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            background: #f4f4f4;
            margin-bottom: 5px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        button {
            background: #ff4d4d;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        button:hover {
            background: #d93636;
        }
    </style>
</head>
<body>
<?php
// File to store tasks
$taskFile = 'tasks.txt';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a task
    if (isset($_POST['new_task']) && !empty(trim($_POST['new_task']))) {
        $newTask = htmlspecialchars(trim($_POST['new_task']));
        file_put_contents($taskFile, $newTask . PHP_EOL, FILE_APPEND);
    }
    // Delete a task
    if (isset($_POST['delete'])) {
        $tasks = file($taskFile, FILE_IGNORE_NEW_LINES);
        $indexToDelete = $_POST['delete'];
        unset($tasks[$indexToDelete]);
        file_put_contents($taskFile, implode(PHP_EOL, $tasks) . PHP_EOL);
    }
}

// Load existing tasks
$tasks = file_exists($taskFile) ? file($taskFile, FILE_IGNORE_NEW_LINES) : [];
?>

    <h1>To-Do List</h1>

    <div class="task-form">
        <form method="POST" action="">
            <input type="text" name="new_task" placeholder="Enter a new task" required>
            <button type="submit">Add Task</button>
        </form>
    </div>

    <div class="task-list">
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $index => $task): ?>
                <div class="task-item">
                    <span><?= htmlspecialchars($task) ?></span>
                    <form method="POST" action="" style="margin: 0;">
                        <button type="submit" name="delete" value="<?= $index ?>">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">No tasks yet!</p>
        <?php endif; ?>
    </div>
</body>
</html>
