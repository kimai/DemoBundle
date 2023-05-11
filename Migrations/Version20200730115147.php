<?php

declare(strict_types=1);

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DemoBundle\Migrations;

use App\Doctrine\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20200730115147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the demo table';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('kimai2_demo')) {
            $tasks = $schema->createTable('kimai2_demo');
            $tasks->addColumn('id', 'integer', ['autoincrement' => true, 'notnull' => true]);
            $tasks->addColumn('name', 'string', ['notnull' => true, 'length' => 100]);
            $tasks->addColumn('value', 'text', ['notnull' => false]);
            $tasks->setPrimaryKey(['id']);
            $tasks->addIndex(['name']);
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('kimai2_demo')) {
            $schema->dropTable('kimai2_demo');
        }
    }
}
