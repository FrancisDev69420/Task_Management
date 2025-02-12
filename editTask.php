<?php
// Include your database connection
include('db-connection.php'); // Change this to your actual database connection file

// Check if the task_id is passed in the URL
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Fetch the task details from the database
    $sql = "SELECT * FROM task WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id); // Bind task_id as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if task exists
    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found!";
        exit;
    }
} else {
    echo "Task ID is required!";
    exit;
}

// Check if the form is submitted for updating the task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated data from the form
    $task_name = $_POST['task_name'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $description = $_POST['description']; // Get the description

    // Update the task in the database
    $update_sql = "UPDATE task SET task_name = ?, due_date = ?, status = ?, priority = ?, description = ? WHERE task_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $task_name, $due_date, $status, $priority, $description, $task_id); // Bind description
    $update_stmt->execute();

    // Redirect to task list or confirmation page after successful update
    header("Location: index.php"); // Change this to your task listing page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow-lg">

            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Edit Task</h3>
            </div>

            <div class="card-body">

                <form method="POST">
                    <div class="mb-3">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label> <!-- Added description input -->
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($task['description']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="in progress" <?php echo ($task['status'] == 'in progress') ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority Level</label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="low" <?php echo ($task['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo ($task['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo ($task['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Update Task</button>
                </form>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
