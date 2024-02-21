<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdateContractPricingScheduleInsuranceTypesForeignKey extends AbstractMigration
{
    public function change()
    {
        $this->table('contract_pricing_schedules')
            ->changeColumn('insurance_type_id', 'integer', [
                'null' => false,
            ])
            ->update();
    }
}