<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chain $chain
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Chain'), ['action' => 'edit', $chain->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Chain'), ['action' => 'delete', $chain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chain->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Chains'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Chain'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chains view content">
            <h3><?= h($chain->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Chain Name') ?></th>
                    <td><?= h($chain->chain_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chain Type') ?></th>
                    <td><?= h($chain->chain_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Client Id') ?></th>
                    <td><?= h($chain->client_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($chain->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
