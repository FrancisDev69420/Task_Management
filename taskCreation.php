<?php

    include 'db-connection.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Creation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow-lg">

            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Create a New Task</h3>
            </div>

            <div class="card-body">

                <form action="taskCreation.php" method="POST">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="taskTitle" name="taskTitle" placeholder="Enter task title" required>
                    </div>

                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" placeholder="Enter task description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="taskDueDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="taskDueDate" name="taskDueDate" required>
                    </div>

                    <div class="mb-3">
                        <label for="taskPriority" class="form-label">Priority Level</label>
                        <select class="form-select" id="taskPriority" name="taskPriority" required>
                            <option value="" selected disabled>Select priority</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Create Task</button>
                </form>

            </div>

        </div>

    </div>

</body>

</html>


<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $taskTitle = $_POST['taskTitle'];
        $taskDescription = $_POST['taskDescription'];
        $taskDueDate = $_POST['taskDueDate'];
        $taskPriority = $_POST['taskPriority'];

        $stmt = $conn->prepare("INSERT INTO task (task_name, description, due_date, priority) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $taskTitle, $taskDescription, $taskDueDate, $taskPriority);

        if ($stmt->execute()) {
            echo "<script>
                alert('Task created successfully');
                window.location.href = 'index.php';
            </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
   
?>
