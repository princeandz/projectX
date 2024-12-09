document.addEventListener("DOMContentLoaded", () => {
    loadTasks();

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
});

function loadTasks() {
    fetch("update_task.php")
        .then(response => response.json())
        .then(tasks => {
            const tbody = document.querySelector("#task-table tbody");
            tbody.innerHTML = "";
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

function deleteTask(taskId) {
    fetch("delete_task.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `task_id=${taskId}`
    }).then(() => loadTasks());
}

