<?php
require_once "config.php";
$n =  new Nekopoi;
$path = isset($_GET['path']) ? $_GET['path'] : die("Something was wrong!");
$n = $n->getH($path);
if ($n['code'] != 200) {
    die('Something was wrong');
}
preg_match_all('/.+?(?=-ep)/', $path, $all);
$data = $n['result'];
$title = $data['title'];
require_once "template/header.php";
?>

<body>
    <?php require_once "template/navbar.php"; ?>
    <div class="jumbotron">
        <img width="100%" height="auto" data-original="<?= $data['image'] ?>" class="lazy rounded-bottom" loading="lazy" alt="">
    </div>
    <!-- <div class="mx-5 my-5"> -->
    <div class="card mx-2 mx-lg-5 mb-5">
        <div class="card-body px-lg-5 py-lg-4">
            <h5 class="card-title"><?= $data['title'] ?></h5>
            <hr color="#fff">
            <ul>
                <li>
                    <b>Genre :</b>
                    <font class="text2"> <?= $data['genre'] ?> </font>
                </li>
                <li>
                    <b>Sinopsis :</b>
                    <font class="text2"><?= $data['sinopsis'] ?></font>
                </li>
                <?php if ($all[0][0] != null) : ?>
                    <li>
                        <b>All Episode :</b>
                        <a class="text2" target="_blank" href="<?= base_url('series/') . $all[0][0] ?>">Click Here</a>
                    </li>
                <?php endif ?>

            </ul>
            <hr color="#fff">
            <h5 class="card-title">Link Download</h5>
            <ul class="list">
                <?php foreach ($data['download'] as $dl) : ?>
                    <li class="list-item mb-2">
                        <?php
                        preg_match_all("/([^[])+([^]])/", $dl[0], $tl)
                        ?>
                        <strong><?= $tl[0][1] ?></strong>
                        <?php foreach ($dl[1] as $s) : ?>
                            <a class="item-download" target="_blank" href="<?= base_url('goto.php?url=') . $s[1] ?>"><?= $s[0] ?></a>
                        <?php endforeach ?>
                    </li>
                <?php endforeach ?>

            </ul>
            <hr color="#fff">
            <h5 class="card-title">Related</h5>
            <div class="row">
                <?php foreach ($n['relates'] as $r) : ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <a href="<?= base_url('series') ?><?= $r['link'] ?>">
                            <div class=" card">
                                <img data-original="<?= $r['image'] ?>" class="lazy" alt="<?= $r['title'] ?>" height="300px" width="100%">
                                <div class="card-img-overlay text-white d-flex justify-content-center align-items-end shadow">
                                    <p><?= $r['title'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

    </div>
    <!-- </div> -->

    <?php require_once "template/footer.php" ?>
</body>

</html>