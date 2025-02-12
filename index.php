<?php
  include 'db-connection.php';

  // Get filter values from GET request, default to 'all'
  $status = isset($_GET['status']) ? $_GET['status'] : 'all';
  $priority = isset($_GET['priority']) ? $_GET['priority'] : 'all';

  // Start SQL query
  $sql = "SELECT * FROM task WHERE 1=1";

  // Apply filters if not 'all'
  if ($status !== 'all') {
      $sql .= " AND status = '$status'";
  }

  if ($priority !== 'all') {
      $sql .= " AND priority = '$priority'";
  }

  // Execute query
  $result = $conn->query($sql);
?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <div class="container mt-4">

    <h1 class="mb-4">Task Management</h1>
    
    <a class="btn btn-primary mb-3" href="taskCreation.php">Add Task</a>

    <div class="card">

      <div class="card-header">
        Task List
      </div>

      <div class="card-body">

        <!-- Task Filters -->
        <form method="GET" action="index.php">

          <div class="form-row mb-3">

            <div class="col-md-4">

              <label for="filterStatus">Filter by Status:</label>

              <select id="filterStatus" name="status" class="form-control">

                <option value="all" <?= ($status == 'all') ? 'selected' : '' ?>>All</option>
                <option value="To do" <?= ($status == 'To do') ? 'selected' : '' ?>>To Do</option>
                <option value="in progress" <?= ($status == 'in progress') ? 'selected' : '' ?>>In Progress</option>
                <option value="completed" <?= ($status == 'completed') ? 'selected' : '' ?>>Completed</option>

              </select>

            </div>

            <div class="col-md-4">

              <label for="filterPriority">Filter by Priority:</label>

              <select id="filterPriority" name="priority" class="form-control">

                <option value="all" <?= ($priority == 'all') ? 'selected' : '' ?>>All</option>
                <option value="low" <?= ($priority == 'low') ? 'selected' : '' ?>>Low</option>
                <option value="medium" <?= ($priority == 'medium') ? 'selected' : '' ?>>Medium</option>
                <option value="high" <?= ($priority == 'high') ? 'selected' : '' ?>>High</option>

              </select>

            </div>

            <div class="col-md-4 align-self-end">

              <button type="submit" class="btn btn-success">Apply Filters</button>
              <a href="index.php" class="btn btn-secondary">Reset</a>

            </div>

          </div>

        </form>
        
        <!-- Task Table -->
        <table class="table table-bordered">

          <thead>

            <tr>
              <th>#</th>
              <th>Task Name</th>
              <th>Description</th>
              <th>Due Date</th>
              <th>Status</th>
              <th>Priority</th>
              <th>Action</th>
            </tr>

          </thead>

          <tbody>

            <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>

              <tr>

                <td><?php echo $row['task_id']; ?></td>
                <td><?php echo $row['task_name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['priority']; ?></td>

                <td>
                  <a href="editTask.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-primary">Edit</a>
                  <a href="deleteTask.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                </td>

              </tr>

            <?php
                }
              } else {
                echo "<tr><td colspan='7' class='text-center'>No tasks found</td></tr>";
              }
            ?>

          </tbody>

        </table>

      </div>

    </div>

  </div>

</body>
</html>
