<h1>Tasks</h1>
<div class="row col-md-6 centered">
    <div class="row justify-content-between">
        <div class="col-4">
            <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                + Add new task
            </a>
        </div>
        <div class="col-4">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary">Sort by</button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <span><?= $sort ?></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/tasks/index/?sort_by=performer"
                           aria-current="true">Performer</a></li>
                    <li><a class="dropdown-item" href="/tasks/index/?sort_by=email">Email</a></li>
                    <li><a class="dropdown-item" href="/tasks/index/?sort_by=status">Status</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php if (!empty($tasks)) : ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Performer</th>
                <th scope="col">Email</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center"></th>
                <th scope="col" class="text-center"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) : ?>
                <tr>
                    <td>
                        <?= $task['performer']; ?>
                    </td>
                    <td>
                        <?= $task['email']; ?>
                    </td>
                    <td>
                        <?= $task['description']; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($auth) : ?>
                            <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                               data-bs-target="#updateModal"
                               data-bs-taskId="<?= $task['id']; ?>"
                               data-bs-taskDescription="<?= $task['description']; ?>">
                                Edit
                            </a>
                            <a type="button" class="btn btn-danger" href="/tasks/delete/?id=<?= $task['id']; ?>">
                                Delete
                            </a>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($task['status'] == 1) : ?>
                            <span class="badge bg-success">Done</span>
                        <?php else : ?>
                            <span class="badge bg-info">In progress</span>
                        <?php endif; ?>
                        <?php if ($task['edited'] == 1) : ?>
                            <span class="badge bg-success">Edited by Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <?php if ($pagination->countPages > 1) : ?>
                <?= $pagination ?>
            <?php endif ?>
        </div>
    <?php else : ?>
        No tasks
    <?php endif ?>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/tasks/store" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">New task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="performer-name" class="col-form-label">Performer:</label>
                        <input type="text" name="performer" class="form-control" id="performer-name">
                    </div>
                    <div class="mb-3">
                        <label for="performer-email" class="col-form-label">Email:</label>
                        <input type="email" name="email" class="form-control" id="performer-email">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" rows="5" id="message-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="eupdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" class="update-form" action="/tasks/update" enctype="multipart/form-data">
                <div class="modal-header">
                    <input type="hidden" name="task_id">
                    <h5 class="modal-title" id="eupdateModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-check">
                        <input class="form-check-input" name="status" type="checkbox" value="1" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Done
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" rows="5" id="message-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="application/javascript">
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var description = button.getAttribute('data-bs-taskDescription');
        var id = button.getAttribute('data-bs-taskId');

        var modalTitle = updateModal.querySelector('.modal-title');
        var modalBodyInput = updateModal.querySelector('.modal-body textarea');
        var modalHeaderInput = updateModal.querySelector('.modal-header input');

        modalTitle.textContent = 'Edit task # ' + id;
        modalBodyInput.value = description;
        modalHeaderInput.value = id;
    })
</script>