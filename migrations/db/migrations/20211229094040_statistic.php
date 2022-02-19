<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Statistic extends AbstractMigration
{
    public function change(): void
    {
        $this->table("statistic", ['id' => "stat_id",'signed' => false])
            ->addColumn("visitors", "integer",['default' => 0])
            ->addColumn("visits", "integer",['default' => 0])
            ->addColumn("insert_date", "datetime",['null' => true])
            ->addColumn("json_data", "text",['null' => true])
            ->create();
    }
}
