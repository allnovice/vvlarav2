#!/bin/bash

REPORT_DIR="./reports"

SCAN_ID=$(date +%Y%m%d-%H%M%S)

for report in "$REPORT_DIR"/*.json; do

    IMAGE_NAME=$(jq -r '.ArtifactName' "$report")

    HIGH_COUNT=$(jq '[.Results[]?.Vulnerabilities[]? | select(.Severity=="HIGH")] | length' "$report")

    CRITICAL_COUNT=$(jq '[.Results[]?.Vulnerabilities[]? | select(.Severity=="CRITICAL")] | length' "$report")



if [ "$CRITICAL_COUNT" -gt 0 ]; then
    STATUS="FAIL"
elif [ "$HIGH_COUNT" -gt 0 ]; then
    STATUS="WARN"
else
    STATUS="PASS"
fi

docker exec vvlarav2-db mariadb \
    -u root \
    -p11111111 \
    soc \
    -e "INSERT INTO vulnerability_scans
        (scan_id, image_name, high_count, critical_count, scan_status)
        VALUES
        ('$SCAN_ID', '$IMAGE_NAME', $HIGH_COUNT, $CRITICAL_COUNT, '$STATUS');"
done
