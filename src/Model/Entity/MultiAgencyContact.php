<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MultiAgencyContact Entity
 *
 * @property int $id
 * @property string $agency_email
 * @property string|null $agency_fax
 * @property string $desc_email
 * @property string|null $desc_fax
 */
class MultiAgencyContact extends Entity
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
        'agency_email' => true,
        'agency_fax' => true,
        'desc_email' => true,
        'desc_fax' => true,
    ];
}
