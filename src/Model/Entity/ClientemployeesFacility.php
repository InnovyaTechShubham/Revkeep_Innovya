<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientemployeesFacility Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property int $facility_id
 * @property int $client_id
 *
 * @property \App\Model\Entity\Facility $facility
 * @property \App\Model\Entity\Client $client
 */
class ClientemployeesFacility extends Entity
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
        'created' => true,
        'deleted' => true,
        'facility_id' => true,
        'client_id' => true,
        'facility' => true,
        'client' => true,
    ];
}
