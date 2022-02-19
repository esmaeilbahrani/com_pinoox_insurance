<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\TablePrefixAdapter;

final class User extends AbstractMigration
{
    public function change(): void
    {
        $this->table("user", ['id' => "user_id",'signed' => false])
            ->addColumn("group_key", "string")
            ->create();

        $tableAdapter = new TablePrefixAdapter($this->getAdapter());
        $prefix = $tableAdapter->getPrefix();

        $this->execute("ALTER TABLE `{$prefix}user`
    ADD CONSTRAINT `{$prefix}user_user_id` FOREIGN KEY (`user_id`) REFERENCES `pincore_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;");
    }
}
