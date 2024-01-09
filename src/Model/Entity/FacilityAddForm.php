<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FacilityAddForm Entity
 *
 * @property int $id
 * @property string|null $f_name
 * @property string|null $l_name
 * @property string|null $phone_no
 * @property string|null $contact_id
 * @property string|null $email
 * @property string|null $title_id
 */
class FacilityAddForm extends Entity
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
        'f_name' => true,
        'l_name' => true,
        'phone_no' => true,
        'contact_id' => true,
        'email' => true,
        'title_id' => true,
    ];
}
