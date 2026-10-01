<?php

use CodeIgniter\Pager\PagerRenderer;

/** @var PagerRenderer $pager */
$pager->setSurroundCount(2);
?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-sm mb-0 justify-content-center justify-content-md-start flex-wrap gap-1">

        <?php if ($pager->hasPrevious()): ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="First" title="Halaman pertama">
                <span aria-hidden="true">«</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous" title="Sebelumnya">
                <span aria-hidden="true">‹</span>
            </a>
        </li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link): ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
            <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
        </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()): ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next" title="Berikutnya">
                <span aria-hidden="true">›</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Last" title="Halaman terakhir">
                <span aria-hidden="true">»</span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</nav>
