<?php

namespace Google\Cloud\Samples\Bigtable;

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

// [START bigtable_reads_rows]
use Google\Cloud\Bigtable\BigtableClient;

/**
 * Read rows using an array of keys
 * @param string $projectId The Google Cloud project ID
 * @param string $instanceId The ID of the Bigtable instance
 * @param string $tableId The ID of the table to read from
 */
function read_rows(
    string $projectId,
    string $instanceId,
    string $tableId
): void {
    // Connect to an existing table with an existing instance.
    $dataClient = new BigtableClient([
        'projectId' => $projectId,
    ]);
    $table = $dataClient->table($instanceId, $tableId);

    $rows = $table->readRows(
        ['rowKeys' => ['phone#4c410523#20190501', 'phone#4c410523#20190502']]
    );

    foreach ($rows as $key => $row) {
        print_row($key, $row);
    }
}
// [END bigtable_reads_rows]

// Helper function for printing the row data
function print_row($key, $row)
{
    printf('Reading data for row %s' . PHP_EOL, $key);
    foreach ((array) $row as $family => $cols) {
        printf('Column Family %s' . PHP_EOL, $family);
        foreach ($cols as $col => $data) {
            for ($i = 0; $i < count($data); $i++) {
                printf(
                    "\t%s: %s @%s%s" . PHP_EOL,
                    $col,
                    $data[$i]['value'],
                    $data[$i]['timeStamp'],
                    $data[$i]['labels'] ? sprintf(' [%s]', $data[$i]['labels']) : ''
                );
            }
        }
    }
    print(PHP_EOL);
}

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
