<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Chain> $chains
 */
?>
<div class="chains index content">
    <?= $this->Html->link(__('New Chain'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Chains') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('chain_name') ?></th>
                    <th><?= $this->Paginator->sort('chain_type') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chains as $chain): ?>
                <tr>
                    <td><?= $this->Number->format($chain->id) ?></td>
                    <td><?= h($chain->chain_name) ?></td>
                    <td><?= h($chain->chain_type) ?></td>
                    <td><?= h($chain->client_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $chain->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chain->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chain->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
