<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Withdrawn Entity.
 */
class WithdrawnReason extends Entity
{
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * @var array
	 */
	protected $_accessible = [
		'id' => false,
		'*' => true,
	];

	/**
	 * Exposed virtual fields
	 *
	 * @var array
	 */
	protected $_virtual = [];
}
