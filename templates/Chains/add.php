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
            <?= $this->Html->link(__('List Chains'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chains form content">
            <?= $this->Form->create($chain) ?>
            <fieldset>
                <legend><?= __('Add Chain') ?></legend>
                <?php
                    echo $this->Form->control('chain_name');
                    echo $this->Form->control('chain_type');
                    echo $this->Form->control('client_id');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
