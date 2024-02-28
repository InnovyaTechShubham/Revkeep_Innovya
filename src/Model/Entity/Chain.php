<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chain Entity
 *
 * @property int $id
 * @property string $chain_name
 * @property string|null $chain_type
 * @property string|null $client_id
 */
class Chain extends Entity
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
        'chain_name' => true,
        'chain_type' => true,
        'client_id' => true,
    ];
}
