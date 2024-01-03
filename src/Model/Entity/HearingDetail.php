<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HearingDetail Entity
 *
 * @property int $id
 * @property int $appealLevelId
 * @property \Cake\I18n\FrozenDate|null $hearingDate
 * @property \Cake\I18n\Time|null $hearingTime
 * @property string|null $meetingType
 */
class HearingDetail extends Entity
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
        'appealLevelId' => true,
        'hearingDate' => true,
        'hearingTime' => true,
        'meetingType' => true,
    ];
}
