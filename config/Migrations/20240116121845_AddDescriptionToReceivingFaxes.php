<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddDescriptionToReceivingFaxes extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up()
    {
        // Define the table and column
        $table = $this->table('receiving_faxes');
        $table->addColumn('description', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'fax', // Add 'after' clause to specify the position of the new column
        ]);
        $table->update(); // Apply the changes
    }

    /**
     * Down Method.
     *
     * @return void
     */
    public function down()
    {
        // Rollback the changes if needed
        $table = $this->table('receiving_faxes');
        $table->removeColumn('description');
        $table->update();
    }
}