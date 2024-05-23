<?php
include "../parts/index.php"
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Category count
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Blog Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    View Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    My blogs View Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    My Deactive Blog Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    This month blog count
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    TOP 3 Blog
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    TOP 3 Blog in this month
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Users blog view count
                </div>
                <div class="card-body">
                    <h5 class="card-title"> . " : " . $usersBlog['sum'] ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Blog count by Categories
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Blog count by Creator
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>