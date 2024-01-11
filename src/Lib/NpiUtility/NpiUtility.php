<?php

declare(strict_types=1);

namespace App\Lib\NpiUtility;

use App\Exception\NpiServiceRequestException;
use App\Exception\NpiServiceUnavailableException;
use Cake\Http\Client;
use RuntimeException;

/**
 * CMS NPI Registry Service
 *
 * @see https://npiregistry.cms.hhs.gov/registry/help-api
 */
class NpiUtility
{
	// API Endpoint
	public const API_PROTOCOL = 'https';
	public const API_HOSTNAME = 'npiregistry.cms.hhs.gov';
	public const API_BASE_PATH = '/api';
	public const API_VERSION = 2.1;

	// Constants
	public const ADDRESS_PURPOSE_LOCATION = 'LOCATION';
	public const ADDRESS_PURPOSE_MAILING = 'MAILING';
	public const ADDRESS_PURPOSE_PRIMARY = 'PRIMARY';
	public const ADDRESS_PURPOSE_SECONDARY = 'SECONDARY';
	public const ENUMERATION_TYPE_INDIVIDUAL = 'NPI-1';
	public const ENUMERATION_TYPE_ORGANIZATION = 'NPI-2';

	/**
	 * Validate an organization NPI number exists in the NPI Registry
	 *
	 * @param int $npiNumber
	 * @return bool
	 */
	public static function isValidOrganization(int $npiNumber): bool
	{
		$response = self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
			'number' => $npiNumber,
		]);

		return !empty($response);
	}

	/**
	 * Validate an individual NPI number exists in the NPI Registry
	 *
	 * @param int $npiNumber
	 * @return bool
	 */
	public static function isValidIndividual(int $npiNumber): bool
	{
		$response = self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
			'number' => $npiNumber,
		]);

		return !empty($response);
	}

	/**
	 * Lookup by NPI number for organizations in the NPI Registry
	 *
	 * @param int $npiNumber
	 * @return array<\App\Lib\NpiUtility\NpiOrganizationResult>
	 */
	public static function searchOrganizationByNumber(int $npiNumber): array
	{
		return self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
			'number' => $npiNumber,
		]);
	}

	/**
	 * Lookup by organization name for organizations in the NPI Registry
	 *
	 * @param string $name
	 * @param bool $exact
	 * @return array<\App\Lib\NpiUtility\NpiOrganizationResult>
	 */
	// public static function searchOrganizationByName(string $name, bool $exact = false): array
	// {
	// 	$orgName = str_replace('*', '', $name);

	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
	// 		'organization_name' => $orgName . (!$exact && strlen($orgName) >= 2 ? '*' : ''),
	// 	]);
	// }

	// public static function searchOrganizationByName(string $name, bool $exact = false): array
	// {
	// 	$orgName = str_replace('*', '', $name);

	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
	// 		'organization_name' => $orgName,
	// 	]);
	// }

	// public static function searchOrganizationByCity(string $city, bool $exact = false): array
	// {

	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
	// 		'city' => $city,
	// 	]);
	// }

	// public static function searchOrganizationByZip(string $zip, bool $exact = false): array
	// {

	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
	// 		'zip' => $zip,
	// 	]);
	// }

	// public static function searchOrganizationByCityAndZip(string $city, string $zip, bool $exact = false): array
	// {

	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
	// 		'city' => $city,
	// 		'zip' => $zip,
	// 	]);
	// }

	// public static function searchOrganizationByStateAndZip(string $state, string $zip, bool $exact = false): array
	// {

	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
	// 		'state' => $state,
	// 		'zip' => $zip,
	// 	]);
	// }
	
// 	public static function searchOrganizationByName(string $name, bool $exact = false): array
// {
//     $orgName = str_replace('*', '', $name);

//     // Retrieve organizations from the API
//     $allOrganizations = self::sendRequest([
//         'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
//         'organization_name' => $orgName . (!$exact && strlen($orgName) >= 2 ? '*' : ''),
//     ]);

//     // Filter organizations locally based on your criteria
//     $filteredOrganizations = array_filter($allOrganizations, function ($organization) use ($orgName) {
//         // Perform additional local filtering
//         return $this->isPartialMatch($organization['basic']['organization_name'], $orgName);
//     });

//     return array_values($filteredOrganizations);
// }

