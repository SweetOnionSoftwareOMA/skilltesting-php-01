<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class VCFormData extends AbstractMigration
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
		$vc_form = $this->table('vc_form_data', ['primary_key' => 'vc_form_data_id', 'id' => false]);
		$vc_form->addColumn('vc_form_data_id','integer', ['identity' => true, 'seed' => 1, 'increment' => 1])
			    ->addColumn('user_id','integer', ['null' => false])
			    ->addForeignKey('user_id', 'users', 'user_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			    ->addColumn('office_id','integer', ['null' => false])
			    ->addForeignKey('office_id', 'offices', 'office_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			    ->addColumn('reporting_week', 'date', ['null' => false])
			    ->addColumn('location_gross_sales', 'double', ['null' => false])
			    ->addColumn('secondpair_eligible', 'double', ['null' => false])
			    ->addColumn('secondpair_accepted', 'double', ['null' => false])
                ->addColumn('created_at', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			    ->addColumn('updated_at', 'timestamp', ['null' => true, 'timezone' => true])
			    ->addColumn('deleted_at', 'timestamp', ['null' => true, 'timezone' => true])
			    ->addColumn('deleted', 'boolean', ['default' => false])
                ->addIndex(['user_id', 'office_id', 'reporting_week'], ['unique'=>true])
			    ->create();
    }
}
