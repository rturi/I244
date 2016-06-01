<div class="content_block">Showing results for "<span class="search_key"><?php echo htmlspecialchars($input_keyword); ?></span>"</div>
<div class="active_tasks_area">
    <?php if(isset($active_tasks_list) && !empty($active_tasks_list)) :?>
        <div class="active_task_list">
            <?php foreach ($active_tasks_list as $task) : ?>
                <div id="<?php echo htmlspecialchars($task['id']); ?>" class="task">
                    <div class="done_button"><img src="img/button_done.png" alt="done" class="button_done"></div>
                    <div class="task_name_area"><?php echo htmlspecialchars($task['name']); ?></div>
                    <?php if ($task['due_time'] != "0000-00-00") : ?>
                        <div class="task_due_date"><?php echo htmlspecialchars($task['due_time']); ?></div>
                    <?php endif;?>
                    <div class="edit_task_button neutral_button">Edit</div>
                </div>
                <div class="edit_task_area" style="display: none;">
                    <form action="?mode=edit_task&task_id=<?php echo htmlspecialchars($task['id']); ?>&source=search&q=<?php echo htmlspecialchars($input_keyword)?>" method="post">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="name" width="75" value="<?php echo htmlspecialchars($task['name']); ?>"></td>
                            </tr>
                            <tr>
                                <td>Due:</td>
                                <td><input type="date" name="due_time" value="<?php if(!empty($task['due_time'])) echo htmlspecialchars($task['due_time']); ?>"></td>
                            </tr>
                            <tr>
                                <td>Info:</td>
                                <td><textarea name="info" rows="4" cols="40"><?php echo htmlspecialchars($task['info'])?></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div class="delete_task_button_area"><div class="neg_button delete_task_button">Delete</div></div><div class="save_task_button"><input class="pos_button" type="submit" value="Save"></div></td>
                            </tr>
                        </table>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>

        <div class="message_no_tasks">Found 0 tasks</div>

    <?php endif;?>
</div>
