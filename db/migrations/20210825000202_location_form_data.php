<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class LocationFormData extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
		$location_form = $this->table('location_form_data', ['primary_key' => 'location_form_data_id', 'id' => false]);
		$location_form->addColumn('location_form_data_id','integer', ['identity' => true, 'seed' => 1, 'increment' => 1])
			      ->addColumn('user_id','integer', ['null' => false])
			      ->addForeignKey('user_id', 'users', 'user_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			      ->addColumn('office_id','integer', ['null' => false])
			      ->addForeignKey('office_id', 'offices', 'office_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			      ->addColumn('reporting_week', 'date', ['null' => false])
			      ->addColumn('cash_not_collected', 'double', ['null' => false])
			      ->addColumn('cash_collected', 'double', ['null' => false])
			      ->addColumn('dailylog_cash', 'double', ['null' => false])
			      ->addColumn('scheduled_encounters', 'double', ['null' => false])
			      ->addColumn('ecounters_confirmed', 'double', ['null' => false])
			      ->addColumn('encounters_patients', 'double', ['null' => false])
			      ->addColumn('encounters_newpatients', 'double', ['null' => false])
			      ->addColumn('insurance_authorizations', 'double', ['null' => false])
			      ->addColumn('total_retinal_images_accepted', 'double', ['null' => false])
			      ->addColumn('encounters_routine', 'double', ['null' => false])
			      ->addColumn('encounters_medical', 'double', ['null' => false])
			      ->addColumn('medical_insurance_card_collected', 'double', ['null' => false])
			      ->addColumn('glasses_eligible_encounters', 'double', ['null' => false])
			      ->addColumn('glasses_purchase_encounters', 'double', ['null' => false])
			      ->addColumn('contacts_eligible_encounters', 'double', ['null' => false])
			      ->addColumn('contacts_purchase', 'double', ['null' => false])
			      ->addColumn('payment_plans_accepted', 'double', ['null' => false])
			      ->addColumn('social_reviews_google', 'double', ['null' => false])
			      ->addColumn('social_reviews_facebook', 'double', ['null' => false])
			      ->addColumn('created_at', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			      ->addColumn('updated_at', 'timestamp', ['null' => true, 'timezone' => true])
			      ->addColumn('deleted_at', 'timestamp', ['null' => true, 'timezone' => true])
			      ->addColumn('deleted', 'boolean', ['default' => false])
                  ->addIndex(['user_id', 'office_id', 'reporting_week'], ['unique'=>true])
                  ->create();
    }
}
