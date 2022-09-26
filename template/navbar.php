<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <a class="navbar-brand" href="<?= base_url() ?>" style="display: inline-flex;align-items:center;justify-content:center;">
        <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" width="40" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto font-weight-light">
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url() ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('category/hentai') ?>">Hentai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('category/3d') ?>">3D Hentai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('category/jav') ?>">JAV</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('category/cosplay') ?>">JAV Cosplay</a>
            </li>
        </ul>
        <form class="my-2 my-lg-0" id="form" method="get" action="<?= base_url('search') ?>">
            <input id="searchx" name="s" class="form-control my-2 my-sm-0 mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button id="submit" class="my-2 my-sm-0" type="submit" name="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</nav>