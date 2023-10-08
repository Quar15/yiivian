#!/bin/bash

LIST_OF_COMMANDS="$(./yii queue/list-unprocessed | grep -v 'debug')"
NUMBER_OF_COMMANDS="$(echo "$LIST_OF_COMMANDS" | grep -v ^$ | wc -l)"

echo "@INFO: Commands to process - ${NUMBER_OF_COMMANDS}"

IFS=$'\n'

for full_cmd in $LIST_OF_COMMANDS; do
    unset IFS
    id=$(echo "$full_cmd" | sed 's/\(.*\) | .*/\1/')
    cmd=$(echo "$full_cmd" | sed 's/.* | \(.*\)/\1/')
    ./yii ${cmd}
    ./yii queue/mark-as-processed ${id}
done
