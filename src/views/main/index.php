<h1>Contacts Module</h1>

<div class="row">
    <div class="col-3">
        <div class="card ">
            <div class="card-body hstack">
                <h2 class="card-title"><a href="/contacts/person/index" class="card-link text-decoration-none">People</a></h2>
                <span class="badge bg-secondary ms-auto"><?= $people ?></span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card ">
            <div class="card-body hstack">
                <h2 class="card-title"><a href="/contacts/organization/index" class="card-link text-decoration-none">Organizations</a></h2>
                <span class="badge bg-secondary ms-auto"><?= $organizations ?></span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card ">
            <div class="card-body hstack">
                <h2 class="card-title"><a href="/contacts/address/index" class="card-link text-decoration-none">Addresses</a></h2>
                <span class="badge bg-secondary ms-auto"><?= $addresses ?></span>
            </div>
        </div>
    </div>

</div>