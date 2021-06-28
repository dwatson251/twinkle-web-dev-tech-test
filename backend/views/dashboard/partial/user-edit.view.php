<?php
use Twinkl\Dashboard\Widget\User\DashboardUserEditWidget;

/** @var DashboardUserEditWidget $widget */
$widget;
?>

<div class="widget widget-block dash-user-edit"
     data-user-id="<?= $this->e($widget->getId()) ?>"
     >
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

        <input name="id"
               type="hidden"
               value="<?= $this->e($widget->getId()) ?>"
               />

        <div class="form-control-block">
            <input type="submit" />
            <a class="form-control btn update-btn" href="#">Update</a>
            <a class="form-control btn delete-btn" href="#">Delete</a>
        </div>
    </form>
</div>
