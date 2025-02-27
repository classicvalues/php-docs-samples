<?php

/**
 * Copyright 2019 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigtable/README.md
 */

// [START bigtable_list_column_families]
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;

/**
 * List column families of a table
 * @param string $projectId The Google Cloud project ID
 * @param string $instanceId The ID of the Bigtable instance
 * @param string $tableId The ID of the table for which the families need to be displayed
 */
function list_column_families(
    string $projectId,
    string  $instanceId,
    string $tableId
): void {
    $tableAdminClient = new BigtableTableAdminClient();

    $tableName = $tableAdminClient->tableName($projectId, $instanceId, $tableId);

    $table = $tableAdminClient->getTable($tableName);
    $columnFamilies = $table->getColumnFamilies()->getIterator();

    foreach ($columnFamilies as $k => $columnFamily) {
        printf('Column Family: %s' . PHP_EOL, $k);
        print('GC Rule:' . PHP_EOL);
        printf('%s' . PHP_EOL, $columnFamily->serializeToJsonString());
    }
}
// [END bigtable_list_column_families]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
