<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2022.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace App\Migration;

use Lyrasoft\Attachment\Entity\Attachment;
use Windwalker\Core\Migration\AbstractMigration;
use Windwalker\Core\Migration\MigrateUp;
use Windwalker\Core\Migration\MigrateDown;
use Windwalker\Database\Schema\Schema;

return new /** 2022071508530001_Attachment */ class extends AbstractMigration {
    #[MigrateUp]
    public function up(): void
    {
        $this->createTable(
            Attachment::class,
            function (Schema $schema) {
                $schema->primary('id')->comment('ID');
                $schema->varchar('type')->comment('類型');
                $schema->integer('target_id')->comment('目標 ID');
                $schema->varchar('title')->comment('檔案名稱');
                $schema->varchar('alt')->comment('Alt');
                $schema->integer('size')->comment('檔案大小');
                $schema->varchar('mime')->comment('媒體類型');
                $schema->varchar('path')->comment('路徑');
                $schema->text('description')->comment('內容');
                $schema->integer('ordering')->comment('Ordering');
                $schema->datetime('created')->comment('Created Date');
                $schema->datetime('modified')->comment('Modified Date');
                $schema->json('params')->comment('Params');

                $schema->addIndex('target_id');
            }
        );
    }

    #[MigrateDown]
    public function down(): void
    {
        $this->dropTables(Attachment::class);
    }
};
