<?php

declare(strict_types=1);

namespace App\Service;

use App\Lib\NpiUtility\NpiUtility;

/**
 * CMS NPI Registry Service
 *
 * @see https://npiregistry.cms.hhs.gov/registry/help-api
 */
class NpiRegistryService implements NpiServiceInterface
{
	/**
	 * @inheritDoc
	 */
	public function isValidOrganization(int $npiNumber): bool
	{
		return NpiUtility::isValidOrganization($npiNumber);
	}

	/**
	 * @inheritDoc
	 */
	public function isValidIndividual(int $npiNumber): bool
	{
		return NpiUtility::isValidIndividual($npiNumber);
	}

	/**
	 * @inheritDoc
	 */
	public function searchOrganizationByNumber(int $npiNumber): array
	{
		return NpiUtility::searchOrganizationByNumber($npiNumber);
	}

	// /**
	//  * @inheritDoc
	//  */
	// public function searchOrganizationByName(string $name, bool $exact = false): array
	// {
	// 	return NpiUtility::searchOrganizationByName($name, $exact);
	// }

	// /**
	//  * @inheritDoc
	//  */
	// public function searchOrganizationByState(string $state, bool $exact = false): array
	// {
	// 	return NpiUtility::searchOrganizationByState($state, $exact);
	// }

	// /**
	//  * @inheritDoc
	//  */
	// public function searchOrganizationByCity(string $city, bool $exact = false): array
	// {
	// 	return NpiUtility::searchOrganizationByCity($city, $exact);
	// }

	// /**
	//  * @inheritDoc
	//  */
	// public function searchOrganizationByZip(string $zip, bool $exact = false): array
	// {
	// 	return NpiUtility::searchOrganizationByZip($zip, $exact);
	// }

	/**
	 * @inheritDoc
	 */
	public function searchOrganizationByNameAndStateAndCityAndZip(string $name, string $state, string $city, string $zip, bool $exact = false): array
	{
		return NpiUtility::searchOrganizationByNameAndStateAndCityAndZip($name, $state, $city, $zip, $exact);
	}

	
	/**
	 * @inheritDoc
	 */
	public function searchOrganizationByNameAndStateAndCityAndZip(string $name, string $state, string $city, string $zip, bool $exact = false): array
	{
		return NpiUtility::searchOrganizationByNameAndStateAndCityAndZip($name, $state, $city, $zip, $exact);
	}

	/**
	 * @inheritDoc
	 */
	public function searchIndividualByNumber(int $npiNumber): array
	{
		return NpiUtility::searchIndividualByNumber($npiNumber);
	}

	/**
	 * @inheritDoc
	 */
	public function searchIndividualByName(string $firstName, string $lastName, bool $exact = true): array
	{
		return NpiUtility::searchIndividualByName($firstName, $lastName, $exact);
	}

	/**
	 * @inheritDoc
	 */
	public function searchIndividualByNameAndState(string $firstName, string $lastName, string $state, bool $exact = false): array
	{
		return NpiUtility::searchIndividualByNameAndState($firstName, $lastName, $state, $exact);
	}
}
