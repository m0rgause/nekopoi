<?php
require_once "config.php";
$path = (strlen($_GET['path']) > 1) ? $_GET['path'] : die('something was wrong');
$n = new Nekopoi;
$n = $n->getSeries(urldecode($path));
if ($n['code'] != 200) {
    die('something was wrong');
}
$data = $n['result'];
$title = $data['title'];
require_once "template/header.php";
?>

<body>
    <?php require_once "template/navbar.php" ?>
    <div class="mx-3 my-5 row">
        <div class="col-lg col-md col-sm col-12">
            <img src="<?= $data['image'] ?>" alt="" height="auto" width="100%">
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-12">
            <div class="card">
                <div class="card-body ">
                    <h4 class="card-title text2"><?= $data['title'] ?></h4>
                    <ul class="list">
                        <hr color="#fff">
                        <li><b class="text1">Genre : </b>
                            <?php foreach ($data['genre'] as $g) : ?>
                                <font class="text2"><?= $g ?></font>,
                            <?php endforeach ?>
                        </li>
                        <li>
                            <b class="text1">Produser : </b>
                            <font class="text2"><?= $data['produser'] ?></font>
                        </li>
                        <li>
                            <b class="text1">Total Episode : </b>
                            <font class="text2"><?= $data['total_episode'] ?></font>
                        </li>
                        <li><b class="text1">Sinopsis : </b>
                            <font class="text2"><?= $data['sinopsis'] ?></font>
                        </li>

                    </ul>
                    <hr color="#fff">
                    <h6 class="card-title text2">List Episode</h6>
                    <div class="px-3 py-3" style="background-color: var(--dark4);">
                        <ul class="list-inline">
                            <?php foreach ($data['episode_list'] as $e) : ?>
                                <li class="list-inline-item">
                                    <a class="item-download" href="<?= base_url('p') . $e['link'] ?>">
                                        <?= $e['episode'] ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>