<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Tâches</title>


    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative bg-yellow-50 overflow-hidden max-h-screen">

    <aside class="fixed inset-y-0 left-0 bg-white shadow-md max-h-screen w-60">
        <div class="flex flex-col justify-between h-full">
            <div class="flex-grow">
                <div class="px-4 py-6 text-center border-b">
                    <h1 class="text-xl font-bold leading-none"><span class="text-yellow-700">Gestionnaire</span> de Tâches</h1>
                </div>
                <div class="p-4">
                    <ul class="space-y-1">
                        <li>
                            <a href="#" class="flex items-center bg-yellow-200 rounded-xl font-bold text-sm text-yellow-900 py-3 px-4" data-view="tasks">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Tâches
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center bg-white rounded-xl font-bold text-sm text-gray-900 py-3 px-4" data-view="users">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Utilisateurs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>


    <main class="ml-60 pt-16 max-h-screen overflow-auto">
        <div class="px-6 py-8">
            <div class="max-w-4xl mx-auto">
                <div id="tasksView">
                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Mes Tâches</h2>
                        <div>
                            <button id="newTaskBtn" class="bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Créer une Tâche
                            </button>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-8 mb-5">
                        <div class="flex space-x-4">
                            <div class="w-1/3 bg-gray-100 p-4 rounded-lg">
                                <h2 class="text-xl font-bold mb-4">To Do</h2>
                                <?php
                                require_once "../Classes/DataHost";
                                require_once "../Classes/Task";
                                require_once "../Classes/TaskRender";

                                $taskObj = new Task("", "", "", "");
                                $tasks = $taskObj->ShowTasks();
                                ?>
                                <?php
                                foreach ($tasks as $task) {
                                    if ($task['task_status'] === 'to-do') {
                                        echo TaskRenderer::renderTaskCard($task);
                                    }
                                }
                                ?>
                            </div>

                            <div class="w-1/3 bg-gray-100 p-4 rounded-lg">
                                <h2 class="text-xl font-bold mb-4">In Progress</h2>
                                <?php
                                foreach ($tasks as $task) {
                                    if ($task['task_status'] === 'in-progress') {
                                        echo TaskRenderer::renderTaskCard($task);
                                    }
                                }
                                ?>
                            </div>

                            <div class="w-1/3 bg-gray-100 p-4 rounded-lg">
                                <h2 class="text-xl font-bold mb-4">Done</h2>
                                <?php
                                foreach ($tasks as $task) {
                                    if ($task['task_status'] === 'done') {
                                        echo TaskRenderer::renderTaskCard($task);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="usersView" class="hidden">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold">Utilisateurs</h2>
                    </div>
                    <div class="bg-white rounded-3xl p-8 mb-5">
                        <div class="grid gap-4" id="usersList">
                            <?php
                            $users = Task::ShowUsers();
                            foreach ($users as $user) {
                                echo '<div class="bg-gray-100 p-4 rounded-lg shadow-md">';
                                echo '<h3 class="text-lg font-semibold">' . htmlspecialchars($user['user_name']) . '</h3>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="taskModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg w-96">
            <h3 class="text-xl font-bold mb-4">Créer une nouvelle tâche</h3>
            <form id="taskForm" action="../includes/createTask.inc.php" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Type de tâche</label>
                    <select name="taskType" id="taskType" class="w-full border rounded p-2" required>
                        <option value="task">Tâche simple</option>
                        <option value="bug">Bug</option>
                        <option value="feature">Feature</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Titre</label>
                    <input type="text" name="taskTitle" id="taskTitle" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="taskDescription" id="taskDescription" class="w-full border rounded p-2" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Assigné à</label>
                    <input type="text" name="taskAssignee" id="taskAssignee" class="w-full border rounded p-2"
                        placeholder="Nom de l'utilisateur" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelTask" class="px-4 py-2 border rounded">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Créer</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('taskModal');
            const taskForm = document.getElementById('taskForm');
            const taskTypeSelect = document.getElementById('taskType');
            const viewLinks = document.querySelectorAll('[data-view]');
            const tasksView = document.getElementById('tasksView');
            const usersView = document.getElementById('usersView');

            document.getElementById('newTaskBtn').addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            document.getElementById('cancelTask').addEventListener('click', () => {
                modal.classList.add('hidden');
                taskForm.reset();
            });

            taskTypeSelect.addEventListener('change', function() {
                const modalTitle = modal.querySelector('h3');
                switch (this.value) {
                    case 'bug':
                        modalTitle.textContent = 'Créer un nouveau bug';
                        break;
                    case 'feature':
                        modalTitle.textContent = 'Créer une nouvelle feature';
                        break;
                    default:
                        modalTitle.textContent = 'Créer une nouvelle tâche';
                }
            });

            viewLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const view = e.currentTarget.dataset.view;

                    viewLinks.forEach(l => {
                        l.classList.remove('bg-yellow-200', 'text-yellow-900');
                        l.classList.add('bg-white', 'text-gray-900');
                    });
                    e.currentTarget.classList.remove('bg-white', 'text-gray-900');
                    e.currentTarget.classList.add('bg-yellow-200', 'text-yellow-900');

                    if (view === 'tasks') {
                        tasksView.classList.remove('hidden');
                        usersView.classList.add('hidden');
                    } else if (view === 'users') {
                        tasksView.classList.add('hidden');
                        usersView.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</body>

</html>