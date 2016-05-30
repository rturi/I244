<form action="?mode=add_task&list_id=<?php echo $active_list_id; ?>" method="post">
    <table>
        <tr>
            <td><input type="text" name="name" maxlength="100"></td>
            <td><input type="submit" value="Add task"></td>
        </tr>
    </table>
</form>

    <div class="active_tasks_area">
        <?php if(isset($active_tasks_list)) :?>
            <div class="active_task_list">
                    <?php foreach ($active_tasks_list as $task) : ?>
                        <div id="<?php echo htmlspecialchars($task['id']); ?>" list_id="<?php echo htmlspecialchars($task['list_id']); ?>" class="task">
                            <div class="done_button"><img src="img/button_done.png" alt="done" class="button_done"></div>
                            <div class="task_name_area"><?php echo htmlspecialchars($task['name']); ?></div>
                            <div class="edit_task_button">Edit</div>
                        </div>
                        <div class="edit_task_area" style="display: none;">
                            <form action="?mode=edit_task&list_id=<?php echo $active_list_id; ?>" method="post">
                                <table>
                                    <tr>
                                        <td><textarea rows="4" cols="50">ipsum lupsum</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>[save] [delete task]</td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    <?php endforeach; ?>
            </div>
        <?php else : ?>

            <div class="message_no_tasks">There are no active tasks in this list</div>

        <?php endif;?>
    </div>

<br><br>
<div class="completed_tasks_area">
    <?php if (!isset($_SESSION['show_completed_tasks'])) : ?>
        <div class="button_toggle_completed">[Show completed]</div>
    <?php else : ?>
        <div class="button_toggle_completed">[Hide completed]</div>
        <div class="completed_tasks_list">
            <?php if(isset($completed_tasks_list)) :?>
                <?php foreach ($completed_tasks_list as $task) : ?>
                    <div id="<?php echo htmlspecialchars($task['id']); ?>" list_id="<?php echo htmlspecialchars($task['list_id']); ?>" class="task">
                        <div class="undone_button"><img src="img/button_done.png" alt="done" class="button_done"></div>
                        <div class="task_name_area"><?php echo htmlspecialchars($task['name']); ?></div>
                        <div class="edit_task_button">Edit</div>
                    </div>
                    <div class="edit_task_area" style="display: none;">
                        <form action="?mode=add_task&list_id=<?php echo $active_list_id; ?>" method="post">
                            <table>
                                <tr>
                                    <td><textarea rows="4" cols="50">ipsum lupsum</textarea></td>
                                </tr>
                                <tr>
                                    <td>[save] [delete task]</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>

                <div class="message_no_tasks">There are no completed tasks in this list</div>

            <?php endif;?>
        </div>
    <?php endif;?>
</div>
