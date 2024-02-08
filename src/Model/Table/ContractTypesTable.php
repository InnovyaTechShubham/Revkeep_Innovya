<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ContractTypesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('contract_types');
    }
}
