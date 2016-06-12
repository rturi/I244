<form action="index.php" method="post">
    <table>
        <tr>
            <td>Title</td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr>
            <td>Your name:</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>Your Comment:</td>
            <td><textarea rows="4" cols="50" name="comment"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Add comment"></td>
        </tr>

    </table>
</form>

<div class="comments_area">

    <?php if(!empty($output_comments)) : ?>

        <?php foreach($output_comments as $comment):?>

            <div class="individual_comment">

            <h2><?php echo htmlspecialchars($comment['title']); ?></h2>
            <div class="author"><?php echo htmlspecialchars($comment['name']); ?></div>
            <div class="comment_time"><?php echo htmlspecialchars($comment['created_at']); ?></div>
            <div class="comment_text"><?php echo htmlspecialchars($comment['comment']); ?></div>

            </div>
        <?php endforeach;?>

    <?php endif;?>


    </div>

</div>