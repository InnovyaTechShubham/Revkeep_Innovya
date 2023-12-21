<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FacilityAddContact Entity
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $mobile_no
 * @property string|null $contact_type
 * @property string|null $email
 * @property string|null $title
 */
class FacilityAddContact extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'mobile_no' => true,
        'contact_type' => true,
        'email' => true,
        'title' => true,
    ];
}
