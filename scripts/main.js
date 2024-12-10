document.addEventListener("DOMContentLoaded", () => {
    loadTasks(); // Load tasks initially

    // Add event listener for form submission
    document.getElementById("task-form").addEventListener("submit", function (e) {
        e.preventDefault();

        const title = document.getElementById("title").value;
        const description = document.getElementById("description").value;
        const due_date = document.getElementById("due_date").value;

        fetch("update_task.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&due_date=${due_date}`
        }).then(() => {
            loadTasks();
            this.reset();
        });
    });

    // Add event listener to sort tasks by due date when the header is clicked
    const dueDateHeader = document.getElementById("due-date-header");
    dueDateHeader.addEventListener("click", () => {
        toggleSortOrder(); // Toggle the sort order
        loadTasks(); // Reload tasks with updated order
    });

    // Add event listener for CSV download button
    document.getElementById("download-csv").addEventListener("click", () => {
        window.location.href = "download_tasks.php";
    });

    // Add event listener for CSV upload form submission
    document.getElementById("upload-csv-form").addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("upload_tasks.php", {
            method: "POST",
            body: formData
        }).then(response => response.text())
          .then(result => {
              alert(result); // Display success or error message
              loadTasks(); // Reload tasks after upload
          });
    });

    // Add event listener for search form submission
    document.getElementById("search-form").addEventListener("submit", function (e) {
        e.preventDefault();
        const searchTitle = document.getElementById("search-title").value;
        const searchDueDate = document.getElementById("search-due-date").value;
        const searchStatus = document.getElementById("search-status").value;
        loadTasks(searchTitle, searchDueDate, searchStatus);
    });

    // Add event listener to clear the search
    document.getElementById("clear-search").addEventListener("click", function () {
        document.getElementById("search-title").value = "";
        document.getElementById("search-due-date").value = "";
        document.getElementById("search-status").value = "";
        loadTasks();
    });
});

// Variable to store current sort order (ascending/descending)
let sortOrder = 'asc'; // Default sort order is ascending

// Function to load tasks from the server with optional search parameters
function loadTasks(searchTitle = "", searchDueDate = "", searchStatus = "") {
    fetch(`update_task.php?sort_order=${sortOrder}&search_title=${encodeURIComponent(searchTitle)}&search_due_date=${encodeURIComponent(searchDueDate)}&search_status=${encodeURIComponent(searchStatus)}`)
        .then(response => response.json())
        .then(tasks => {
            const tbody = document.querySelector("#task-table tbody");
            tbody.innerHTML = ""; // Clear current rows

            if (tasks.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center;">No tasks found.</td></tr>`;
                return;
            }

            tasks.forEach(task => {
                tbody.innerHTML += `
                    <tr>
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td>${task.due_date}</td>
                        <td>${task.status}</td>
                        <td>
                            <button onclick="markAsDone(${task.task_id})">Mark as Done</button><br>
                            <button onclick="deleteTask(${task.task_id})">Delete</button>
                        </td>
                    </tr>`;
            });
        });
}

// Toggle sort order between 'asc' and 'desc'
function toggleSortOrder() {
    sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
    loadTasks();
}

// Function to mark a task as done
function markAsDone(taskId) {
    fetch("update_task.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `mark_done_id=${taskId}`
    }).then(() => loadTasks());
}

// Function to delete a task
function deleteTask(taskId) {
    fetch("delete_task.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `task_id=${taskId}`
    }).then(() => loadTasks());
}





