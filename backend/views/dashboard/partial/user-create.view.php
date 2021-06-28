<?php
use Twinkl\Dashboard\Widget\User\DashboardUserEditWidget;

/** @var DashboardUserEditWidget $widget */
$widget;
?>

<div class="widget widget-block dash-user-create">
    <form action="#">
        <div class="form-field-block">
            <label>Firstname: </label>
            <input name="firstname"
                   value="<?= $this->e($widget->getFirstname()) ?>"
                   placeholder="Enter firstname..."
                   />
        </div>

        <div class="form-field-block">
            <label>Lastname: </label>
            <input name="lastname"
                   value="<?= $this->e($widget->getLastname()) ?>"
                   placeholder="Enter lastname..."
                   />
        </div>
        
        <div class="form-control-block">
            <input type="submit" />
            <a class="form-control btn create-btn" href="#">Create</a>
            <a class="form-control btn cancel-btn" href="#">Cancel</a>
        </div>
    </form>
</div>
