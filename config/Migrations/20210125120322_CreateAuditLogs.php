<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * Copied from lorenzo/audit-stash 20171018185609_CreateAuditLogs.php
 */
class CreateAuditLogs extends AbstractMigration
{
	public $autoId = false;

	public function up()
	{
		$this->table('audit_logs')
			->addColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'limit' => 10,
				'null' => false,
				'signed' => false,
			])
			->addPrimaryKey(['id'])
			->addColumn('transaction', 'uuid', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('type', 'string', [
				'default' => null,
				'limit' => 7,
				'null' => false,
			])
			->addColumn('primary_key', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->addColumn('source', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('parent_source', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('original', 'text', [
				'default' => null,
				'null' => true,
			])
			->addColumn('changed', 'text', [
				'default' => null,
				'null' => true,
			])
			->addColumn('meta', 'text', [
				'default' => null,
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addIndex(
				[
					'transaction',
				]
			)
			->addIndex(
				[
					'type',
				]
			)
			->addIndex(
				[
					'primary_key',
				]
			)
			->addIndex(
				[
					'source',
				]
			)
			->addIndex(
				[
					'parent_source',
				]
			)
			->addIndex(
				[
					'created',
				]
			)
			->create();
	}

	public function down()
	{
		$this->dropTable('audit_logs');
	}
}
