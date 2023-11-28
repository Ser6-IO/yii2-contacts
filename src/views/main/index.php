<?php
$people = \ser6io\yii2contacts\models\Person::find()->notDeleted()->count();
$organizations = \ser6io\yii2contacts\models\Organization::find()->notDeleted()->count();
?>


<h1>Contacts</h1>

<div class="row">
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-3">
            <div class="card-body">

                <div class="hstack">

                    <a href="/contacts/person/index" class="card-link text-decoration-none lead">People</a>                    

                    <p class="display-6 ms-auto"><span class="badge bg-info"><?= $people ?></span></p>    
                    
                </div>
                
                <div class="hstack">
                    <a class="btn btn-outline-success" href="/contacts/person/create" title="New" data-bs-toggle="tooltip">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                    &nbsp;
                    <div class="input-group">    
                        <input type="text" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-secondary"  title="Search" data-bs-toggle="tooltip" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6">
        <div class="card mb-3">
            <div class="card-body">

                <div class="hstack">

                    <a href="/contacts/organization/index" class="card-link text-decoration-none lead">Organizations</a>                    

                    <p class="display-6 ms-auto"><span class="badge bg-info"><?= $organizations ?></span></p>    
                    
                </div>
                
                <div class="hstack">
                    <a class="btn btn-outline-success" href="/contacts/organization/create" title="New" data-bs-toggle="tooltip">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                    &nbsp;
                    <div class="input-group">    
                        <input type="text" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-secondary"  title="Search" data-bs-toggle="tooltip" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>