#!/bin/bash

set -e

REPORT_DIR="reports"
mkdir -p "$REPORT_DIR"

echo "========================================"
echo "Trivy Security Scan"
echo "========================================"
echo

IMAGES=$(docker images --format "{{.Repository}}:{{.Tag}}" | grep -v "<none>")

for IMAGE in $IMAGES; do
    SAFE_NAME=$(echo "$IMAGE" | sed 's#[/:]#-#g')

    echo "Scanning $IMAGE..."

    docker run --rm \
        -v /var/run/docker.sock:/var/run/docker.sock:ro \
        -v trivy-cache:/root/.cache \
        -v "$(pwd)/$REPORT_DIR:/reports" \
        aquasec/trivy:latest image \
        --severity HIGH,CRITICAL \
        --ignore-unfixed \
        --format json \
        --output "/reports/${SAFE_NAME}.json" \
        "$IMAGE"

    docker run --rm \
        -v /var/run/docker.sock:/var/run/docker.sock:ro \
        -v trivy-cache:/root/.cache \
        -v "$(pwd)/$REPORT_DIR:/reports" \
        aquasec/trivy:latest image \
        --severity HIGH,CRITICAL \
        --ignore-unfixed \
        --format table \
        --output "/reports/${SAFE_NAME}.txt" \
        "$IMAGE"

    echo "✓ $IMAGE"
    echo
done

echo "All scans completed."

echo "Importing results..."
./scripts/security/import-trivy.sh

echo "Done."
