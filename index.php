<?php
  include 'db-connection.php';
?>


<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management</title>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
  <div class="container mt-4">

    <h1 class="mb-4">Task Management</h1>
    
    <a class="btn btn-primary mb-3" href="taskCreation.php">Add Task</a>

    <!-- Task List -->
    <div class="card">

      <div class="card-header">
        Task List
      </div>

      <div class="card-body">

        <!-- Task Filters -->
        <div class="form-row mb-3">

          <div class="col-md-4">

            <label for="filterStatus">Filter by Status:</label>

            <select id="filterStatus" class="form-control">
              <option value="all">All</option>
              <option value="todo">To Do</option>
              <option value="inprogress">In Progress</option>
              <option value="done">Done</option>
            </select>

          </div>

          <div class="col-md-4">

            <label for="filterPriority">Filter by Priority:</label>

            <select id="filterPriority" class="form-control">
              <option value="all">All</option>
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>

          </div>
        </div>
        
        <!-- Task Table -->
        <table class="table table-bordered">

          <thead>

            <tr>
              <th>#</th>
              <th>Task Name</th>
              <th>Due Date</th>
              <th>Status</th>
              <th>Priority</th>
            </tr>

          </thead>

          <tbody id="taskList">
            
            <?php
              $sql = "SELECT * FROM task";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>

            <tr>
              <td><?php echo $row['task_id']; ?></td>
              <td><?php echo $row['task_name']; ?></td>
              <td><?php echo $row['due_date']; ?></td>
              <td><?php echo $row['status']; ?></td>
              <td><?php echo $row['priority']; ?></td>
            </tr>

            <?php
                }
              } else {
                echo "<tr><td colspan='5'>No tasks found</td></tr>";
              }
            ?>
            
          </tbody>

        </table>

      </div>

    </div>

  </div>

 
</body>
</html>
