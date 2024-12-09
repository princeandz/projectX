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
            body: `title=${title}&description=${description}&due_date=${due_date}`
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
});

// Variable to store current sort order (ascending/descending)
let sortOrder = 'asc'; // Default sort order is ascending

// Function to load tasks from the server
function loadTasks() {
    fetch(`update_task.php?sort_order=${sortOrder}`) // Pass sort_order to PHP
        .then(response => response.json())
        .then(tasks => {
            const tbody = document.querySelector("#task-table tbody");
            tbody.innerHTML = ""; // Clear current rows

            tasks.forEach(task => {
                tbody.innerHTML += `
                    <tr>
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td>${task.due_date}</td>
                        <td>${task.status}</td>
                        <td><button onclick="deleteTask(${task.task_id})">Delete</button></td>
                    </tr>`;
            });
        });
}

// Toggle sort order between 'asc' and 'desc'
function toggleSortOrder() {
    sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
}

// Function to delete a task
function deleteTask(taskId) {
    fetch("delete_task.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `task_id=${taskId}`
    }).then(() => loadTasks());
}

