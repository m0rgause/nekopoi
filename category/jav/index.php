<?php
require_once "../../config.php";
$n =  new Nekopoi;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$n = $n->Category($page, 'jav');
if ($n['code'] != 200) {
    die('hehe');
}
$data = $n['result'];
$title = "Home";
?>
<?php require_once "../../template/header.php" ?>

<body>
    <?php require_once "../../template/navbar.php" ?>
    <div class="mx-5 mt-5">
        <p>Kategori : JAV</p>
        <div class="row">
            <?php foreach ($data as $d) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <a href="<?= base_url("p") . $d['link'] ?>">
                        <div class="card card2 shadow">
                            <div class="card-header">
                                <img data-original="<?= $d['image'] ?>" class="card-img-top lazy" loading="lazy" alt="<?= $d['title'] ?>">
                            </div>
                            <div class="card-body clamping text-center ">
                                <p class="card-text "><?= $d['title'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>


    <nav aria-label="Page navigation" class="mt-5">
        <ul class="pagination justify-content-center">
            <?php if ($page > 6) : ?>
                <li class="page-item"> <a class="page-link" href="<?= base_url('category/jav/?page=1') . 1 ?>">Awal</a> </li>
            <?php endif ?>
            <?php if ($page > 1) : ?>
                <li class="page-item"> <a class="page-link" href="<?= base_url('category/jav/?page=') . $page - 1 ?>"><i class="fas fa-arrow-left"></i></a> </li>
            <?php endif ?>
            <?php if ($page > 2) : ?>
                <?php for ($i = 1; 0 < $i; $i--) : ?>
                    <li class="page-item"><a class="page-link" href="<?= base_url('category/jav/?page=') . $page - $i ?>"><?= $page - $i ?></a></li>
                <?php endfor; ?>
            <?php endif ?>
            <li class="page-item"><a class="page-link active" href="#page"><?= $page ?></a></li>

            <?php if ($n['max_page'] != '') : ?>
                <?php if ($page != $n['max_page']) : ?>
                    <?php for ($i = 1; $i < 3; $i++) : ?>
                        <li class="page-item"><a class="page-link" href="<?= base_url('category/jav/?page=') . $page + $i ?>"><?= $page + $i ?></a></li>
                    <?php endfor; ?>
                <?php endif ?>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="<?= base_url('category/jav/?page=') . $n['max_page'] ?>"><?= $n['max_page'] ?></a></li>
            <?php endif ?>

            <li class="page-item"><a class="page-link" href="<?= base_url('category/jav/?page=') . $page + 1 ?>"><i class="fas fa-arrow-right"></i></a></li>
        </ul>
    </nav>

    <?php require_once "../../template/footer.php" ?>


</body>

</html>