<div class="form-row">
	<?php foreach ($phq_list as $item): ?>
        <div class="form-group col-md-6">
            <label>
                <?php echo $item['question'] ?>
            </label>
        </div> <!-- form-group end.// -->
        <div class="form-group col-md-6">
            <div>
                <input type="radio" name="<?php $item['id'] ?>" value="0" checked>
                <label>Not at all</label>
            </div>
            <div>
                <input type="radio" name="<?php $item['id'] ?>" value="1">
                <label>Several days</label>
            </div>
            <div>
                <input type="radio" name="<?php $item['id'] ?>" value="2">
                <label>More than half the days</label>
            </div>
            <div>
                <input type="radio" name="<?php $item['id'] ?>" value="3">
                <label>Nearly every day</label>
            </div>
        </div> <!-- form-group end.// -->
	<?php endforeach; ?>
</div> <!-- form-row.// -->
