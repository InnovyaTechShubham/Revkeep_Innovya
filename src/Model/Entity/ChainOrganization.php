<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChainOrganization Entity
 *
 * @property int $id
 * @property string $chain_id
 * @property string|null $facility_id
 * @property string|null $service_id
 *
 * @property \App\Model\Entity\Chain $chain
 * @property \App\Model\Entity\Facility $facility
 * @property \App\Model\Entity\Service $service
 */
class ChainOrganization extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'chain_id' => true,
        'facility_id' => true,
        'service_id' => true,
        'chain' => true,
        'facility' => true,
        'service' => true,
    ];
}