// /**
//  * Check if the given string is a partial match for the target string.
//  *
//  * @param string $haystack
//  * @param string $needle
//  * @return bool
//  */
// private function isPartialMatch(string $haystack, string $needle): bool
// {
//     // Perform your custom partial matching logic here
//     // For example, using stripos for case-insensitive partial matching
//     return stripos($haystack, $needle) !== false;
// }



	/**
	 * Lookup by organization name for organizations in the NPI Registry with state filter
	 *
	 * @param string $name
	 * @param string $state
	 * @param string $city
	 * @param string $zip
	 * @param bool $exact
	 * @return array<\App\Lib\NpiUtility\NpiOrganizationResult>
	 */
	public static function searchOrganizationByNameAndStateAndCityAndZip(string $name, string $state, string $city, string $zip, bool $exact = false): array
	{
		$orgName = str_replace('*', '', $name);

		$results = self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
			'organization_name' => $orgName . (!$exact && strlen($orgName) >= 2 ? '*' : ''),
			'state' => $state,
			'city' => $city,
			'postal_code' => $zip
		]);

		return $results;
	}

	// public static function searchOrganizationByNameAndStateAndCityAndZip(string $name, string $state, string $city, string $zip, bool $exact = false): array
    // {
    //     $orgName = str_replace('*', '', $name);
 
    //     $results = self::sendRequest([
    //         'enumeration_type' => self::ENUMERATION_TYPE_ORGANIZATION,
    //         'organization_name' => $orgName . (!$exact && strlen($orgName) >= 2 ? '*' : ''),
    //         'state' => $state,
    //         'city' => $city,
    //         'postal_code' => $zip
    //     ]);
 
    //     return $results;
    // }

	/**
	 * Lookup by individual name for people in the NPI Registry
	 *
	 * @param string $firstName
	 * @param string $lastName
	 * @param bool $exact
	 * @return array<\App\Lib\NpiUtility\NpiIndividualResult>
	 */
	public static function searchIndividualByName(string $firstName, string $lastName, bool $exact = true): array
	{
		return self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'use_first_name_alias' => $exact ? 'False' : 'True',
		]);
	}

	/**
	 * Lookup by individual name for people in the NPI Registry
	 *
	 * @param string $Npinumber
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $state
	 * @param string $city
	 * @param string $postalCode
	 * @param bool $exact
	 * @return array<\App\Lib\NpiUtility\NpiIndividualResult>
	 */
	public static function searchIndividualByNameAndState(string $firstName, string $lastName, string $state, string $city, string $postalCode, bool $exact = true): array
	{
		return self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
			//'Npi_number' => $npiNumber,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'state' => $state,
			'city' => $city,
			'postal_code' => $postalCode,
			'use_first_name_alias' => $exact ? 'False' : 'True',
		]);
	}

	// /**
	//  * Lookup by individual city for people in the NPI Registry
	//  *
	//  * @param string $city
	//  * @param bool $exact
	//  * @return array<\App\Lib\NpiUtility\NpiIndividualResult>
	//  */
	// public static function searchIndividualByCity(string $city, bool $exact = true): array
	// {
	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
	// 		'city' => $city,
	// 		'use_first_name_alias' => $exact ? 'False' : 'True',
	// 	]);
	// }

	// /**
	//  * Lookup by individual zip for people in the NPI Registry
	//  *
	//  * @param string $postalCode
	//  * @param bool $exact
	//  * @return array<\App\Lib\NpiUtility\NpiIndividualResult>
	//  */
	// public static function searchIndividualByZip(string $postalCode, bool $exact = true): array
	// {
	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
	// 		'zip' => $postalCode,
	// 		'use_first_name_alias' => $exact ? 'False' : 'True',
	// 	]);
	// }


	// /**
	//  * Lookup by individual zip for people in the NPI Registry
	//  *
	//  * @param string $state
	//  * @param bool $exact
	//  * @return array<\App\Lib\NpiUtility\NpiIndividualResult>
	//  */
	// public static function searchIndividualByState(string $state, bool $exact = true): array
	// {
	// 	return self::sendRequest([
	// 		'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
	// 		'zip' => $state,
	// 		'use_first_name_alias' => $exact ? 'False' : 'True',
	// 	]);
	// }


	/**
	 * Lookup by individual npi number for people in the NPI Registry
	 *
	 * @param int $npiNumber
	 * @return array<\App\Lib\NpiUtility\NpiIndividualResult>
	 */
	public static function searchIndividualByNumber(int $npiNumber): array
	{
		return self::sendRequest([
			'enumeration_type' => self::ENUMERATION_TYPE_INDIVIDUAL,
			'number' => $npiNumber,
		]);
	}

	/**
	 * Turn an organization result into a model
	 *
	 * @param array $result
	 * @return \App\Lib\NpiUtility\NpiOrganizationResult
	 */
	private static function parseOrganizationResult(array $result): NpiOrganizationResult
	{
		$e = new NpiOrganizationResult();

		$e->name = $result['basic']['organization_name'];
		$e->organization_name = $result['basic']['organization_name'];

		$e->number = intval($result['number']);
		$e->organizational_subpart = trim($result['basic']['organizational_subpart']) == 'YES' ? true : false; // YES/NO
		$e->active = trim($result['basic']['status']) == 'A' ? true : false; // A

		$e->authorized_official_first_name = $result['basic']['authorized_official_first_name'] ?? null;
		$e->authorized_official_last_name = $result['basic']['authorized_official_last_name'] ?? null;
		$e->authorized_official_middle_name = $result['basic']['authorized_official_middle_name'] ?? null;
		$e->authorized_official_telephone_number = $result['basic']['authorized_official_telephone_number'] ?? null;
		$e->authorized_official_title_or_position = $result['basic']['authorized_official_title_or_position'] ?? null;
		$e->authorized_official_name_prefix = $result['basic']['authorized_official_name_prefix'] ?? null;

		$e->created_epoch = intval($result['created_epoch']);
		$e->enumeration_date = $result['basic']['enumeration_date']; // YYYY-MM-DD

		$e->last_updated = $result['basic']['last_updated']; // YYYY-MM-DD
		$e->last_updated_epoch = intval($result['last_updated_epoch']);

		$e->enumeration_type = $result['enumeration_type']; // NPI-1 (Individual) / NPI-2 (Organization)

		$e->addresses = $result['addresses'];
		$e->identifiers = $result['identifiers'];
		$e->other_names = $result['other_names'];
		$e->taxonomies = $result['taxonomies'];

		return $e;
	}

	/**
	 * Turn an individual (person) result into a model
	 *
	 * @param array $result
	 * @return \App\Lib\NpiUtility\NpiIndividualResult
	 */
	private static function parseIndividualResult(array $result): NpiIndividualResult
	{
		$e = new NpiIndividualResult();

		$e->name = $result['basic']['first_name'] . ' ' . $result['basic']['last_name'];
		$e->number = intval($result['number']);
		$e->active = trim($result['basic']['status']) == 'A' ? true : false; // A

		$e->first_name = $result['basic']['first_name'] ?? '';
		$e->last_name = $result['basic']['last_name'] ?? '';
		$e->credential = $result['basic']['credential'] ?? '';
		$e->sole_proprietor = $result['basic']['sole_proprietor'] == 'NO' ? false : true;
		$e->gender = $result['basic']['gender'] ?? '';

		$e->created_epoch = intval($result['created_epoch']);
		$e->enumeration_date = $result['basic']['enumeration_date']; // YYYY-MM-DD

		$e->last_updated = $result['basic']['last_updated']; // YYYY-MM-DD
		$e->last_updated_epoch = intval($result['last_updated_epoch']);

		$e->enumeration_type = $result['enumeration_type']; // NPI-1 (Individual) / NPI-2 (Organization)

		$e->addresses = $result['addresses'];
		$e->identifiers = $result['identifiers'];
		$e->other_names = $result['other_names'];
		$e->taxonomies = $result['taxonomies'];

		return $e;
	}

	/**
	 * Send a request to the CMS NPI Registry API and get array of results
	 *
	 * @param array $parameters
	 * @param int $page
	 * @param int $limit
	 * @return \App\Lib\NpiUtility\NpiOrganizationResult[]|\App\Lib\NpiUtility\NpiIndividualResult[]
	 * @throws \Cake\Core\Exception\CakeException
	 * @throws \App\Lib\NpiUtility\InvalidArgumentException
	 * @throws \App\Lib\NpiUtility\GlobalInvalidArgumentException
	 */
	private static function sendRequest(array $parameters, int $page = 1, int $limit = 30): array
	{
		$enumerationType = $parameters['enumeration_type'] ?? self::ENUMERATION_TYPE_ORGANIZATION;

		$skip = ($page - 1) * $limit;

		$config = [
			'version' => self::API_VERSION,
			'limit' => $limit,
			'skip' => $skip,
		];

		$apiClient = new Client([
			'host' => self::API_HOSTNAME,
			'scheme' => self::API_PROTOCOL,
			'basePath' => self::API_BASE_PATH,
		]);

		$mergedConfig = array_merge($config, $parameters);

		$response = $apiClient->get('/', $mergedConfig);

		if (!$response->isSuccess()) {
			throw new NpiServiceUnavailableException();
		}

		$json = $response->getJson();

		if (!empty($json['Errors'])) {
			$errors = array_column($json['Errors'], 'description');
			$message = implode(', ', $errors);
			throw new NpiServiceRequestException($message);
		}

		if (empty($json['results'])) {
			return [];
		}

		return array_map(function ($result) use ($enumerationType) {
			switch ($enumerationType) {
				case self::ENUMERATION_TYPE_ORGANIZATION:
					return self::parseOrganizationResult($result);
					break;
				case self::ENUMERATION_TYPE_INDIVIDUAL:
					return self::parseIndividualResult($result);
					break;
				default:
					throw new RuntimeException(__('Unknown NPI enumeration type'));
					break;
			}
		}, $json['results']);
	}
}